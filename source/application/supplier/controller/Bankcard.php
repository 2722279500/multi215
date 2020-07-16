<?php

namespace app\supplier\controller;

use app\supplier\model\Bankcard as BankcardModel;

/**
 * 银行卡管理控制器
 * Class Bankcard
 * @package app\supplier\controller
 */
class Bankcard extends Controller
{
    /**
     * 银行卡列表
     * @return mixed
     */
    public function index()
    {
        $model = new BankcardModel();
        $list = $model->getList();
        return $this->fetch('index',compact('list'));
    }
    /**
     * 银行卡列表添加
     * @return mixed
     */
    public function add()
    {
        $model = new BankcardModel();
        $info = $model->add();
        return $this->fetch('add',compact('info'));
    }
    /**
     * 银行卡列表添加
     * @return mixed
     */
    public function del()
    {
        $model = new BankcardModel();
        $info = $model->del();
    }

}