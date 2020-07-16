<?php

namespace app\supplier\model;

use app\common\model\Order as OrderModel;
use think\Request;
use think\Session;
use think\Db;

/**
 * 订单明细管理控制器
 * Class Coupon
 * @package app\supplier\model
 */
class Withdraw extends OrderModel
{
    public static $supplier_id;
    public static $yoshop_supplier;
    /**
     * 模型基类初始化
     */
    public static function init()
    {
        parent::init();
        self::$yoshop_supplier = Session::get("yoshop_supplier.user");
        self::$supplier_id = self::$yoshop_supplier['supplier_user_id'];
    }
    /**
     * 获取当前商户的提现列表
     */
	public function getList($dataType, $query = [])
	{
		$list = Db::name("merchant_balance_log")
                ->field("id,money,describe,scene,create_time")
				->where(['supplier_id'=>self::$supplier_id])
                ->where("scene","in",[30,40])
                ->order("id DESC,scene ASC")
                // ->fetchSql(true)
				->paginate(10, false, [
              'query' => \request()->request()
          ]);
        return $list;
	}
	/**
     * 转义数据类型条件
     * @param $dataType
     * @return array
     */
    private function transferDataType($dataType)
    {
        // 数据类型
        $filter = [];
        switch ($dataType) {
            case 'delivery':
                $filter = [
                    'pay_status' => 20,
                    'delivery_status' => 10,
                    'order_status' => ['in', [10, 21]]
                ];
                break;
            case 'receipt':
                $filter = [
                    'pay_status' => 20,
                    'delivery_status' => 20,
                    'receipt_status' => 10
                ];
                break;
            case 'pay':
                $filter = ['pay_status' => 10, 'order_status' => 10];
                break;
            case 'complete':
                $filter = ['order_status' => 30];
                break;
            case 'cancel':
                $filter = ['order_status' => 20];
                break;
            case 'all':
                $filter = [];
                break;
        }
        return $filter;
    }
    /**
    *提交提现
    */
    public function add($post)
    {
        //验证  唯一规则： 表名，字段名，排除主键值，主键名
        $validate = new \think\Validate([
            ['zh', 'require', '账号不能为空'],
            ['je', 'require|number|egt:0.01', '金额不能为空|金额只能是数字|金额必须小于等于0.01'],
            ['bz', 'require|chsAlphaNum', '备注不能为空|只能是汉字、字母和数字'],
        ]);
        //验证部分数据合法性
        if (!$validate->check($post)) {
            exit(json_encode(['code'=>0,'msg'=>'提交失败：' . $validate->getError()]));
        }
        if(true == Db::name("merchant_balance_log")->where(['supplier_id'=>self::$supplier_id,'scene'=>30])->find())
        {
            exit(json_encode(['code'=>0,'msg'=>'提交失败:只允许提交一个审核提现']));
        }
        $data['supplier_id'] = self::$supplier_id;
        $data['create_time'] = time();
        $data['money'] = sprintf("%.2f",$post['je']);
        $data['scene'] = 30;
        $data['wxapp_id'] = self::$yoshop_supplier['wxapp_id'];
        $data['describe'] = json_encode(['apply'=>['zh'=>htmlentities(htmlentities($post['zh'])),'je'=>htmlentities(htmlentities($post['je'])),'bz'=>htmlentities(htmlentities($post['bz']))]]);
        $moneyCount = sprintf("%.2f",citrixGetSupplierMoneyCount(self::$supplier_id));
        if($data['money']*100 > $moneyCount*100)
        {
            exit(json_encode(['code'=>0,'msg'=>"提交失败：当前可以提现￥{$moneyCount}"]));
        }
        if(true == Db::name("merchant_balance_log")->insert($data))
        {
            exit(json_encode(['code'=>1,'msg'=>'提交成功：等待审核']));
        }
        exit(json_encode(['code'=>0,'msg'=>'提交失败']));
    }
}