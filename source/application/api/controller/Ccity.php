<?php

namespace app\api\controller;

use app\api\model\Ccity as CcityModel;

/**
 * 多商戶城市管理
 * Class Ccity
 * @package app\api\controller
 */
class Ccity extends Controller
{

    /**
     * 根据城市获取城市id
     * @return array
     */
    public function cinfo()
    {
        // 请求参数
        $model = new CcityModel;
        $param = $this->request->param();
        $cinfo = $model->cinfo($param);
        return $this->renderSuccess($cinfo);
    }
    /**
     * 获取多商户列表中所有的城市
     * @return array
    */
    public function getCityList()
    {
        // 请求参数
        $model = new CcityModel;
        $param = $this->request->param();
        $getCityList = $model->getCityList($param);
        return $this->renderSuccess($getCityList);
    }
}
