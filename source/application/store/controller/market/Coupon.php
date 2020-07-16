<?php

namespace app\store\controller\market;

use app\store\controller\Controller;
use app\store\model\Coupon as CouponModel;
use app\store\model\UserCoupon as UserCouponModel;
use app\store\model\Category as CategoryModel;
use app\api\model\UserCoupon as UCModel;


/**
 * 优惠券管理
 * Class Coupon
 * @package app\store\controller\market
 */
class Coupon extends Controller
{
    /* @var CouponModel $model */
    private $model;

    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new CouponModel;
    }

    /**
     * 优惠券列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $list = $this->model->getList();
        return $this->fetch('index', compact('list'));
    }

    /**
     * 添加优惠券
     * @return array|mixed
     */
    public function add()
    {
        ################################################################## citrix -start
        $m = new CategoryModel;
        $catelist = $m->getCacheTree();
        if (!$this->request->isAjax()) {
            return $this->fetch('add',compact('catelist'));
        }
        $data = $this->postData('coupon');
        $wxapp_sys = \think\Session::get("yoshop_store.wxapp");
        $storage_sys = \think\Db::name("setting")
                        ->where(['key'=>'storage','wxapp_id'=>$wxapp_sys['wxapp_id']])
                        ->find();
        $storage_sys['values'] = json_decode($storage_sys['values'],true);
        $data['category_'] = [];
        if(!empty($data['category']))
        {
            foreach ($data['category'] as $k1 => $v1) 
            {
                $data['category_'][] = ['id'=>$k1,'name'=>$v1];
            } 
            $data['category_'] = json_encode($data['category_']);
        }
        $data['goods_'] = [];
        if(!empty($data['goods']))
        {
            $path = \request()->domain();
            foreach ($data['goods'] as $k1 => $v1) 
            {
                $img = $data['goods_image'][$k1];
                $img = $storage_sys['values']['default']=='local'?str_replace($path,"",$img):$img;
                $data['goods_'][] = ['id'=>$k1,'name'=>$data['goods_name'][$k1],'image'=>$img];
            }
            $data['goods_'] = json_encode($data['goods_']);
        }
        unset($data['category']);
        unset($data['goods']);
        unset($data['goods_image']);
        unset($data['goods_name']);
        // 新增记录
        if ($this->model->add($data)) {
        ################################################################## citrix-end
            return $this->renderSuccess('添加成功', url('market.coupon/index'));
        }
        return $this->renderError($this->model->getError() ?: '添加失败');
    }

    /**
     * 更新优惠券
     * @param $coupon_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function edit($coupon_id)
    {
        ################################################################## citrix -start
        $m = new CategoryModel;
        $catelist = $m->getCacheTree();
        // 优惠券详情
        $model = CouponModel::detail($coupon_id);
        if (!$this->request->isAjax()) {

            $model['category_'] = empty($model['category_'])?'':json_decode($model['category_'],true);
            $model['goods_'] = empty($model['goods_'])?'':json_decode($model['goods_'],true);
            return $this->fetch('edit', compact('model','catelist'));
        }
        $data = $this->postData('coupon');
        $wxapp_sys = \think\Session::get("yoshop_store.wxapp");
        $storage_sys = \think\Db::name("setting")
                        ->where(['key'=>'storage','wxapp_id'=>$wxapp_sys['wxapp_id']])
                        ->find();
        $storage_sys['values'] = json_decode($storage_sys['values'],true);
        $data['category_'] = [];
        if(!empty($data['category']))
        {
            foreach ($data['category'] as $k1 => $v1) 
            {
                $data['category_'][] = ['id'=>$k1,'name'=>$v1];
            } 
            $data['category_'] = json_encode($data['category_']);
        }
        $data['goods_'] = [];
        if(!empty($data['goods']))
        {
            $path = \request()->domain();
            foreach ($data['goods'] as $k1 => $v1) 
            {
                $img = $data['goods_image'][$k1];
                $img = $storage_sys['values']['default']=='local'?str_replace($path,"",$img):$img;
                $data['goods_'][] = ['id'=>$k1,'name'=>$data['goods_name'][$k1],'image'=>$img];
            }
            $data['goods_'] = json_encode($data['goods_']);
        }
        unset($data['category']);
        unset($data['goods']);
        unset($data['goods_image']);
        unset($data['goods_name']);
        // 更新记录
        if ($model->edit($data)) {
        ################################################################## citrix-end
            return $this->renderSuccess('更新成功', url('market.coupon/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

    /**
     * 删除优惠券
     * @param $coupon_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function delete($coupon_id)
    {
        // 优惠券详情
        $model = CouponModel::detail($coupon_id);
        // 更新记录
        if ($model->setDelete()) {
            return $this->renderSuccess('删除成功', url('market.coupon/index'));
        }
        return $this->renderError($model->getError() ?: '删除成功');
    }

    /**
     * 领取记录
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function receive()
    {
        $model = new UserCouponModel;
        $list = $model->getList();
        return $this->fetch('receive', compact('list'));
    }
    /**
     * 手动发放
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function manual()
    {
        $list = [];
        return $this->fetch('manual', compact('list'));
    }
    /**
     * 手动发放
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function manual_add()
    {
        $coupon_list = \think\Db::name("coupon")
                        ->field("coupon_id,name")
                        ->where('is_delete', '=', 0)
                        ->order(['sort' => 'asc', 'create_time' => 'desc'])
                        ->select()
                        ->toArray();
        $wxapp_sys = \think\Session::get("yoshop_store.wxapp");
        if (!$this->request->isAjax()) {
            return $this->fetch('manual_add', compact('coupon_list'));
        }
        $data = $this->postData('manual');
        if(empty($data['user_id']))
        {
            return $this->renderError('必须选择会员!');
        }
        $coupon_id = $data['coupon_id'];
        $sum = 0;
        foreach ($data['user_id'] as $k1 => $v1) 
        {
            $m = new UCModel();//必须放到里面来
            $result = $m->citrix_receive(['user_id'=>$data['user_id'][$k1]],$coupon_id,$wxapp_sys['wxapp_id']);
            $sum = $sum+$result;
        }
        return $this->renderSuccess("发放成功,成功发放{$sum}个", url('market.coupon/manual_add'));
    }
}