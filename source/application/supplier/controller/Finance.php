<?php

namespace app\supplier\controller;

use app\supplier\model\Finance as FinanceModel;

/**
 * 订单明细管理控制器
 * Class Finance
 * @package app\supplier\controller
 */
class Finance extends Controller
{
	/**
     * 提现列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new FinanceModel();
        $list = $model->getList("'全部订单明细列表', 'all'");
        return $this->fetch('index',compact('list'));
    }

}