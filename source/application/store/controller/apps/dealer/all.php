<?php

namespace app\store\controller\apps\dealer;

use app\store\controller\Controller;
use app\store\service\Menus;
/**
 * 分销商申请
 * Class Setting
 * @package app\store\controller\apps\dealer
 */
class All extends Controller
{

        public function index()
        {
            $this->assign([
                'menus' => $this->menus(),                     // 后台菜单
            ]);
        }

        /**
         * 后台菜单配置
         * @return mixed
         * @throws \think\exception\DbException
         */
        protected function menus()
        {
           static $menus = [];
           if (empty($menus)) {
               $menus = Menus::getInstance()->getMenus($this->routeUri, $this->group);
           }
           return $menus;
        }
}