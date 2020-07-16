<?php

namespace app\store\model\merchant;

use think\Cache;
use think\Db;
use \think\Model;

/**
 * 商家提现
 * Class Withdraw
 * @package app\store\model\merchant
 */
class Withdraw extends model
{
    /**
     * 获取当前商户的提现列表
     */
	public function getList($dataType, $query = [])
	{
        $list = Db::name("merchant_balance_log")
                ->field("id,supplier_id,money,describe,scene,create_time")
                        ->where("scene","in",[30,40])
                        ->order("id DESC,scene ASC")
                        ->paginate(15, false, [
                      'query' => \request()->request()
                  ])->each(function($item, $key){
            $item['supplier_name'] = Db::name("merchant_active")->where(['active_id'=>$item['supplier_id']])->value("name");
            return $item;
        });   
        return $list;
	}
	/**
     * 转义数据类型条件
     * @param $dataType
     * @return array
     */
    private function transferDataType($dataType)
    {
        // 数据类型
        $filter = [];
        switch ($dataType) {
            case 'delivery':
                $filter = [
                    'pay_status' => 20,
                    'delivery_status' => 10,
                    'order_status' => ['in', [10, 21]]
                ];
                break;
            case 'receipt':
                $filter = [
                    'pay_status' => 20,
                    'delivery_status' => 20,
                    'receipt_status' => 10
                ];
                break;
            case 'pay':
                $filter = ['pay_status' => 10, 'order_status' => 10];
                break;
            case 'complete':
                $filter = ['order_status' => 30];
                break;
            case 'cancel':
                $filter = ['order_status' => 20];
                break;
            case 'all':
                $filter = [];
                break;
        }
        return $filter;
    }
    /**
    *提交提现
    */
    public function add($post)
    {
        //验证  唯一规则： 表名，字段名，排除主键值，主键名
        $validate = new \think\Validate([
            ['bz', 'require|chsAlphaNum', '备注不能为空|只能是汉字、字母和数字'],
        ]);
        //验证部分数据合法性
        if (!$validate->check($post)) {
            exit(json_encode(['code'=>0,'msg'=>'提交失败：' . $validate->getError()]));
        }

        $info = Db::name("merchant_balance_log")->where('scene',"in",['30'])->where(['id'=>$post['id']])->find();
        if(empty($info))
        {
            exit(json_encode(['code'=>0,'msg'=>'提交失败：订单不存在或当前状态不允许操作']));
        }
        $data['describe'] = json_decode($info['describe'],true);
        $data['scene'] = $post['scene'];
        $data['describe']['verify']['bz'] = $post['bz'];
        if(!empty($_FILES['jt']) && $_FILES['jt'] != "undefined")
        {
            $file = request()->file('jt');
            if($file){
                $route = dirname(ROOT_PATH).DS."web".DS . 'capture';
                $files = $file->move($route);
                if($files){
                    $jt = DS.'capture'.DS.$files->getSaveName();
                }else{
                    exit(json_encode(['code'=>0,'msg'=>'提交失败：' . $file->getError()]));
                }
            }
            $data['describe']['verify']['jt'] = $jt;
        }
        $data['describe'] = json_encode($data['describe']);
        if(Db::name("merchant_balance_log")->where(['id'=>$post['id']])->update($data))
        {
            exit(json_encode(['code'=>1,'msg'=>'提交成功']));
        }
        exit(json_encode(['code'=>0,'msg'=>'提交失败：']));
    }
}