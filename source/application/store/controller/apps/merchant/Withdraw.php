<?php

namespace app\store\controller\apps\merchant;

use app\store\controller\Controller;
use app\store\model\merchant\Withdraw as WithdrawModel;

/**
 * 商家提现
 * Class Withdraw
 * @package app\store\controller\apps\merchant
 */
class Withdraw extends Controller
{
	public function index()
	{
		$model = new WithdrawModel();
        $list = $model->getList("'全部提现列表', 'all'");
        return $this->fetch('index',compact('list'));
	}
    public function add()
    {
        $model = new WithdrawModel();
        $model->add($this->request->post());
    }
}