<?php

namespace app\supplier\controller\shop;

use app\supplier\controller\Controller;
use app\supplier\model\supplier\Shop as ShopModel;
use app\supplier\model\supplier\shop\Order as OrderModel;

/**
 * 订单核销记录
 * Class Order
 * @package app\supplier\controller\shop
 */
class Order extends Controller
{
    /**
     * 订单核销记录列表
     * @param int $shop_id
     * @param string $search
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index($shop_id = 0, $search = '')
    {
        // 核销记录列表
        $model = new OrderModel;
        $list = $model->getList($shop_id, $search);
        // 门店列表
        $shopList = ShopModel::getAllList();
        return $this->fetch('index', compact('list', 'shopList'));
    }

}