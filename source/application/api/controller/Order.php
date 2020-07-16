<?php

namespace app\api\controller;

use app\api\model\Cart as CartModel;
use app\api\model\Order as OrderModel;
use app\api\service\order\Checkout as CheckoutModel;
use app\api\validate\order\Checkout as CheckoutValidate;

/**
 * 订单控制器
 * Class Order
 * @package app\api\controller
 */
class Order extends Controller
{
    /* @var \app\api\model\User $user */
    private $user;

    /* @var CheckoutValidate $validate */
    private $validate;

    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        parent::_initialize();
        // 用户信息
        $this->user = $this->getUser();
        // 验证类
        $this->validate = new CheckoutValidate;
    }

    /**
     * 订单确认-立即购买
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function buyNow()
    {
        // 实例化结算台服务
        $Checkout = new CheckoutModel;
        // 订单结算api参数
        $params = $Checkout->setParam($this->getParam([
            'goods_id' => 0,
            'goods_num' => 0,
            'goods_sku_id' => '',
        ]));

        // 表单验证
        if (!$this->validate->scene('buyNow')->check($params)) {
            return $this->renderError($this->validate->getError());
        }
        // $supplier_id = \think\Db::name("goods")->where(['goods_id'=>$params['goods_id']])->value("supplier_id");
        // 立即购买：获取订单商品列表
        $model = new OrderModel;
        $goodsList = $model->getOrderGoodsListByNow(
            $params['goods_id'],
            $params['goods_sku_id'],
            $params['goods_num']
        );
        // 获取订单确认信息
        $orderInfo = $Checkout->onCheckout($this->user, $goodsList);
        if ($this->request->isGet()) {
            return $this->renderSuccess($orderInfo);
        }
        // 订单结算提交
        if ($Checkout->hasError()) {
            return $this->renderError($Checkout->getError());
        }
        // 创建订单
        if (!$Checkout->createOrder($orderInfo)) {
            return $this->renderError($Checkout->getError() ?: '订单创建失败');
        }
        // 构建微信支付请求
        $payment = $model->onOrderPayment($this->user, $Checkout->model, $params['pay_type']);
        // 返回结算信息
        return $this->renderSuccess([
            'order_id' => $Checkout->model['order_id'],   // 订单id
            'pay_type' => $params['pay_type'],  // 支付方式
            'payment' => $payment               // 微信支付参数
        ], ['success' => '支付成功', 'error' => '订单未支付']);
    }

    /**
     * 订单确认-购物车结算
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function cart()
    {
        // 实例化结算台服务
        $Checkout = new CheckoutModel;
        // 订单结算api参数
        $params = $Checkout->setParam($this->getParam([
            'cart_ids' => '',
        ]));
        // 商品结算信息
        $CartModel = new CartModel($this->user);
        // 购物车商品列表
        $goodsList = $CartModel->getList($params['cart_ids']);
        // 获取订单结算信息
        $orderInfo = $Checkout->onCheckout($this->user, $goodsList);
        if(citrixCheckSupplier())
        {
            $express_price = 0.00;
            $cart_ids = $params['cart_ids'];
            $cart_ids = explode(",", $cart_ids);
            $db = \think\Db::name("goods");
            $data = [];
            $attr = [];
            $express = [];
            foreach ($cart_ids as $k1 => $v1) 
            {
                $explode_ids = explode("_",$cart_ids[$k1]);
                $goods_id = $explode_ids[0];
                unset($explode_ids[0]);
                $spec_sku_id = implode("_", $explode_ids);
                $supplier_id = $db->where(['goods_id'=>$goods_id])->value("supplier_id");
                $data[$goods_id] = ['supplier_id'=>$supplier_id,'val'=>$goods_id.'_'.$spec_sku_id];
                $attr[$data[$goods_id]['supplier_id']] = empty($attr[$data[$goods_id]['supplier_id']])?$data[$goods_id]['val']:$data[$goods_id]['val'].','.$attr[$data[$goods_id]['supplier_id']];
            }
            foreach ($attr as $k3 => $v3) 
            {
                // 购物车商品列表
                $_goodsList = $CartModel->getList($attr[$k3]);
                // 获取订单结算信息
                $_orderInfo = $Checkout->onCheckout($this->user, $_goodsList);
                $express_price += $_orderInfo['express_price'];
                $express[$k3] = $_orderInfo['express_price'];
            }
            $orderInfo['express_price'] = sprintf("%.2f",$express_price); 
            $orderInfo['order_pay_price'] = sprintf("%.2f",$orderInfo['order_price']+(float)$express_price); 
            $orderInfo['c_express'] = json_encode($express);
        }
        if ($this->request->isGet()) {
            return $this->renderSuccess($orderInfo);
        }
        // 创建订单
        if (!$Checkout->createOrder($orderInfo)) {
            return $this->renderError($Checkout->getError() ?: '订单创建失败');
        }
        // 移出购物车中已下单的商品
        $CartModel->clearAll($params['cart_ids']);
        // 构建微信支付请求
        $payment = $Checkout->onOrderPayment();
        // 返回状态
        return $this->renderSuccess([
            'order_id' => $Checkout->model['order_id'],   // 订单id
            'pay_type' => $params['pay_type'],  // 支付方式
            'payment' => $payment               // 微信支付参数
        ], ['success' => '支付成功', 'error' => '订单未支付']);
    }

    /**
     * 订单结算提交的参数
     * @param array $define
     * @return array
     */
    private function getParam($define = [])
    {
        return array_merge($define, $this->request->param());
    }

}
