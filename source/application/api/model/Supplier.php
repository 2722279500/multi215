<?php

namespace app\api\model;
use think\Db;
/**
 * 多商户管理
 * Class Cart
 * @package app\api\model
 */
class Supplier
{
 	/**
     * 根据城市获取商户列表
     * @return array
     */
    public function getSupplierList($post)
    {

        $page = empty($post['page'])?1:$post['page'];
        $count = empty($post['count'])?10:$post['count'];
        $page = $page == 1?0:($page-1)*$count;
        $list = Db::name("merchant_active")
                    ->where(['status'=>1])
                    ->where(['is_delete'=>0])
        			->where("start_time","<",time())
        			->where("end_time",">",time())
        			->where(['city_id'=>$post['cityId']])
        			->field("active_id,name,thumb_id")
        			->order("active_id DESC")
			        ->limit("{$page},{$count}")
			    	->select()
                    ->toArray();


        $dbFile = Db::name("upload_file");
        $dbGoods = Db::name("goods");
        foreach ($list as $k1 => $v1) 
        {
            $list[$k1]['thumb'] = $dbFile->where("file_id",$list[$k1]['thumb_id'])->value("file_name");
            $list[$k1]['goods_count'] = $dbGoods->where("supplier_id",$list[$k1]['active_id'])->where(["goods_status"=>10])->count();
            $list[$k1]['thumb'] = base_url()."uploads/".$list[$k1]['thumb'];
            $list[$k1]['supplier_id'] = $list[$k1]['active_id'];
            unset($list[$k1]['thumb_id']);
            unset($list[$k1]['active_id']);
        }
    	return $list;
    }
    /**
     * 根据商户id获取商户详情
     * @return array
     */
    public function getSupplierInfo($post)
    {
        $info = Db::name("merchant_active")
                    ->field("active_id as supplier_id,name,thumb_id as thumb,image_id as image,description")
                    ->where("start_time","<",time())
                    ->where("end_time",">",time())
                    ->where(['status'=>1])
                    ->where(['is_delete'=>0])
                    ->where(['active_id'=>$post['supplier_id']])
                    ->find();
        $dbFile = Db::name("upload_file");
        $info['thumb'] = $dbFile->where("file_id",$info['thumb'])->value("file_name");
        $info['thumb'] = base_url()."uploads/".$info['thumb'];
        $info['image'] = $dbFile->where("file_id",$info['image'])->value("file_name");
        $info['image'] = base_url()."uploads/".$info['image'];
        return $info;
    }
    /**
     * 根据商户id获取商品列表
     * @return array
     */
    public function getSupplierGoodsList($post)
    {
        $page = empty($post['page'])?1:$post['page'];
        $count = empty($post['count'])?10:$post['count'];
        $search = empty($post['search'])?'':$post['search'];//搜索条件
        $supplier_id = empty($post['supplier_id'])?0:$post['supplier_id'];//商户id
        $is_autarky = empty($post['is_autarky'])?0:1;//是否显示自营商品(1不允许0允许)
        $page = $page == 1?0:($page-1)*$count;
        $where = empty($search)?[]:['g.goods_name'=>['like',"%{$search}%"]];
        $where['g.goods_status'] = 10;
        $where['g.is_delete'] = 0;
        $where['g.supplier_id'] = empty($is_autarky)?['IN',[0,$post['supplier_id']]]:$post['supplier_id'];
        $base_url = base_url()."uploads/";
        $list = Db::name("goods")
                ->field("g.`goods_id`,g.`goods_name`,g.`category_id`,g.`goods_sort`,g.`supplier_id`,g.`goods_status`,g.is_delete,i.image_id,concat('".$base_url."',f.file_name) as file_name,s.goods_price,s.line_price")
                ->alias('g')
                ->join('goods_image i','i.goods_id = g.goods_id')
                ->join('upload_file f','f.file_id = i.image_id')  
                ->join('goods_sku s','s.goods_id = i.goods_id')  
                ->where($where)
                ->limit("{$page},{$count}")
                ->group('g.goods_id')
                ->select();
        return $list;
    }

}