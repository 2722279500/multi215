<?php
// +----------------------------------------------------------------------
// | tpCitrix [ WE ONLY DO WHAT IS NECESSARY ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019 http://tpCitrix.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: tpCitrix < 2722279500@qq.com >
// +----------------------------------------------------------------------

namespace app\supplier\model;
use \think\Db;
use \think\Model;
use \think\Session;
class Bankcard extends Model
{
	public static $supplier_id;
	public static $wxapp_id;
	public static $yoshop_supplier;
    /**
     * 模型基类初始化
     */
    public static function init()
    {
        parent::init();
        self::$yoshop_supplier = Session::get("yoshop_supplier.user");
        self::$supplier_id = self::$yoshop_supplier['supplier_user_id'];
        self::$wxapp_id = self::$yoshop_supplier['wxapp_id'];

    }
    /**
     * 银行卡列表
     * @return mixed
     */
    public function getList()
    {
        $list = Db::name("merchant_bankcard")
            ->field("id,name,type,create_time,username")
            ->where(['supplier_id'=>self::$supplier_id,"wxapp_id"=>self::$wxapp_id])
            ->order('update_time desc,create_time desc')
            ->select();
        return $list;
    }
    /**
     * 银行卡列表
     * @return mixed
     */
    public function add()
    {
        if(\Request()->isAjax())
        {
            $post = Request()->post();
            //验证  唯一规则： 表名，字段名，排除主键值，主键名
            $validate = new \think\Validate([
                ['name', 'require|min:10|max:19', '银行卡名称不能为空|银行卡名称最小输入10位数字|银行卡名称最大输入19位数字'],
                ['type', 'require|chs', '所属银行不能为空|所属银行格式错误'],
                ['username', 'require|chs', '收款人不能为空|收款人格式错误'],
            ]);
            //验证部分数据合法性
            if (!$validate->check($post)) {
                exit(json_encode(['code'=>0,'msg'=>'提交失败：' . $validate->getError()]));
            }
            $data['name'] = htmlspecialchars($post['name']);
            $data['type'] = htmlspecialchars($post['type']);
            $data['username'] = htmlspecialchars($post['username']);
            $data['create_time'] = time();
            $data['supplier_id'] = self::$supplier_id;
            $data['wxapp_id'] = self::$wxapp_id;
            if(true == Db::name("merchant_bankcard")->where(['supplier_id'=>$data['supplier_id']])->where("create_time",">",time()-60)->find())
            {
                exit(json_encode(['code'=>0,'msg'=>'提交失败：每60秒限制一次']));
            }

            if(true == Db::name("merchant_bankcard")->insert($data))
            {
                exit(json_encode(['code'=>1,'msg'=>'提交成功']));
            }
            exit(json_encode(['code'=>0,'msg'=>'提交失败：添加失败']));
        }
    }
    /**
     * 银行卡列表
     * @return mixed
     */
    public function del()
    {
        $post = Request()->post();
        $data['supplier_id'] = self::$supplier_id;
        $data['wxapp_id'] = self::$wxapp_id;
        $data['id'] = $post['id'];
        if(true == Db::name("merchant_bankcard")->where($data)->delete())
        {
            exit(json_encode(['code'=>1,'msg'=>'删除成功'])); 
        }
        exit(json_encode(['code'=>0,'msg'=>'删除失败'])); 
    }
}