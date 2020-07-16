<?php

namespace app\api\controller\recharge;

use app\api\controller\Controller;
use app\store\model\RechargeCard as RechargeCardModel;
use app\store\model\Setting as SettingModel;
use app\common\model\UploadFile;

/**
 * 储值卡
 * Class Order
 * @package app\api\controller\user\balance
 */
class Card extends Controller
{
    /**
     * 储值卡充值
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    public function submit()
    {
        // 1-扫码充值，2-账号充值
        $type = $this->request->param('type');
        if (!in_array($type, [1, 2])) {
            return $this->renderError('充值方式错误');
        }
        $user = $this->getUser();
        $model = new RechargeCardModel;
        if ($type == 1) {
            $rcid = $this->request->param('rcid');
            if ($model->scan($user, $rcid)) {
                return $this->renderSuccess([], '充值成功');
            }
        } else {
            $uname = $this->request->param('uname');
            $passwd = $this->request->param('passwd');
            if ($model->receive($user, $uname, $passwd)) {
                return $this->renderSuccess([], '充值成功');
            }
        }
        return $this->renderError($model->getError() ?: '充值失败');
    }

    /**
     * 储值卡设置
     * @return array
     * @throws \app\common\exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index()
    {
        // 用户信息
        $userInfo = $this->getUser();
        // 充值设置
        $setting = SettingModel::getItem('rechargecard');
        $logo = UploadFile::detail($setting['logo_image_id']);
        $setting['logo'] = $logo['file_path'];
        return $this->renderSuccess(compact('userInfo', 'setting'));
    }

}