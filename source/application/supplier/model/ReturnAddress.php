<?php

namespace app\supplier\model;

use app\common\model\ReturnAddress as ReturnAddressModel;

/**
 * 退货地址模型
 * Class ReturnAddress
 * @package app\supplier\model
 */
class ReturnAddress extends ReturnAddressModel
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
     * 获取列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList()
    {
        return $this->order(['sort' => 'asc'])
            ->where('is_delete', '=', 0)
            ->where('supplier_id', '=', self::$supplier_id)
            ->paginate(15, false, [
                'query' => \request()->request()
            ]);
    }

    /**
     * 获取全部收货地址
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAll()
    {
        return $this->order(['sort' => 'asc'])
            ->where('is_delete', '=', 0)
            ->select();
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
        return $this->allowField(true)->save($data);
    }

    /**
     * 编辑记录
     * @param $data
     * @return bool|int
     */
    public function edit($data)
    {
        return $this->allowField(true)->save($data);
    }

    /**
     * 删除记录
     * @return bool|int
     */
    public function remove()
    {
        return $this->save(['is_delete' => 1]);
    }

}