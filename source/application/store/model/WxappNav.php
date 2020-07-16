<?php

namespace app\store\model;

use app\common\model\WxappNav as WxappNavModel;

/**
 * 微信小程序导航模板
 * Class WxappNav
 * @package app\store\model
 */
class WxappNav extends WxappNavModel
{


    /**
     * 数据处理
     * @param $data
     * @return bool
     */
    public function edit($data)
    {
        // 删除wxapp缓存
        Wxapp::deleteCache();

        $isCheck =  $this->get(['wxapp_id'=>self::$wxapp_id]);

//        halt($isCheck);exit;

        if ($isCheck){
           return $this->save(['nav_data' => $data],['wxapp_id' => self::$wxapp_id]);
        }

        return $this->save([
            'nav_data' => $data,
            'wxapp_id' => self::$wxapp_id
        ]);

    }

}