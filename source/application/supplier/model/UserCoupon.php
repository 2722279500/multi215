<?php

namespace app\supplier\model;

use app\common\model\UserCoupon as UserCouponModel;

/**
 * 用户优惠券模型
 * Class UserCoupon
 * @package app\supplier\model
 */
class UserCoupon extends UserCouponModel
{
    public static $supplier_id;
    /**
     * 模型基类初始化
     */
    public static function init()
    {
        parent::init();
        $yoshop_supplier = \think\Session::get("yoshop_supplier.user");
        self::$supplier_id = $yoshop_supplier['supplier_user_id'];
    }
    /**
     * 获取优惠券列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList()
    {

        return $this->with(['user'])
            ->field("*,c.supplier_id")
            ->join('coupon c','c.coupon_id = '.config("database.prefix").'user_coupon.coupon_id')
            ->order([''.config("database.prefix").'user_coupon.create_time' => 'desc'])
            ->where([config("database.prefix").'user_coupon.supplier_id'=>self::$supplier_id])
            ->paginate(15, false, [
                'query' => request()->request()
            ]);

        // return $this->with(['user'])
        //     ->field("*,c.supplier_id")
        //     ->join('coupon c','c.coupon_id = '.config("database.prefix").'user_coupon.coupon_id')
        //     ->order([''.config("database.prefix").'user_coupon.create_time' => 'desc'])
        //     ->where(['supplier_id'=>self::$supplier_id])
        //     ->paginate(15, false, [
        //         'query' => request()->request()
        //     ]);
        // p(self::$supplier_id);
        // p($list);
        // p(\think\Db::GetLastSQL());
        // exit;
        /*return $this->with(['user',"coupon"])
            ->field("*")
            ->order(['create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => request()->request()
            ]);*/
    }

}