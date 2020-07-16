<?php

namespace app\store\model\merchant;

use think\Cache;
use think\Db;
use \think\Model;

/**
 * 商家收支
 * Class Finance
 * @package app\store\model\merchant
 */
class Finance extends model
{
	/**
     * 获取当前商户的历史金额
     */
	public function getList($dataType, $query = [])
	{
		$list = Db::name("merchant_balance_log")
                ->field("id,supplier_id,money,describe,scene,create_time")
        				->where("scene","in",[10,20])
                        ->order("id DESC,scene ASC")
        				->paginate(15, false, [
                      'query' => \request()->request()
                  ])->each(function($item, $key){
            $item['supplier_name'] = Db::name("merchant_active")->where(['active_id'=>$item['supplier_id']])->value("name");
            return $item;
        });        
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