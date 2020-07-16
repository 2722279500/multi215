<?php

namespace app\api\controller;

use app\api\model\Supplier as SupplierModel;
use app\store\model\merchant\Setting as SettingModel;

/**
 * 多商户管理
 * Class Supplier
 * @package app\api\controller
 */
class Supplier extends Controller
{

    /**
     * 根据城市获取商户列表
     * @return array
     */
    public function getSupplierList()
    {
        // 请求参数
        $model = new SupplierModel;
        $param = $this->request->param();
        $getSupplierList = $model->getSupplierList($param);
        return $this->renderSuccess($getSupplierList);
    }
    /**
     * 根据商户id获取商户详情
     * @return array
     */
    public function getSupplierInfo()
    {
        // 请求参数
        $model = new SupplierModel;
        $param = $this->request->param();
        $getSupplierInfo = $model->getSupplierInfo($param);
        return $this->renderSuccess($getSupplierInfo);
    }
    /**
     * 根据商户id获取商品列表
     * @return array
     */
    public function getSupplierGoodsList()
    {
        // 请求参数
        $model = new SupplierModel;
        $param = $this->request->param();
        $getSupplierGoodsList = $model->getSupplierGoodsList($param);
        return $this->renderSuccess($getSupplierGoodsList);
    }
    /**
     * 获取多商户配置
     * @return array
     */
    public function getSupplierSetting()
    {
        $values = SettingModel::getItem('basic');
        return $this->renderSuccess($values);
    }
}
