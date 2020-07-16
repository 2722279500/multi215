<?php

namespace app\supplier\controller;

use app\supplier\model\Withdraw as WithdrawModel;
use app\supplier\model\Bankcard as BankcardModel;

/**
 * 提现管理控制器
 * Class Withdraw
 * @package app\supplier\controller
 */
class Withdraw extends Controller
{
	/**
     * 提现列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new WithdrawModel();
        $list = $model->getList("'全部订单列表', 'all'");
        $supplier_user = \think\Session::get("yoshop_supplier.user");

        $m = new BankcardModel();
        $bankcard = $m->getList();

        return $this->fetch('index',compact('list','supplier_user','bankcard'));
    }
    public function add()
    {
        $model = new WithdrawModel();
        $model->add($this->request->post());
    }

}