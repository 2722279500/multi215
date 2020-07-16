<?php

namespace app\supplier\model;

use app\common\model\Goods as GoodsModel;
use app\supplier\service\Goods as GoodsService;

/**
 * 商品模型
 * Class Goods
 * @package app\supplier\model
 */
class Goods extends GoodsModel
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
     * 添加商品
     * @param array $data
     * @return bool
     * @throws \think\exception\PDOException
     */
    public function add(array $data)
    {
        if (!isset($data['images']) || empty($data['images'])) {
            $this->error = '请上传商品图片';
            return false;
        }
        $data['content'] = isset($data['content']) ? $data['content'] : '';
        $data['wxapp_id'] = $data['sku']['wxapp_id'] = self::$wxapp_id;
        $data['supplier_id'] = self::$supplier_id;


        
        $data['is_points_gift'] = 0;
        $data['is_points_discount'] = 0;
        $data['is_enable_grade'] = 0;


        // 开启事务
        $this->startTrans();
        try {
            // 添加商品
            $this->allowField(true)->save($data);
            // 商品规格
            $this->addGoodsSpec($data);
            // 商品图片
            $this->addGoodsImages($data['images']);
            $this->commit();
            return true;
        } catch (\Exception $e) {
            $this->error = $e->getMessage();
            $this->rollback();
            return false;
        }
    }

    /**
     * 添加商品图片
     * @param $images
     * @return int
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    private function addGoodsImages($images)
    {
        $this->image()->delete();
        $data = array_map(function ($image_id) {
            return [
                'image_id' => $image_id,
                'wxapp_id' => self::$wxapp_id
            ];
        }, $images);
        return $this->image()->saveAll($data);
    }

    /**
     * 编辑商品
     * @param $data
     * @return bool|mixed
     */
    public function edit($data)
    {
        if (!isset($data['images']) || empty($data['images'])) {
            $this->error = '请上传商品图片';
            return false;
        }
        $data['spec_type'] = isset($data['spec_type']) ? $data['spec_type'] : $this['spec_type'];
        $data['content'] = isset($data['content']) ? $data['content'] : '';
        $data['wxapp_id'] = $data['sku']['wxapp_id'] = self::$wxapp_id;
        $data['supplier_id'] = self::$supplier_id;
        return $this->transaction(function () use ($data) {
            // 保存商品
            $this->allowField(true)->save($data);
            // 商品规格
            $this->addGoodsSpec($data, true);
            // 商品图片
            $this->addGoodsImages($data['images']);
            return true;
        });
    }

    /**
     * 添加商品规格
     * @param $data
     * @param $isUpdate
     * @throws \Exception
     */
    private function addGoodsSpec($data, $isUpdate = false)
    {
        // 更新模式: 先删除所有规格
        $model = new GoodsSku;
        $isUpdate && $model->removeAll($this['goods_id']);
        // 添加规格数据
        if ($data['spec_type'] == '10') {
            // 单规格
            $this->sku()->save($data['sku']);
        } else if ($data['spec_type'] == '20') {
            // 添加商品与规格关系记录
            $model->addGoodsSpecRel($this['goods_id'], $data['spec_many']['spec_attr']);
            // 添加商品sku
            $model->addSkuList($this['goods_id'], $data['spec_many']['spec_list']);
        }
    }

    /**
     * 修改商品状态
     * @param $state
     * @return false|int
     */
    public function setStatus($state)
    {
        return $this->allowField(true)->save(['goods_status' => $state ? 10 : 20]) !== false;
    }

    /**
     * 软删除
     * @return false|int
     */
    public function setDelete()
    {
        if (!GoodsService::checkIsAllowDelete($this['goods_id'])) {
            $this->error = '当前商品正在参与其他活动，不允许删除';
            return false;
        }
        return $this->allowField(true)->save(['is_delete' => 1]);
    }

    /**
     * 获取当前商品总数
     * @param array $where
     * @return int|string
     * @throws \think\Exception
     */
    public function getGoodsTotal($where = [])
    {
        return $this->where('is_delete', '=', 0)->where($where)->count();
    }

    /**
     * 获取商品列表
     * @param $param
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function getList($param)
    {
        // 商品列表获取条件
        $params = array_merge([
            'status' => 10,         // 商品状态
            'category_id' => 0,     // 分类id
            'search' => '',         // 搜索关键词
            'sortType' => 'all',    // 排序类型
            'sortPrice' => false,   // 价格排序 高低
            'listRows' => 15,       // 每页数量
        ], $param);
        // 筛选条件
        $filter = [];
        $params['category_id'] > 0 && $filter['category_id'] = ['IN', Category::getSubCategoryId($params['category_id'])];
        $params['status'] > 0 && $filter['goods_status'] = $params['status'];
        !empty($params['search']) && $filter['goods_name'] = ['like', '%' . trim($params['search']) . '%'];
        // 排序规则
        $sort = [];
        if ($params['sortType'] === 'all') {
            $sort = ['goods_sort', 'goods_id' => 'desc'];
        } elseif ($params['sortType'] === 'sales') {
            $sort = ['goods_sales' => 'desc'];
        } elseif ($params['sortType'] === 'price') {
            $sort = $params['sortPrice'] ? ['goods_max_price' => 'desc'] : ['goods_min_price' => 'asc'];
        }
        // 商品表名称
        $tableName = $this->getTable();
        // 多规格商品 最高价与最低价
        $GoodsSku = new GoodsSku;
        $minPriceSql = $GoodsSku->field(['MIN(goods_price)'])
            ->where('goods_id', 'EXP', "= `$tableName`.`goods_id`")->buildSql();
        $maxPriceSql = $GoodsSku->field(['MAX(goods_price)'])
            ->where('goods_id', 'EXP', "= `$tableName`.`goods_id`")->buildSql();
        // 执行查询
        $list = $this
            ->field(['*', '(sales_initial + sales_actual) as goods_sales',
                "$minPriceSql AS goods_min_price",
                "$maxPriceSql AS goods_max_price"
            ])
            ->with(['category', 'image.file', 'sku'])
            ->where('is_delete', '=', 0)
            ->where('supplier_id', '=', self::$supplier_id)
            ->where($filter)
            ->order($sort)
            ->paginate($params['listRows'], false, [
                'query' => \request()->request()
            ]);
        // 整理列表数据并返回
        return $this->setGoodsListData($list, true);
    }
}
