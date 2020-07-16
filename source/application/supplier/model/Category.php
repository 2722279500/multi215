<?php

namespace app\supplier\model;

use think\Cache;
use app\common\model\Category as CategoryModel;

/**
 * 商品分类模型
 * Class Category
 * @package app\supplier\model
 */
class Category extends CategoryModel
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
     * 添加新记录
     * @param $data
     * @return false|int
     */
    public function add($data)
    {
        $data['wxapp_id'] = self::$wxapp_id;
        $data['supplier_id'] = self::$supplier_id;
//        if (!empty($data['image'])) {
//            $data['image_id'] = UploadFile::getFildIdByName($data['image']);
//        }
        $this->deleteCache();
        return $this->allowField(true)->save($data);
    }

    /**
     * 编辑记录
     * @param $data
     * @return bool|int
     */
    public function edit($data)
    {
        $data['supplier_id'] = self::$supplier_id;
        // 验证：一级分类如果存在子类，则不允许移动
        if ($data['parent_id'] > 0 && static::hasSubCategory($this['category_id'])) {
            $this->error = '该分类下存在子分类，不可以移动';
            return false;
        }
        $this->deleteCache();
        !array_key_exists('image_id', $data) && $data['image_id'] = 0;
        return $this->allowField(true)->save($data) !== false;
    }

    /**
     * 删除商品分类
     * @param $categoryId
     * @return bool|int
     */
    public function remove($categoryId)
    {
        // 判断是否存在商品
        if ($goodsCount = (new Goods)->getGoodsTotal(['category_id' => $categoryId])) {
            $this->error = '该分类下存在' . $goodsCount . '个商品，不允许删除';
            return false;
        }
        // 判断是否存在子分类
        if (static::hasSubCategory($categoryId)) {
            $this->error = '该分类下存在子分类，请先删除';
            return false;
        }
        $this->deleteCache();
        return $this->delete();
    }

    /**
     * 删除缓存
     * @return bool
     */
    private function deleteCache()
    {
        return Cache::rm('category_' . static::$wxapp_id);
    }

     /**
     * 所有分类
     * @return mixed
     */
    public static function getALL()
    {
        $model = new static;
        // if (!Cache::get('category_' . $model::$wxapp_id)) {
            $data = $model
                    ->where('supplier_id', '=', self::$supplier_id)
                    ->with(['image'])
                    ->order(['sort' => 'asc', 'create_time' => 'asc'])
                    ->select();
            $all = !empty($data) ? $data->toArray() : [];
            $tree = [];
            foreach ($all as $first) {
                if ($first['parent_id'] != 0) continue;
                $twoTree = [];
                foreach ($all as $two) {
                    if ($two['parent_id'] != $first['category_id']) continue;
                    $threeTree = [];
                    foreach ($all as $three)
                        $three['parent_id'] == $two['category_id']
                        && $threeTree[$three['category_id']] = $three;
                    !empty($threeTree) && $two['child'] = $threeTree;
                    $twoTree[$two['category_id']] = $two;
                }
                if (!empty($twoTree)) {
                    array_multisort(array_column($twoTree, 'sort'), SORT_ASC, $twoTree);
                    $first['child'] = $twoTree;
                }
                $tree[$first['category_id']] = $first;
                // p($tree);
            }

                return compact('all', 'tree');
            // Cache::tag('cache')->set('category_' . $model::$wxapp_id, compact('all', 'tree'));
        // }
        // return Cache::get('category_' . $model::$wxapp_id);
    }
    /**
     * 获取所有分类
     * @return mixed
     */
    public static function getCacheAll()
    {
        return self::getALL()['all'];
    }

    /**
     * 获取所有分类(树状结构)
     * @return mixed
     */
    public static function getCacheTree()
    {
        return self::getALL()['tree'];
    }


}
