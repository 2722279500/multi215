<?php

namespace app\store\model\merchant;

use app\common\model\merchant\Active as ActiveModel;
use Lvht\GeoHash;

/**
 * 多商家模型
 * Class Active
 * @package app\store\model\merchant
 */
class Active extends ActiveModel
{
    /**
     * 获取列表数据
     * @param string $search
     * @return mixed|\think\Paginator
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getList($param = [])
    {
        // 检索查询条件
        !empty($param['category_id']) && $this->where('category_id', '=', (int)$param['category_id']);
        !empty($param['search']) && $this->where('name|phone', 'like', "%{$param['search']}%");
        // 查询列表数据
        $list = $this
            ->where('is_delete', '=', 0)
            ->order(['sort' => 'asc', 'create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => request()->request()
            ]);
        return $list;
    }

    /**
     * 新增记录
     * @param $data
     * @return bool|int
     */
    public function add($data)
    {
        if (!$this->onValidate($data, 'add')) {
            return false;
        }
        if(!empty($data['password']))
        {
            $data['password'] = md5($data['password']);
        }
        $data = $this->createData($data);
        return $this->allowField(true)->save($data) !== false;
    }

    /**
     * 更新记录
     * @param $data
     * @return bool|int
     */
    public function edit($data)
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
        if(true == $this->where("active_id","neq",$active_id)->where('username', '=', $data['username'])->find())
        {
            $this->error = '账号已存在';
            return false;
        }
        $data = $this->createData($data);
        return $this->allowField(true)->save($data) !== false;
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

    /**
     * 软删除
     * @return false|int
     */
    public function setDelete()
    {
        return $this->allowField(true)->save(['is_delete' => 1]);
    }

    /**
     * 获取当前商家总数
     * @param array $where
     * @return int|string
     * @throws \think\Exception
     */
    public function getMerchantTotal($where = [])
    {
        return $this->where('is_delete', '=', 0)->where($where)->count();
    }
}