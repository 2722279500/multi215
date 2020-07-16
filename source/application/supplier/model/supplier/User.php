<?php

namespace app\supplier\model\supplier;

use think\Db;
use think\Session;
use app\common\model\supplier\User as UserModel;
use Lvht\GeoHash;

/**
 * 超管后台用户模型
 * Class User
 * @package app\supplier\model\supplier
 */
class User extends UserModel
{
    /**
     * 超管后台用户登录
     * @param $data
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function login($data)
    {
        // 验证用户名密码是否正确
        if (!$user = Db::name("merchant_active")->where([
            'username' => $data['username'],
            'password' => md5($data['password'])
        ])->find()) {
            $this->error = '登录失败, 用户名或密码错误';
            return false;
        }
        if(time() > $user['start_time'] && time() < $user['end_time'])
        {
            // 保存登录状态
            Session::set('yoshop_supplier', [
                'user' => [
                    'supplier_user_id' => $user['active_id'],
                    'wxapp_id' => $user['wxapp_id'],
                    'username' => $user['username'],
                    'name' => $user['name'],
                ],
                'is_login' => true,
            ]);
            return true;
        }
        $this->error = "请在".date("Y-m-d",$user['start_time'])."与".date("Y-m-d",$user['end_time'])."内运营";
        return false;
    }

    /**
     * 超管用户信息
     * @param $supplier_user_id
     * @return null|static
     * @throws \think\exception\DbException
     */
    public static function detail($supplier_user_id)
    {
        return self::get($supplier_user_id);
    }

    /**
     * 更新当前管理员信息
     * @param $data
     * @return bool
     */
    public function renew($data)
    {
        $active_id = request()->param("active_id");
        if (!$this->onValidate($data, 'edit')) {
            return false;
        }
        if(!empty($data['password']))
        {
            $data['password'] = md5($data['password']);
        }else
        {
            unset($data['password']);
        }
        if(true == Db::name("merchant_active")->where("active_id","neq",$active_id)->where('username', '=', $data['username'])->find())
        {
            $this->error = '账号已存在';
            return false;
        }
        $data = $this->createData($data);
        $u = Session::get("yoshop_supplier.user");

        unset($data['coordinate']);
        unset($data['supplier_rebate']);
        unset($data['start_time']);
        unset($data['end_time']);
        unset($data['sort']);

        return Db::name("merchant_active")->where(['active_id'=>$u['supplier_user_id']])->update($data) !== false;
        // return $this->allowField(true)->save($data) !== false;
        /*if ($data['password'] !== $data['password_confirm']) {
            $this->error = '确认密码不正确';
            return false;
        }
        // 更新管理员信息
        if ($this->save([
                'username' => $data['username'],
                'password' => yoshop_hash($data['password']),
            ]) === false) {
            return false;
        }
        // 更新session
        Session::set('yoshop_supplier', [
            'supplier_user_id' => $this['supplier_user_id'],
            'username' => $data['username'],
        ]);
        return true;*/
    }
    /**
     * 创建数据
     * @param array $data
     * @return array
     */
    private function createData($data)
    {
        $data['wxapp_id'] = self::$wxapp_id;
        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        // 格式化坐标信息
        $coordinate = explode(',', $data['coordinate']);
        $data['latitude'] = $coordinate[0];
        $data['longitude'] = $coordinate[1];
        // 生成geohash
        $Geohash = new Geohash;
        $data['geohash'] = $Geohash->encode($data['longitude'], $data['latitude']);
        return $data;
    }
    /**
     * 表单验证
     * @param $data
     * @param string $scene
     * @return bool
     */
    private function onValidate($data, $scene = 'add')
    {
        if ($scene === 'add') {
            if (!isset($data['name']) || empty($data['name'])) {
                $this->error = '请填写商家名称';
                return false;
            }
            if(empty($data['password']))
            {
                $this->error = '请填写密码';
                return false;
            }
            if(true == $this->where('username', '=', $data['username'])->find())
            {
                $this->error = '账号已存在';
                return false;
            }
        }
        // 验证活动时间
        if (empty($data['start_time']) || empty($data['end_time'])) 
        {
            $this->error = '请选择商家的运营时间与截止时间';
            return false;
        }
        if(empty($data['username']) or !preg_match("/^[A-Za-z0-9]+$/", $data['username']))
        {
            $this->error = '账号只允许字母,数字';
            return false;
        }
        if(empty($data['email']) or !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $data['email']))
        {
            $this->error = '邮箱格式错误';
            return false;
        }
        if(empty($data['phone']) or !preg_match("/^1[34578]\d{9}$/", $data['phone']))
        {
            $this->error = '手机号格式错误';
            return false;
        }
        if(empty($data['image_id']))
        {
            $this->error = '封面图不能为空';
            return false;
        }
        if(empty($data['thumb_id']))
        {
            $this->error = '头像不能为空';
            return false;
        }
        $data['start_time'] = strtotime($data['start_time']);
        $data['end_time'] = strtotime($data['end_time']);
        if ($data['end_time'] <= $data['start_time']) {
            $this->error = '活动截止时间必须大于运营时间';
            return false;
        }
        return true;
    }

}