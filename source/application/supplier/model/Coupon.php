<?php

namespace app\supplier\model;

use think\Request;
use app\common\model\Coupon as CouponModel;

/**
 * 优惠券模型
 * Class Coupon
 * @package app\supplier\model
 */
class Coupon extends CouponModel
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
        $where['supplier_id'] = self::$supplier_id;
        return $this->where('is_delete', '=', 0)
            ->where($where)
            ->order(['sort' => 'asc', 'create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => request()->request()
            ]);
    }

    /**
     * 添加新记录
     * @param $data
     * @return false|int
     */
    public function add($data)
    {
        $data['wxapp_id'] = self::$wxapp_id;
        $data['supplier_id'] = self::$supplier_id;
        if ($data['expire_type'] == '20') {
            $data['start_time'] = strtotime($data['start_time']);
            $data['end_time'] = strtotime($data['end_time']);
        }
        return $this->allowField(true)->save($data);
    }

    /**
     * 更新记录
     * @param $data
     * @return bool|int
     */
    public function edit($data)
    {
        $data['supplier_id'] = self::$supplier_id;
        if ($data['expire_type'] == '20') {
            $data['start_time'] = strtotime($data['start_time']);
            $data['end_time'] = strtotime($data['end_time']);
        }
        return $this->allowField(true)->save($data) !== false;
    }

    /**
     * 删除记录 (软删除)
     * @return bool|int
     */
    public function setDelete()
    {
        return $this->save(['is_delete' => 1]) !== false;
    }

}
