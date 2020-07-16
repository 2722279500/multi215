<?php

namespace app\store\controller\apps\merchant;

use app\store\controller\Controller;
use app\store\model\merchant\Finance as FinanceModel;

/**
 * 商家收支
 * Class Finance
 * @package app\store\controller\apps\merchant
 */
class Finance extends Controller
{
	public function index()
	{
		$model = new FinanceModel();
        $list = $model->getList("'全部收支列表', 'all'");
        return $this->fetch('index',compact('list'));
	}
}