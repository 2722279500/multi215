<?php

namespace app\store\controller\apps\merchant;

use app\store\controller\Controller;
use app\store\model\merchant\Active as ActiveModel;
use app\store\model\merchant\Category as CategoryModel;
use think\Db;

/**
 * 多商家列表
 * Class Active
 * @package app\store\controller\apps\merchant
 */
class Active extends Controller
{
    /**
     * 多商家列表
     * @param string $search
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index($search = '')
    {
        $model = new ActiveModel;
        $list = $model->getList($this->request->param());
        // 商品分类
        $catgory = CategoryModel::getCacheTree();
        return $this->fetch('index', compact('list','catgory'));
    }

    /**
     * 新增商家
     * @return array|bool|mixed
     */
    public function add()
    {
        if (!$this->request->isAjax()) {
            // 商品分类
            $catgory = CategoryModel::getCacheTree();
            return $this->fetch('add',compact('catgory'));
        }
        $model = new ActiveModel;
        // 新增记录
        if ($model->add($this->postData('active'))) {
            return $this->renderSuccess('添加成功', url('apps.merchant.active/index'));
        }
        return $this->renderError($model->getError() ?: '添加失败');
    }

    /**
     * 更新商家
     * @param $active_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function edit($active_id)
    {
        // 商家详情
        $model = ActiveModel::detail($active_id);
        $model['image'] = Db::name("upload_file")->field("file_id,file_name")->where("file_id",$model['image_id'])->find();
        $model['thumb'] = Db::name("upload_file")->field("file_id,file_name")->where("file_id",$model['thumb_id'])->find();
        if (!$this->request->isAjax()) 
        {
            // 商品分类
            $catgory = CategoryModel::getCacheTree();
            // 商家详情
            return $this->fetch('edit', compact('model', 'catgory'));

            // return $this->fetch('edit', compact('model', $model));
        }
        // 更新记录
        if ($model->edit($this->postData('active'))) {
            return $this->renderSuccess('更新成功', url('apps.merchant.active/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

    /**
     * 删除商家
     * @param $active_id
     * @return array
     * @throws \think\exception\DbException
     */
    public function delete($active_id)
    {
        // 商家详情
        $model = ActiveModel::detail($active_id);
        if (!$model->setDelete()) {
            return $this->renderError($model->getError() ?: '删除失败');
        }
        return $this->renderSuccess('删除成功');
    }

    /**
     * 腾讯地图坐标选取器
     * @return mixed
     */
    public function getpoint()
    {
        $this->view->engine->layout(false);
        return $this->fetch('getpoint');
    }

}