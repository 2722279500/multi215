<?php
// +----------------------------------------------------------------------
// | tpCitrix [ WE ONLY DO WHAT IS NECESSARY ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://tpCitrix.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: tpCitrix < 2722279500@qq.com >
// +----------------------------------------------------------------------

namespace app\supplier\model;
use \think\Db;
use \think\Model;
use \think\Session;
class Index extends Model
{
	public static $supplier_id;
	public static $wxapp_id;
	public static $yoshop_supplier;
    /**
     * 模型基类初始化
     */
    public static function init()
    {
        parent::init();
        self::$yoshop_supplier = Session::get("yoshop_supplier.user");
        self::$supplier_id = self::$yoshop_supplier['supplier_user_id'];
        self::$wxapp_id = self::$yoshop_supplier['wxapp_id'];

    }
    /**
     * 本日财务收支
     * @return mixed
     */
	public function getDay()
	{
		//> 大于
		//<= 小于等于
		$day_str_time = strtotime(date("Y-m-d 00:00:00",time()));
		$day_end_time = strtotime(date("Y-m-d 23:59:59",time()));
		$day_money = Db::name("merchant_balance_log")
				->where(['scene'=>10,'wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
				->where('create_time','> time',$day_str_time)
				->where('create_time','<= time',$day_end_time)
				->sum("money");


		$past_str_time = strtotime(date("Y-m-d 00:00:00",time()-86400));
		$past_end_time = strtotime(date("Y-m-d 23:59:59",time()-86400));
		$past_money = Db::name("merchant_balance_log")
				->where(['scene'=>10,'wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
				->where('create_time','> time',$past_str_time)
				->where('create_time','<= time',$past_end_time)
				->sum("money");

		return ['day_money'=>$day_money,'past_money'=>$past_money];
	}
    /**
     * 本周财务收支
     * @return mixed
     */
	public function getWeek()
	{  
		//> 大于
		//<= 小于等于
		$upper_lastMonday = citrixGetLastMonday();//计算上周一的时间戳
		$upper_lastSunday = citrixGetLastSunday();//计算上周日的时间戳
		$book_lastMonday = date("Y-m-d 00:00:00",strtotime($upper_lastMonday)+(86400*7));//计算上周一的时间戳
		$book_lastSunday = date("Y-m-d 23:59:59",strtotime($upper_lastSunday)+(86400*7));//计算上周日的时间戳

		$week_money = Db::name("merchant_balance_log")
				->where(['scene'=>10,'wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
				->where('create_time','> time',$book_lastMonday)
				->where('create_time','<= time',$book_lastSunday)
				->sum("money");

		$past_money = Db::name("merchant_balance_log")
				->where(['scene'=>10,'wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
				->where('create_time','> time',$upper_lastMonday)
				->where('create_time','<= time',$upper_lastSunday)
				->sum("money");

		return ['week_money'=>$week_money,'past_money'=>$past_money];
	}
    /**
     * 本月财务收支
     * @return mixed
     */
	public function getMonth()
	{
        //> 大于
		//<= 小于等于
        $lastMonthFirstDay   = strtotime(citrixGetLastMonthFirstDay());   //计算出上个月第一天
        $lastMonthTheLastDay = strtotime(citrixGetLastMonthTheLastDay()); //计算出上个月最后一天 
        $thisMonthFirstDay   = strtotime(citrixGetThisMonthFirstDay());   //计算出本月第一天   
        $thisMonthTheLastDay = strtotime(citrixGetThisMonthTheLastDay()); //计算出本月最后一天   
		$month_money = Db::name("merchant_balance_log")
				->where(['scene'=>10,'wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
				->where('create_time','> time',$thisMonthFirstDay)
				->where('create_time','<= time',$thisMonthTheLastDay)
				->sum("money");

		$past_money = Db::name("merchant_balance_log")
				->where(['scene'=>10,'wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
				->where('create_time','> time',$lastMonthFirstDay)
				->where('create_time','<= time',$lastMonthTheLastDay)
				->sum("money");
		return ['month_money'=>$month_money,'past_money'=>$past_money];
	}
    /**
     * 近七日交易走势
     * @return mixed
     */
	public function getSevenList()
	{
		$supplier_id = self::$supplier_id;
		$prefix = config("database.prefix");
		##########################################################################
		$str_one   = strtotime(date("Y-m-d 00:00:00",time()));
		$str_two   = strtotime(date("Y-m-d 00:00:00",time()-(86400)));
		$str_three = strtotime(date("Y-m-d 00:00:00",time()-(86400*2)));
		$str_four  = strtotime(date("Y-m-d 00:00:00",time()-(86400*3)));
		$str_five  = strtotime(date("Y-m-d 00:00:00",time()-(86400*4)));
		$str_six   = strtotime(date("Y-m-d 00:00:00",time()-(86400*5)));
		$str_seven = strtotime(date("Y-m-d 00:00:00",time()-(86400*6)));
		##########################################################################
		$end_one   = strtotime(date("Y-m-d 23:59:59",time()));
		$end_two   = strtotime(date("Y-m-d 23:59:59",time()-(86400)));
		$end_three = strtotime(date("Y-m-d 23:59:59",time()-(86400*2)));
		$end_four  = strtotime(date("Y-m-d 23:59:59",time()-(86400*3)));
		$end_five  = strtotime(date("Y-m-d 23:59:59",time()-(86400*4)));
		$end_six   = strtotime(date("Y-m-d 23:59:59",time()-(86400*5)));
		$end_seven = strtotime(date("Y-m-d 23:59:59",time()-(86400*6)));
		##########################################################################
		$one_money 	= Db::name("merchant_balance_log")
								->where(['scene'=>10,'wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
								->where('create_time','> time',$str_one)
								->where('create_time','<= time',$end_one)
								->sum("money");
		$two_money  = Db::name("merchant_balance_log")
								->where(['scene'=>10,'wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
								->where('create_time','> time',$str_two)
								->where('create_time','<= time',$end_two)
								->sum("money");
		$three_money= Db::name("merchant_balance_log")
								->where(['scene'=>10,'wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
								->where('create_time','> time',$str_three)
								->where('create_time','<= time',$end_three)
								->sum("money");
		$four_money = Db::name("merchant_balance_log")
								->where(['scene'=>10,'wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
								->where('create_time','> time',$str_four)
								->where('create_time','<= time',$end_four)
								->sum("money");
		$five_money = Db::name("merchant_balance_log")
								->where(['scene'=>10,'wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
								->where('create_time','> time',$str_five)
								->where('create_time','<= time',$end_five)
								->sum("money");
		$six_money  = Db::name("merchant_balance_log")
								->where(['scene'=>10,'wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
								->where('create_time','> time',$str_six)
								->where('create_time','<= time',$end_six)
								->sum("money");
		$seven_money= Db::name("merchant_balance_log")
								->where(['scene'=>10,'wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
								->where('create_time','> time',$str_seven)
								->where('create_time','<= time',$end_seven)
								->sum("money");
		##########################################################################
		$one_sum    = Db::name("order_goods")
								->where(['wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
								->where('create_time','> time',$str_one)
								->where('create_time','<= time',$end_one)
								->sum("total_num");
		$two_sum    = Db::name("order_goods")
								->where(['wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
								->where('create_time','> time',$str_two)
								->where('create_time','<= time',$end_two)
								->sum("total_num");
		$three_sum  = Db::name("order_goods")
								->where(['wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
								->where('create_time','> time',$str_three)
								->where('create_time','<= time',$end_three)
								->sum("total_num");
		$four_sum   = Db::name("order_goods")
								->where(['wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
								->where('create_time','> time',$str_four)
								->where('create_time','<= time',$end_four)
								->sum("total_num");
		$five_sum   = Db::name("order_goods")
								->where(['wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
								->where('create_time','> time',$str_five)
								->where('create_time','<= time',$end_five)
								->sum("total_num");
		$six_sum    = Db::name("order_goods")
								->where(['wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
								->where('create_time','> time',$str_six)
								->where('create_time','<= time',$end_six)
								->sum("total_num");
		$seven_sum  = Db::name("order_goods")
								->where(['wxapp_id'=>self::$wxapp_id,'supplier_id'=>self::$supplier_id])
								->where('create_time','> time',$str_seven)
								->where('create_time','<= time',$end_seven)
								->sum("total_num");
		// $data['one'] = ['money'=>$one_money,'sum'=>$one_sum];
		// $data['two'] = ['money'=>$two_money,'sum'=>$two_sum];
		// $data['three'] = ['money'=>$three_money,'sum'=>$three_sum];
		// $data['four'] = ['money'=>$four_money,'sum'=>$four_sum];
		// $data['five'] = ['money'=>$five_money,'sum'=>$five_sum];
		// $data['six'] = ['money'=>$six_money,'sum'=>$six_sum];
		// $data['seven'] = ['money'=>$seven_money,'sum'=>$seven_sum];
		$data['turnover'] = "$one_money,$two_money,$three_money,$four_money,$five_money,$six_money,$seven_money";
		$data['volume'] = "$one_sum,$two_sum,$three_sum,$four_sum,$five_sum,$six_sum,$seven_sum";
		return $data;

	}
    /**
     * 热销商品
     * @return mixed
     */
	public function getSellWellList()
	{
		$supplier_id = self::$supplier_id;
		$prefix = config("database.prefix");
		$list = Db::query("SELECT DISTINCT count( * ) AS count ,`goods_id`,`goods_name`,sum(total_num) as sum	FROM {$prefix}order_goods  
				WHERE  `supplier_id` = {$supplier_id}
				GROUP BY goods_id  
				ORDER BY count DESC  
				LIMIT 6 ");
		return $list;
	}
    /**
     * 消费日志
     * @return mixed
     */
	public function getConsumeList()
	{
		$list = Db::name("merchant_balance_log")
        		->field("id,money,scene,create_time,order_id,order_refund_id")
				->where(['supplier_id'=>self::$supplier_id])
                ->where("scene","in",[10,20,50])
                ->order("id DESC,scene ASC")
                ->limit(0,6)
                ->select()->toArray();
        return $list;
	}

}