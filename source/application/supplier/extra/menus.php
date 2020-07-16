<?php
/**
 * 后台菜单配置
 *    'home' => [
 *       'name' => '首页',                // 菜单名称
 *       'icon' => 'icon-home',          // 图标 (class)
 *       'index' => 'index/index',         // 链接
 *     ],
 */
return [
    'finance' => [
        'name' => '财务统计',
        'icon' => 'icon-stock',
        'index' => 'finance/index',
        'submenu' => [
            [
                'name' => '订单明细',
                'index' => 'finance/index',
                'uris' => [
                    'finance/index',
                    'finance/add',
                    'finance/edit',
                ],
            ],
            [
                'name' => '提现管理',
                'index' => 'withdraw/index',
                'uris' => [
                    'withdraw/index',
                    'withdraw/add',
                ],
            ],
        ],
    ],
    'goods' => [
        'name' => '商品管理',
        'icon' => 'icon-goods',
        'index' => 'goods/index',
        'submenu' => [
            [
                'name' => '商品列表',
                'index' => 'goods/index',
                'uris' => [
                    'goods/index',
                    'goods/add',
                    'goods/edit',
                    'goods/copy'
                ],
            ],
            [
                'name' => '商品分类',
                'index' => 'goods.category/index',
                'uris' => [
                    'goods.category/index',
                    'goods.category/add',
                    'goods.category/edit',
                ],
            ],
            [
                'name' => '商品评价',
                'index' => 'goods.comment/index',
                'uris' => [
                    'goods.comment/index',
                    'goods.comment/detail',
                ],
            ]
        ],
    ],
    'market' => [
        'name' => '营销管理',
        'icon' => 'icon-marketing',
        'index' => 'market.coupon/index',
        'submenu' => [
            [
                'name' => '优惠券列表',
                'index' => 'market.coupon/index',
                'uris' => [
                    'market.coupon/index',
                    'market.coupon/add',
                    'market.coupon/edit',
                ],
            ],
            [
                'name' => '领取记录',
                'index' => 'market.coupon/receive',
            ],
        ],
    ],
    'order' => [
        'name' => '订单管理',
        'icon' => 'icon-order',
        'index' => 'order/all_list',
        'submenu' => [
            [
                'name' => '全部订单',
                'index' => 'order/all_list',
            ],
            [
                'name' => '待发货',
                'index' => 'order/delivery_list',
            ],
            [
                'name' => '待收货',
                'index' => 'order/receipt_list',
            ],
            [
                'name' => '待付款',
                'index' => 'order/pay_list',
            ],
            [
                'name' => '已完成',
                'index' => 'order/complete_list',

            ],
            [
                'name' => '已取消',
                'index' => 'order/cancel_list',
            ],
            [
                'name' => '售后管理',
                'index' => 'refund/index',
                'uris' => [
                    'refund/index',
                    'refund/detail',
                ]
            ],
        ]
    ],
];
