<?php

namespace app\common\model;

use app\common\library\helper;
use think\Cache;
use think\Request;
use think\Db;

/**
 * 拼团商品分类模型
 * Class Category
 * @package app\common\model
 */
class Category extends BaseModel
{
    protected $name = 'category';

    /**
     * 分类图片
     * @return \think\model\relation\HasOne
     */
    public function image()
    {
        return $this->hasOne('uploadFile', 'file_id', 'image_id');
    }

    /**
     * 所有分类
     * @return mixed
     */
    public static function getALL()
    {
        $supplier_id = empty(Request()->param("supplier_id"))?0:Request()->param("supplier_id");
        $is_autarky = empty(Request()->param("is_autarky"))?0:Request()->param("is_autarky");
        $city_id = empty(Request()->param("cityId"))?0:Request()->param("cityId");
        $db_category = Db::name("category");
        $db_merchant = Db::name("merchant_active");
        $model = new static;
        // if (!Cache::get('category_' . $model::$wxapp_id)) {
            $data = $model->with(['image'])->order(['sort' => 'asc', 'create_time' => 'asc'])->select();
            $all = !empty($data) ? $data->toArray() : [];
            $tree = [];
            foreach ($all as $first) 
            {
                if(citrixCheckSupplier())
                {
                    if(!empty($city_id))
                    {
                        if(empty($is_autarky))
                        {
                            $merchant_list = $db_merchant->whereOr(['city_id'=>$city_id])->group("active_id")->column("active_id");
                            $category_list = $db_category->where('supplier_id',"in",$merchant_list)->group("category_id")->column("category_id");
                            if(!empty($first['supplier_id']) && !in_array($first['category_id'],$category_list))
                            {
                                continue;
                            }
                        }else
                        {
                            $merchant_list = $db_merchant->whereOr(['city_id'=>$city_id])->group("active_id")->column("active_id");
                            $category_list = $db_category->where(['supplier_id'=>$supplier_id])->group("category_id")->column("category_id");
                            if(!in_array($first['category_id'],$category_list))
                            {
                                continue;
                            }
                        }  
                    }
                }
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

    /**
     * 获取所有分类(树状结构)
     * @return string
     */
    public static function getCacheTreeJson()
    {
        return helper::jsonEncode(static::getCacheTree());
    }

    /**
     * 获取指定分类下的所有子分类id
     * @param $parent_id
     * @param array $all
     * @return array
     */
    public static function getSubCategoryId($parent_id, $all = [])
    {
        $arrIds = [$parent_id];
        empty($all) && $all = self::getCacheAll();
        foreach ($all as $key => $item) {
            if ($item['parent_id'] == $parent_id) {
                unset($all[$key]);
                $subIds = self::getSubCategoryId($item['category_id'], $all);
                !empty($subIds) && $arrIds = array_merge($arrIds, $subIds);
            }
        }
        return $arrIds;
    }

    /**
     * 指定的分类下是否存在子分类
     * @param $parentId
     * @return bool
     */
    protected static function hasSubCategory($parentId)
    {
        $all = self::getCacheAll();
        foreach ($all as $item) {
            if ($item['parent_id'] == $parentId) {
                return true;
            }
        }
        return false;
    }

}
