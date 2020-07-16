<?php

namespace app\supplier\controller\supplier;

use app\supplier\controller\Controller;
use app\supplier\model\supplier\User as supplierUserModel;
use app\store\model\merchant\Category as CategoryModel;
use think\Db;

/**
 * 超管后台管理员控制器
 * Class User
 * @package app\store\controller
 */
class User extends Controller
{
    /**
     * 更新当前管理员信息
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function renew()
    {
        // $model = supplierUserModel::detail($this->supplier['user']['supplier_user_id']);
        $model = \think\Db::name("merchant_active")->where([
            'active_id' => $this->supplier['user']['supplier_user_id']
        ])->find();

        $model['image'] = Db::name("upload_file")->field("file_id,file_name")->where("file_id",$model['image_id'])->find();
        $model['thumb'] = Db::name("upload_file")->field("file_id,file_name")->where("file_id",$model['thumb_id'])->find();

        // 商品分类
        $catgory = CategoryModel::getCacheTree();
        $m = new supplierUserModel();

        if ($this->request->isAjax()) {
            if ($m->renew($this->postData('active'))) {
                return $this->renderSuccess('更新成功');
            }
            return $this->renderError($model->getError() ?: '更新失败');
        }
        return $this->fetch('renew', compact('model','catgory'));
    }


    
}
