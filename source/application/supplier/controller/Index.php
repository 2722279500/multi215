<?php

namespace app\supplier\controller;
use app\supplier\model\Index as IndexModel;


/**
 * 后台首页
 * Class Index
 * @package app\supplier\controller
 */
class Index extends Controller
{
    /**
     * 后台首页
     * @return mixed
     */
    public function index()
    {
    	$m = new IndexModel();
        $this->assign('day_money',$m->getDay());
        $this->assign('week_money',$m->getWeek());
        $this->assign('month_money',$m->getMonth());
        $this->assign('seven_list',$m->getSevenList());
        $this->assign('sell_well_list',$m->getSellWellList());
        $this->assign('consume_list',$m->getConsumeList());


        $week_list['seven']   = $this->citrixChangeWeek(date("w",time()-(86400*6)));
        $week_list['six']     = $this->citrixChangeWeek(date("w",time()-(86400*5)));
        $week_list['five']    = $this->citrixChangeWeek(date("w",time()-(86400*4)));
        $week_list['four']    = $this->citrixChangeWeek(date("w",time()-(86400*3)));
        $week_list['three']   = $this->citrixChangeWeek(date("w",time()-(86400*2)));
        $week_list['two']     = $this->citrixChangeWeek(date("w",time()-(86400)));
        $week_list['one']     = $this->citrixChangeWeek(date("w",time()));

        $week_list = implode(',',$week_list);
        $this->assign('week_list',$week_list);
        return $this->fetch('index');
    }
    public function citrixChangeWeek($int)
    {
        switch ($int) {
            case 1:
                return "'周一'";
                break;
            case 2:
                return "'周二'";
                break;
            case 3:
                return "'周三'";
                break;
            case 4:
                return "'周四'";
                break;
            case 5:
                return "'周五'";
                break;
            case 6:
                return "'周六'";
                break;
            default:
                return "'周日'";
                break;
        }
    }
}
