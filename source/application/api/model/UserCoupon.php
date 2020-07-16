<?php

namespace app\api\model;

use think\Db;
use think\Request;
use app\common\library\helper;
use app\api\model\Cart as CartModel;
use app\api\model\User as UserModel;
use app\common\model\UserCoupon as UserCouponModel;

/**
 * 用户优惠券模型
 * Class UserCoupon
 * @package app\api\model
 */
class UserCoupon extends UserCouponModel
{
    /**
     * 获取用户优惠券列表
     * @param $user_id
     * @param bool $is_use 是否已使用
     * @param bool $is_expire 是否已过期
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getList($user_id, $is_use = false, $is_expire = false)
    {
        $post = Request()->param();
        $list = $this->where('user_id', '=', $user_id)
            ->where('is_use', '=', $is_use ? 1 : 0)
            ->where('is_expire', '=', $is_expire ? 1 : 0)
            ->select();
        if(citrixCheckSupplier())
        {
            if(!empty($post['cityId']) && !empty($post['goods_id']))
            {
                $goods = Db::name("goods")->field("supplier_id")->where(['goods_id'=>$post['goods_id']])->find();
                return $this->where('user_id', '=', $user_id)
                ->where('supplier_id', '=', $goods['supplier_id'])
                ->where('is_use', '=', $is_use ? 1 : 0)
                ->where('is_expire', '=', $is_expire ? 1 : 0)
                ->select();
            }else if(!empty($post['cityId']) && !empty($post['cart_ids']))
            {
                $cartIds = isset($post['cart_ids']) ? $post['cart_ids'] : '';
                //购物车商品列表
                $goodsList = $this->getCartList($cartIds);
                if(count($goodsList) >= 2)
                {
                    return $this->where('user_id', '=', $user_id)
                    ->where('supplier_id', '=', 0)
                    ->where('is_use', '=', $is_use ? 1 : 0)
                    ->where('is_expire', '=', $is_expire ? 1 : 0)
                    ->select();
                }
                return $this->where('user_id', '=', $user_id)
                ->where('supplier_id', 'in', [0,$goodsList[0]])
                ->where('is_use', '=', $is_use ? 1 : 0)
                ->where('is_expire', '=', $is_expire ? 1 : 0)
                ->select();
            }
        }else
        {
            return $this->where('user_id', '=', $user_id)
            ->where('is_use', '=', $is_use ? 1 : 0)
            ->where('is_expire', '=', $is_expire ? 1 : 0)
            ->select();
        }
    }
    /**
     * 获取购物车列表
     * @param string|null $cartIds 购物车索引集 (为null时则获取全部)
     * @return array
     */
    protected function getCartList($cartIds = null)
    {
        $cartList = [];
        $indexArr = (strpos($cartIds, ',') !== false) ? explode(',', $cartIds) : [$cartIds];
        $model_sku = Db::name("goods_sku");
        $model_goods = Db::name("goods");
        $result = [];
        foreach ($indexArr as $index) 
        {
            $arr = explode("_", $index);
            $goods_id = $arr[0];
            unset($arr[0]);
            $goods_sku = implode("_",$arr);
            $goods = $model_sku->where(["spec_sku_id"=>$goods_sku,"goods_id"=>$goods_id])->value("goods_id");
            $result[] = $model_goods->where(['goods_id'=>$goods])->value("supplier_id");
        }
        return array_unique($result);
    }
    /**
     * 获取用户优惠券总数量(可用)
     * @param $user_id
     * @return int|string
     * @throws \think\Exception
     */
    public function getCount($user_id)
    {
        return $this->where('user_id', '=', $user_id)
            ->where('is_use', '=', 0)
            ->where('is_expire', '=', 0)
            ->count();
    }

    /**
     * 获取用户优惠券ID集
     * @param $user_id
     * @return array
     */
    public function getUserCouponIds($user_id)
    {
        return $this->where('user_id', '=', $user_id)->column('coupon_id');
    }

