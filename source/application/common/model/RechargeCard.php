<?php

namespace app\common\model;

/**
 * 用户储值卡模型
 * Class RechargeCard
 * @package app\common\model
 */
class RechargeCard extends BaseModel
{
    protected $name = 'recharge_card';

    /**
     * 追加字段
     * @var array
     */
    protected $append = ['state'];

    /**
     * 关联用户表
     * @return \think\model\relation\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('User');
    }

    /**
     * 储值卡状态
     * @param $value
     * @param $data
     * @return array
     */
    public function getStateAttr($value, $data)
    {
        if ($data['is_use']) {
            return ['text' => '已使用', 'value' => 0];
        }
        if ($data['is_expire']) {
            return ['text' => '已过期', 'value' => 0];
        }
        return ['text' => '', 'value' => 1];
    }

    /**
     * 有效期-开始时间
     * @param $value
     * @return mixed
     */
    public function getStartTimeAttr($value)
    {
        return ['text' => date('Y/m/d', $value), 'value' => $value];
    }

    /**
     * 有效期-结束时间
     * @param $value
     * @return mixed
     */
    public function getEndTimeAttr($value)
    {
        return ['text' => date('Y/m/d', $value), 'value' => $value];
    }

    /**
     * 储值卡详情
     * @param $coupon_id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($coupon_id)
    {
        return static::get($coupon_id);
    }

    /**
     * 设置储值卡使用状态
     * @param int $couponId 用户的储值卡id
     * @param bool $isUse 是否已使用
     * @return false|int
     */
    public static function setIsUse($couponId, $isUse = true)
    {
        return (new static)->save(['is_use' => (int)$isUse], ['user_coupon_id' => $couponId]);
    }

}