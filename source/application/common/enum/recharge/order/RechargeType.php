<?php

namespace app\common\enum\recharge\order;

use app\common\enum\EnumBasics;

/**
 * 用户充值订单-充值方式枚举类
 * Class RechargeType
 * @package app\common\enum\recharge\order
 */
class RechargeType extends EnumBasics
{
    // 自定义金额
    const CUSTOM = 10;

    // 套餐充值
    const PLAN = 20;

    // 储值卡充值
    const CARD = 30;

    /**
     * 获取订单类型值
     * @return array
     */
    public static function data()
    {
        return [
            self::CUSTOM => [
                'name' => '自定义金额',
                'value' => self::CUSTOM,
            ],
            self::PLAN => [
                'name' => '套餐充值',
                'value' => self::PLAN,
            ],
            self::CARD => [
                'name' => '储值卡充值',
                'value' => self::CARD,
            ],
        ];
    }

}