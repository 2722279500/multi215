<?php

namespace app\api\model;

use think\Cache;
use think\Db;

/**
 * 多商户收支
 * @package app\api\model
 */
class SupplierLog
{
	/**
     * 构造方法
     * Cart constructor.
     * @param \think\Model|\think\Collection $user
     */
    public function __construct($order_id)
    {
    	$this->order_id = $order_id;
    	$this->order_info = $this->getOrderInfo("order_id,total_price,order_price,coupon_money,points_money,points_num,coupon_id,wxapp_id,is_ind_dealer,dealer_money_type,first_money,second_money,third_money");
    	$this->order_goods_list = $this->getOrderGoodsList("order_goods_id,order_id,goods_id,goods_name,goods_price,is_user_grade,grade_ratio,grade_goods_price,grade_total_money,coupon_money,points_money,points_num,points_bonus,total_num,total_price,total_pay_price,is_ind_dealer,dealer_money_type,first_money,second_money,third_money,express_price,supplier_id");
    	$this->order_goods_supplier_list = $this->getOrderGoodsSupplierList();
    }
    /**
     * 获取当前订单
     */
    public function getOrderInfo($field = "*")
    {
    	return Db::name("order")->field($field)->where(['order_id'=>$this->order_id])->find();
    }
    /**
     * 获取当前订单内的商品
     */
    public function getOrderGoodsList($field = "*")
    {
    	return Db::name("order_goods")->field($field)->where(['order_id'=>$this->order_id])->select()->toArray();
    }
    /**
     * 获取当前订单内的商户
     */
    public function getOrderGoodsSupplierList()
    {
    	return Db::name("order_goods")
                    ->where(['order_id'=>$this->order_id])
                    ->where("supplier_id",">=",1)
                    ->group("supplier_id")
                    ->column("supplier_id");
    }
    /**
     * 计算这个订单,商户订单商品分销
     */
    public function calculationDistribution($order_id,$supplier_id)
    {
    	$list = Db::name("order_goods")->field("order_goods_id,order_id,supplier_id,is_ind_dealer,dealer_money_type,first_money,second_money,third_money,total_price,coupon_money")->where(['order_id'=>$order_id,'supplier_id'=>$supplier_id])->select()->toArray();
    	$checkisIndDealer =	$this->checkOrderisIndDealer($this->order_info);
    	$result = 0.00;
    	foreach ($list as $k1 => $v1) 
    	{
    		if(!empty($checkisIndDealer) && !empty($checkisIndDealer['is_open']))
    		{
    			if($list[$k1]['is_ind_dealer'] == true)
	    		{
	    			$result += $this->handleSingle($list[$k1]);
	    		}else
	    		{
	    			$result += $this->handleOrderMany($this->order_info);
	    		}
    		}
    	}
    	return $result;
    }
    /**
     * 检查是否开启了分销
     */
    public function checkisIndDealer()
    {
        if($info = Db::name("dealer_setting")->where(['key'=>'basic'])->find())
        {
            $info['values'] = json_decode($info['values'],true);
            return $info['values'];
        }
        return false;
    }
    /**
     * 检查是否订单开启了分销
     */
    public function checkOrderisIndDealer($order_info)
    {
        return ['is_open'=>$order_info['is_ind_dealer']];
    }
    /**
     * 获取分销配置
     */
    public function getDealerCommission()
    {
    	if($info = Db::name("dealer_setting")->where(['key'=>'commission'])->find())
    	{
    		$info['values'] = json_decode($info['values'],true);
    		return $info['values'];
    	}
    	return false;
    }
    /**
     * 使用商品单独设置的分销
     */
    public function handleSingle($info)
    {
        switch ($info['dealer_money_type']) 
        {
            case 10://百分百
                $money = $info['total_price']-$info['coupon_money'];
                return sprintf("%.2f",$money*($info['first_money']/100)+$money*($info['second_money']/100)+$money*($info['third_money']/100));
                break;
            default://固定的
                return sprintf("%.2f",$info['first_money']+$info['second_money']+$info['third_money']);
                break;
        }
        return sprintf("%.2f",0);
    }
    /**
     * 使用订单设置的分销
     */
    public function handleOrderMany($info)
    {
        switch ($info['dealer_money_type']) 
        {
            case 10://百分百
                $money = $info['total_price']-$info['coupon_money'];
                return sprintf("%.2f",$money*($info['first_money']/100)+$money*($info['second_money']/100)+$money*($info['third_money']/100));
                break;
            default://固定的
                return sprintf("%.2f",$info['first_money']+$info['second_money']+$info['third_money']);
                break;
        }
        return sprintf("%.2f",0);
    }
    /**
     * 使用系统设置的分销
     */
	public function handleMany($info,$sys)
	{
		$money = $info['total_price']-$info['coupon_money'];
		$commission = $this->getDealerCommission();
		$commission['first_money'] = empty($commission['first_money'])?0:$commission['first_money'];
		$commission['second_money'] = empty($commission['second_money'])?0:$commission['second_money'];
		$commission['third_money'] = empty($commission['third_money'])?0:$commission['third_money'];
		switch ($sys['level']) 
		{
			case 1:
    			return sprintf("%.2f",$money*($commission['first_money']/100));
				break;
			case 2:
    			return sprintf("%.2f",$money*($commission['first_money']/100)+$money*($commission['second_money']/100));
				break;
			case 3:
    			return sprintf("%.2f",$money*($commission['first_money']/100)+$money*($commission['second_money']/100)+$money*($commission['third_money']/100));
				break;
			default:
    			return sprintf("%.2f",0);
				break;
		}
    	return sprintf("%.2f",0);
	}
    /**
     * 检查优惠劵所属
     */
	public function checkCouponBelonging()
	{
		if(empty($this->order_info['coupon_id']))
		{
			return false;
		}
		$info = Db::name("user_coupon")->field("supplier_id,coupon_id")->where(['user_coupon_id'=>$this->order_info['coupon_id']])->find();
		if(empty($info['supplier_id']))
		{
			return 1;
		}
		return 2;
	}
    /**
     * 获取商户分销信息
     */
	public function getSupplierRebate($supplier_id)
	{
		return Db::name("merchant_active")->where(['active_id'=>$supplier_id])->value("supplier_rebate");
	}
    /**
     * 获取优惠券类型
     */
    public function getCouponType($coupon_id = 0)
    {
        if($info = Db::name("user_coupon")->where(['user_coupon_id'=>$coupon_id])->find())
        {
            switch ($info['coupon_type']) {
                case 10://10满减券
                    return "满{$info['min_price']}减{$info['reduce_price']}";
                    break;
                case 20://20折扣券
                    return ($info['discount']/10)."折";
                    break;
                default:
                    break;
            }
        }
        return "<span style='color:#f00;'>...</span>";
    }
    ##################################################################
    /**
     * 添加
     */
    public function addBalanceLog()
    {
    	$list = $this->order_goods_supplier_list;
    	$db = Db::name("order_goods");
    	$log = Db::name("merchant_balance_log");
    	foreach ($list as $k1 => $v1) 
    	{
            $info = $db->where(['order_id'=>$this->order_id,'supplier_id'=>$list[$k1]])
                    ->field("sum(total_price) as total_price,sum(coupon_money) as coupon_money,express_price")
                    ->select(); 
            $total_price = $info[0]['total_price'];
            $coupon_money = $info[0]['coupon_money'];//优惠券折扣金额
            $express_price = $info[0]['express_price'];//运费金额
            $coupon_money = citrixCheckCouponMoney($this->order_id,$list[$k1])?$coupon_money:0.00;
            $belonging = $this->checkCouponBelonging();//优惠券归属
            $distribution = $this->calculationDistribution($this->order_id,$list[$k1]);//分销
            $rebate = $this->getSupplierRebate($list[$k1]);
            $name = citrixDb("merchant_active","active_id",$list[$k1],"name");
            switch ($belonging) 
            {
                case 1:
                    $money_fx = sprintf("%.2f",$distribution);//分销
                    $money_cc = ($total_price - $money_fx)*($rebate/100);//抽成金额
                    $money = $total_price-(($total_price-$money_fx)*($rebate/100))+$express_price;//订单金额
                    $compensate = '优惠劵补偿￥'.sprintf("%.2f",0);//优惠券补偿
                    $ascription = "优惠劵所属：<span style='color: #f00;'>{$name}</span>";//优惠券归属
                    $type = '优惠券类型：'.$this->getCouponType($this->order_info['coupon_id']);//优惠券类型
                    break;
                case 2:
                    $money_fx = sprintf("%.2f",$distribution);//分销
                    $money_cc = ($total_price - $money_fx)*($rebate/100);//抽成金额
                    $money = $total_price-(($total_price-$money_fx)*($rebate/100))+$express_price+$coupon_money;//订单金额
                    $compensate = '优惠劵补偿￥'.sprintf("%.2f",$info[0]['coupon_money']);//优惠券补偿
                    $ascription = "优惠劵所属：<span style='color: #5eb95e;'>平台</span>";//优惠券归属
                    $type = '优惠券类型：'.$this->getCouponType($this->order_info['coupon_id']);//优惠券类型
                    break;
                default:
                    $money_fx = sprintf("%.2f",$distribution);//分销
                    $money_cc = ($total_price - $money_fx)*($rebate/100);//抽成金额
                    $money = $total_price-(($total_price-$money_fx)*($rebate/100))+$express_price;//订单金额
                    $compensate = '优惠劵补偿￥'.sprintf("%.2f",0);//优惠券补偿
                    $ascription = "优惠劵所属：...";//优惠券归属
                    $type = '优惠券类型：'."...";//优惠券类型
                    break;
            }
            $data = [
                'money'=>sprintf("%.2f",$money),
                'supplier_id' =>$list[$k1],
                'scene'=>10,
                'wxapp_id'=>$this->order_info['wxapp_id'],
                'create_time'=>time(),
                'order_id'=>$this->order_id,
                'describe'=>implode("   ",[
                    '抽成比例 '.sprintf("%.2f",$money_cc).'元 ('.$rebate."%)",
                    '商品总价￥'.sprintf("%.2f",$total_price),
                    '分销扣除￥'.sprintf("%.2f",$distribution),
                    '优惠劵抵扣￥'.sprintf("%.2f",$coupon_money),
                    '运费￥'.sprintf("%.2f",$express_price),
                    $compensate,
                    $ascription,
                    $type,
                    ])
                ];
            $log->insert($data);
    	}
    }
    /**
     * 获取
     */
    public function getBalanceLog($supplier_id)
    {
        $list = $this->order_goods_supplier_list;
        $db = Db::name("order_goods");
        $log = Db::name("merchant_balance_log");
        foreach ($list as $k1 => $v1) 
        {
            $info = $db->where(['order_id'=>$this->order_id,'supplier_id'=>$list[$k1]])
                    ->field("sum(total_price) as total_price,sum(coupon_money) as coupon_money,express_price")
                    ->select(); 
            $total_price = $info[0]['total_price'];
            $coupon_money = $info[0]['coupon_money'];//优惠券折扣金额
            $express_price = $info[0]['express_price'];//运费金额
            $coupon_money = citrixCheckCouponMoney($this->order_id,$list[$k1])?$coupon_money:0.00;
            $belonging = $this->checkCouponBelonging();//优惠券归属
            $distribution = $this->calculationDistribution($this->order_id,$list[$k1]);//分销
            $rebate = $this->getSupplierRebate($list[$k1]);
            $name = citrixDb("merchant_active","active_id",$supplier_id,"name");
            switch ($belonging) 
            {
                case 1:
                    $money_fx = sprintf("%.2f",$distribution);//分销
                    $money_cc = ($total_price - $money_fx)*($rebate/100);//抽成金额
                    $money = $total_price-(($total_price-$money_fx)*($rebate/100))+$express_price;//订单金额
                    $compensate = '优惠劵补偿￥'.sprintf("%.2f",0);//优惠券补偿
                    $ascription = "优惠劵所属：<span style='color: #f00;'>{$name}</span>";//优惠券归属
                    $type = '优惠券类型：'.$this->getCouponType($this->order_info['coupon_id']);//优惠券类型
                    break;
                case 2:
                    $money_fx = sprintf("%.2f",$distribution);//分销
                    $money_cc = ($total_price - $money_fx)*($rebate/100);//抽成金额
                    $money = $total_price-(($total_price-$money_fx)*($rebate/100))+$express_price+$coupon_money;//订单金额
                    $compensate = '优惠劵补偿￥'.sprintf("%.2f",$info[0]['coupon_money']);//优惠券补偿
                    $ascription = "优惠劵所属：<span style='color: #5eb95e;'>平台</span>";//优惠券归属
                    $type = '优惠券类型：'.$this->getCouponType($this->order_info['coupon_id']);//优惠券类型
                    break;
                default:
                    $money_fx = sprintf("%.2f",$distribution);//分销
                    $money_cc = ($total_price - $money_fx)*($rebate/100);//抽成金额
                    $money = $total_price-(($total_price-$money_fx)*($rebate/100))+$express_price;//订单金额
                    $compensate = '优惠劵补偿￥'.sprintf("%.2f",0);//优惠券补偿
                    $ascription = "优惠劵所属：...";//优惠券归属
                    $type = '优惠券类型：'."...";//优惠券类型
                    break;
            }
            if($supplier_id == $list[$k1])
            {
                $data = [
                    'money'=>sprintf("%.2f",$money),
                    'supplier_id' =>$list[$k1],
                    'scene'=>10,
                    'wxapp_id'=>$this->order_info['wxapp_id'],
                    'create_time'=>time(),
                    'order_id'=>$this->order_id,
                    'describe'=>[
                        '抽成比例 '.sprintf("%.2f",$money_cc).'元 ('.$rebate."%)",
                        '商品总价￥'.sprintf("%.2f",$total_price),
                        '分销扣除￥'.sprintf("%.2f",$distribution),
                        '优惠劵抵扣￥'.sprintf("%.2f",$coupon_money),
                        '运费￥'.sprintf("%.2f",$express_price),
                        $compensate,
                        $ascription,
                        $type,
                        ]
                    ];
                return $data;
            }
        }
    }
}