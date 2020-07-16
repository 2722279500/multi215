<?php

namespace app\common\model\merchant;

use app\common\model\BaseModel;

/**
 * 商家模型
 * Class Active
 * @package app\common\model\merchant
 */
class Active extends BaseModel
{
    protected $name = 'merchant_active';
    protected $alias = 'active';

    // protected $type = [
    //     'is_self_cut' => 'integer',
    //     'is_floor_buy' => 'integer',
    //     'status' => 'integer',
    // ];

    // /**
    //  * 追加的字段
    //  * @var array $append
    //  */
    // protected $append = [
    //     'is_start',   // 活动已开启
    //     'is_end',   // 活动已结束
    //     'active_sales', // 活动销量
    // ]; 

    /**
     * 关联商品分类表
     * @return \think\model\relation\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo('Category');
    }

    // /**
    //  * 获取器：活动开始时间
    //  * @param $value
    //  * @return false|string
    //  */
    // public function getStartTimeAttr($value)
    // {
    //     return \format_time($value);
    // }

    // /**
    //  * 获取器：活动结束时间
    //  * @param $value
    //  * @return false|string
    //  */
    // public function getEndTimeAttr($value)
    // {
    //     return \format_time($value);
    // }

    // /**
    //  * 获取器：活动是否已开启
    //  * @param $value
    //  * @param $data
    //  * @return false|string
    //  */
    // public function getIsStartAttr($value, $data)
    // {
    //     return $value ?: $data['start_time'] <= time();
    // }

    // /**
    //  * 获取器：活动是否已结束
    //  * @param $value
    //  * @param $data
    //  * @return false|string
    //  */
    // public function getIsEndAttr($value, $data)
    // {
    //     return $value ?: $data['end_time'] <= time();
    // }

    // /**
    //  * 获取器：显示销量
    //  * @param $value
    //  * @param $data
    //  * @return false|string
    //  */
    // public function getActiveSalesAttr($value, $data)
    // {
    //     return $value ?: $data['actual_sales'] + $data['initial_sales'];
    // }

    /**
     * 商家详情
     * @param $activeId
     * @param array $with
     * @return static|null
     * @throws \think\exception\DbException
     */
    public static function detail($activeId, $with = [])
    {
        $info = static::get($activeId, $with);
        return $info;
    }

    /**
     * 获取商家列表
     * @param $param
     * @return mixed
     * @throws \think\exception\DbException
     */
    // public function getList($param)
    // {
        /*// 商品列表获取条件
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
            $sort = $params['sortPrice'] ? ['goods_max_price' => 'desc'] : ['goods_min_price'];
        }
        // 商品表名称
        $tableName = $this->getTable();
        // 多规格商品 最高价与最低价
        $GoodsSku = new GoodsSku;
        $minPriceSql = $GoodsSku->field(['MIN(sharing_price)'])
            ->where('goods_id', 'EXP', "= `$tableName`.`goods_id`")->buildSql();
        $maxPriceSql = $GoodsSku->field(['MAX(sharing_price)'])
            ->where('goods_id', 'EXP', "= `$tableName`.`goods_id`")->buildSql();
        // 执行查询
        $list = $this
            ->field(['*', '(sales_initial + sales_actual) as goods_sales',
                "$minPriceSql AS goods_min_price",
                "$maxPriceSql AS goods_max_price"
            ])
            ->with(['category', 'image.file', 'sku'])
            ->where('is_delete', '=', 0)
            ->where($filter)
            ->order($sort)
            ->paginate($params['listRows'], false, [
                'query' => \request()->request()
            ]);
        // 整理列表数据并返回
        return $this->setGoodsListData($list, true);*/
    // }

}