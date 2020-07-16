<?php

namespace app\supplier\controller;

use think\Config;
use think\Request;
use think\Session;

// use app\store\model\Setting;

/**
 * 超管后台控制器基类
 * Class Controller
 * @package app\supplier\controller
 */
class Controller extends \think\Controller
{
    /* @var array $supplier 商家登录信息 */
    protected $supplier;

    /* @var string $route 当前控制器名称 */
    protected $controller = '';

    /* @var string $route 当前方法名称 */
    protected $action = '';

    /* @var string $route 当前路由uri */
    protected $routeUri = '';

    /* @var string $route 当前路由：分组名称 */
    protected $group = '';

    /* @var array $allowAllAction 登录验证白名单 */
    protected $allowAllAction = [
        // 登录页面
        'passport/login',
    ];

    /* @var array $notLayoutAction 无需全局layout */
    protected $notLayoutAction = [
        // 登录页面
        'passport/login',
    ];

    /**
     * 后台初始化
     * @throws \Exception
     */
    public function _initialize()
    {
        // 商家登录信息
        $this->supplier = Session::get('yoshop_supplier');
        // 当前路由信息
        $this->getRouteinfo();
        // 验证登录
        $this->checkLogin();
        // 全局layout
        $this->layout();
    }

    /**
     * 全局layout模板输出
     * @throws \Exception
     */
    private function layout()
    {
        // 验证当前请求是否在白名单
        if (!in_array($this->routeUri, $this->notLayoutAction)) {
            // 输出到view
            $this->assign([
                'base_url' => base_url(),                      // 当前域名
                'supplier_url' => url('/supplier'),              // 后台模块url
                'group' => $this->group,
                'menus' => $this->menus(),                     // 后台菜单
                'supplier' => $this->supplier,                       // 商家登录信息
                'version' => get_version(),                    // 当前系统版本号
                'request' => Request::instance()               // Request对象
            ]);
        }
    }

    /**
     * 验证当前页面权限
     * @throws BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    private function checkPrivilege()
    {
        if ($this->routeUri === 'index/index') {
            return true;
        }
        if (!Auth::getInstance()->checkPrivilege($this->routeUri)) {
            throw new BaseException(['msg' => '很抱歉，没有访问权限']);
        }
        return true;
    }

    /**
     * 解析当前路由参数 （分组名称、控制器名称、方法名）
     */
    protected function getRouteinfo()
    {
        // 控制器名称
        $this->controller = toUnderScore($this->request->controller());
        // 方法名称
        $this->action = $this->request->action();
        // 控制器分组 (用于定义所属模块)
        $groupstr = strstr($this->controller, '.', true);
        $this->group = $groupstr !== false ? $groupstr : $this->controller;
        // 当前uri
        $this->routeUri = $this->controller . '/' . $this->action;
    }

    /**
     * 后台菜单配置
     * @return array
     */
    private function menus()
    {
        foreach ($data = Config::get('menus') as $group => $first) {
            $data[$group]['active'] = $group === $this->group;
            // 遍历：二级菜单
            if (isset($first['submenu'])) {
                foreach ($first['submenu'] as $secondKey => $second) {
                    // 二级菜单所有uri
                    $secondUris = isset($second['uris']) ? $second['uris'] : [$second['index']];
                    // 二级菜单：active
                    !isset($data[$group]['submenu'][$secondKey]['active'])
                    && $data[$group]['submenu'][$secondKey]['active'] = in_array($this->routeUri, $secondUris);
                }
            }
        }
        return $data;
    }

    /**
     * 验证登录状态
     * @return bool
     */
    private function checkLogin()
    {
        $active_id = input("active_id/d",0);
        $yoshop_store = Session::get("yoshop_store.user");

        // Session::clear('yoshop_supplier');
        if(!empty($active_id) && !empty($yoshop_store['store_user_id']))
        {
            // 验证用户名密码是否正确
            if (!$user = \think\Db::name("merchant_active")->where([
                'active_id' => $active_id,
            ])->find()) {
                $this->redirect('passport/login');
                return false;
            }
            // 保存登录状态
            Session::set('yoshop_supplier', [
                'user' => [
                    'supplier_user_id' => $user['active_id'],
                    'wxapp_id' => $user['wxapp_id'],
                    'username' => $user['username'],
                    'name'=>$user['name'],
                ],
                'is_login' => true,
            ]);
            $this->redirect('index/index');
            return false;
            
        }
        // 验证当前请求是否在白名单
        if (in_array($this->routeUri, $this->allowAllAction)) {
            return true;
        }
        // 验证登录状态
        if (empty($this->supplier)
            || (int)$this->supplier['is_login'] !== 1
        ) {
            $this->redirect('passport/login');
            return false;
        }
        return true;
    }

    /**
     * 返回封装后的 API 数据到客户端
     * @param int $code
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderJson($code = 1, $msg = '', $url = '', $data = [])
    {
        return compact('code', 'msg', 'url', 'data');
    }

    /**
     * 返回操作成功json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderSuccess($msg = 'success', $url = '', $data = [])
    {
        return $this->renderJson(1, $msg, $url, $data);
    }

    /**
     * 返回操作失败json
     * @param string $msg
     * @param string $url
     * @param array $data
     * @return array
     */
    protected function renderError($msg = 'error', $url = '', $data = [])
    {
        return $this->renderJson(0, $msg, $url, $data);
    }

    /**
     * 获取post数据 (数组)
     * @param $key
     * @return mixed
     */
    protected function postData($key)
    {
        return $this->request->post($key . '/a');
    }
    /**
     * 获取post数据 (数组)
     * @param $key
     * @return mixed
     */
    protected function getData($key = null)
    {
        return $this->request->get(is_null($key) ? '' : $key);
    }
}
