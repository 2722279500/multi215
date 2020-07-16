<?php

namespace app\common\model;

/**
 * 微信小程序分类页模板
 * Class WxappCategory
 * @package app\common\model
 */
class WxappNav extends BaseModel
{
    protected $name = 'wxapp_nav';


    /**
     * 页面diy元素默认数据
     * @return array
     */
    public function getDefaultNav()
    {
        return [
            "page"=>[
                "type"=> "page",
                "name"=>"页面设置",
                "params"=>["name"=>"企维度商城", "title"=>"企维度商城", "share_title"=>"企维度商城"],
                "style"=>["titleTextColor"=>"black", "titleBackgroundColor"=>"#ffffff"]
            ],

            'items' => [
                [
                    'name' => '导航组',
                    'type' => 'navBar',
                    'style' => ['background' => '#ffffff', 'rowsNum' => '4'],
                    'data' => [
                        [
                            'default_imgUrl' => self::$base_url . 'assets/store/img/diy/navbar/icon-27.png',
                            'select_imgUrl' => self::$base_url . 'assets/store/img/diy/navbar/icon-27-active.png',
                            'linkUrl' => '/pages/index/index',
                            'text' => '首页',
                            'color' => '#666666',
                            'select_color' => '#f44336'
                        ],
                        [
                            'default_imgUrl' => self::$base_url . 'assets/store/img/diy/navbar/icon-20.png',
                            'select_imgUrl' => self::$base_url . 'assets/store/img/diy/navbar/icon-20-active.png',
                            'linkUrl' => '/pages/category/index',
                            'text' => '分类',
                            'color' => '#666666',
                            'select_color' => '#f44336'
                        ],
                        [
                            'default_imgUrl' => self::$base_url . 'assets/store/img/diy/navbar/icon-22.png',
                            'select_imgUrl' => self::$base_url . 'assets/store/img/diy/navbar/icon-22-active.png',
                            'linkUrl' => '/pages/flow/index',
                            'text' => '购物车',
                            'color' => '#666666',
                            'select_color' => '#f44336'
                        ],
                        [
                            'default_imgUrl' => self::$base_url . 'assets/store/img/diy/navbar/icon-26.png',
                            'select_imgUrl' => self::$base_url . 'assets/store/img/diy/navbar/icon-26-active.png',
                            'linkUrl' => '/pages/user/index',
                            'text' => '我的',
                            'color' => '#666666',
                            'select_color' => '#f44336'
                        ]
                    ]
                ]
            ]
        ];
    }


    /**
     * 分类模板详情
     * @return static|null
     * @throws \think\exception\DbException
     */
    public static function detail()
    {
        return self::get(['wxapp_id'=>self::$wxapp_id]);
    }



}