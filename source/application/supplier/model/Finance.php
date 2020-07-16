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
class Finance extends OrderModel
{
	public static $supplier_id;
    /**
     * 模型基类初始化
     */
    public static function init()
    {
        parent::init();
        $yoshop_supplier = Session::get("yoshop_supplier.user");
        self::$supplier_id = $yoshop_supplier['supplier_user_id'];
    }
    /**
     * 获取当前商户的历史金额
     */
	public function getList($dataType, $query = [])
	{
		$list = Db::name("merchant_balance_log")
        ->field("id,money,describe,scene,create_time,order_id,order_refund_id")
				->where(['supplier_id'=>self::$supplier_id])
                ->where("scene","in",[10,20,50])
                ->order("id DESC,scene ASC")
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
}