    /**
     * 领取优惠券
     * @param $user
     * @param $coupon_id
     * @return bool|false|int
     * @throws \think\exception\DbException
     */
    public function receive($user, $coupon_id)
    {
        // 获取优惠券信息
        $coupon = Coupon::detail($coupon_id);
        // 验证优惠券是否可领取
        if (!$this->checkReceive($user, $coupon)) 
        {
            return false;
        }
        // 添加领取记录
        return $this->add($user, $coupon);
    }

    /**
     * 添加领取记录
     * @param $user
     * @param Coupon $coupon
     * @return bool
     */
    private function add($user, $coupon)
    {

        // 计算有效期
        if ($coupon['expire_type'] == 10) {
            $start_time = time();
            $end_time = $start_time + ($coupon['expire_day'] * 86400);
        } else {
            $start_time = $coupon['start_time']['value'];
            $end_time = $coupon['end_time']['value'];
        }
        // 整理领取记录
        $data = [
            'coupon_id' => $coupon['coupon_id'],
            'name' => $coupon['name'],
            'color' => $coupon['color']['value'],
            'coupon_type' => $coupon['coupon_type']['value'],
            'reduce_price' => $coupon['reduce_price'],
            'discount' => $coupon->getData('discount'),
            'min_price' => $coupon['min_price'],
            'expire_type' => $coupon['expire_type'],
            'expire_day' => $coupon['expire_day'],
            'start_time' => $start_time,
            'end_time' => $end_time,
            'apply_range' => $coupon['apply_range'],
            'user_id' => $user['user_id'],
            'supplier_id' => $coupon['supplier_id'],
            'wxapp_id' => self::$wxapp_id
        ];
        return $this->transaction(function () use ($data, $coupon) {
            // 添加领取记录
            $status = $this->save($data);
            if ($status) {
                // 更新优惠券领取数量
                $coupon->setIncReceiveNum();
            }
            return $status;
        });
    }

    /**
     * 验证优惠券是否可领取
     * @param $user
     * @param Coupon $coupon
     * @return bool
     */
    private function checkReceive($user, $coupon)
    {
        if (!$coupon) {
            $this->error = '优惠券不存在';
            return false;
        }
        if (!$coupon->checkReceive()) {
            $this->error = $coupon->getError();
            return false;
        }
        // 验证是否已领取
        $userCouponIds = $this->getUserCouponIds($user['user_id']);
        if (in_array($coupon['coupon_id'], $userCouponIds)) {
            $this->error = '该优惠券已领取';
            return false;
        }
        return true;
    }

    /**
     * 订单结算优惠券列表
     * @param int $user_id 用户id
     * @param double $orderPayPrice 订单商品总金额
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getUserCouponList($user_id, $orderPayPrice)
    {
        // todo: 新增筛选条件: 最低消费金额
        // 获取用户可用的优惠券列表
        $list = (new self)->getList($user_id);
        $data = [];
        if(!empty($list))
        {
            foreach ($list as $coupon) {
                // 最低消费金额
                if ($orderPayPrice < $coupon['min_price']) continue;
                // 有效期范围内
                if ($coupon['start_time']['value'] > time()) continue;
                $key = $coupon['user_coupon_id'];
                $data[$key] = [
                    'user_coupon_id' => $coupon['user_coupon_id'],
                    'name' => $coupon['name'],
                    'color' => $coupon['color'],
                    'coupon_type' => $coupon['coupon_type'],
                    'reduce_price' => $coupon['reduce_price'],
                    'discount' => $coupon['discount'],
                    'min_price' => $coupon['min_price'],
                    'expire_type' => $coupon['expire_type'],
                    'start_time' => $coupon['start_time'],
                    'end_time' => $coupon['end_time'],
                ];
                // 计算打折金额
                if ($coupon['coupon_type']['value'] == 20) {
    //                $reduce_price = $orderPayPrice * ($coupon['discount'] / 10);
                    $reducePrice = helper::bcmul($orderPayPrice, $coupon['discount'] / 10);
                    $data[$key]['reduced_price'] = bcsub($orderPayPrice, $reducePrice, 2);
                } else
                    $data[$key]['reduced_price'] = $coupon['reduce_price'];
            }
            // 根据折扣金额排序并返回
            return array_sort($data, 'reduced_price', true);
        }
        return [];
    }

}
