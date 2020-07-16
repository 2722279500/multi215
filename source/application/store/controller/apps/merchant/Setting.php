<?php

namespace app\store\controller\apps\merchant;

use app\store\controller\Controller;
use app\store\model\merchant\Setting as SettingModel;

/**
 * 商家设置
 * Class Setting
 * @package app\store\controller\apps\merchant
 */
class Setting extends Controller
{
    /**
     * 商家设置
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        if (!$this->request->isAjax()) {
            $values = SettingModel::getItem('basic');
            return $this->fetch('index', compact('values'));
        }
        $model = new SettingModel;
        $param = $this->postData('basic');
        if(citrixCheckFullPackage())
        {
            $param['is_dealer'] = 0;
            $param['is_open'] = 0;
            if ($model->edit('basic', $param)) 
            {
                return $this->renderError('请先关闭满额包邮后,开启多商户');
            }
        }else
        {
            if ($model->edit('basic', $this->postData('basic'))) {
                return $this->renderSuccess('更新成功');
            }
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

}