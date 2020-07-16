<?php

namespace app\supplier\controller;

use app\supplier\controller\Controller;
use app\supplier\model\Order as OrderModel;
use app\supplier\model\OrderRefund as OrderRefundModel;
use app\supplier\model\ReturnAddress as ReturnAddressModel;

/**
 * 售后管理
 * Class Refund
 * @package app\supplier\controller\order
 */
class Refund extends Controller
{
    /**
     * 帮助中心列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $model = new OrderRefundModel;
        $list = $model->getList($this->getData());
        return $this->fetch('index', compact('list'));
    }

    /**
     * 售后单详情
     * @param $order_refund_id
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function detail($order_refund_id)
    {
        $user = \think\Session::get("yoshop_supplier.user");
        $supplier_id = $user['supplier_user_id'];

        // 售后单详情
        $detail = OrderRefundModel::detail($order_refund_id);
        // 订单详情
        $order = OrderModel::detail($detail['order_id']);
        // 退货地址
        $address = (new ReturnAddressModel)->getAll();
        return $this->fetch('detail', compact('detail', 'order', 'address','supplier_id'));
    }

    /**
     * 商家审核
     * @param $order_refund_id
     * @return array|bool
     * @throws \think\exception\DbException
     */
    public function audit($order_refund_id)
    {
        if (!$this->request->isAjax()) {
            return false;
        }
        $model = OrderRefundModel::detail($order_refund_id);
        if ($model->audit($this->postData('refund'))) {
            return $this->renderSuccess('操作成功');
        }
        return $this->renderError($model->getError() ?: '操作失败');
    }

    /**
     * 确认收货并退款
     * @param $order_refund_id
     * @return array|bool
     * @throws \think\exception\DbException
     */
    public function receipt($order_refund_id)
    {
        if (!$this->request->isAjax()) {
            return false;
        }
        $model = OrderRefundModel::detail($order_refund_id);
        if ($model->receipt($this->postData('refund'))) {
            return $this->renderSuccess('操作成功');
        }
        return $this->renderError($model->getError() ?: '操作失败');
    }

}