<?php

namespace app\store\controller\market;

use app\store\controller\Controller;
use app\store\model\RechargeCard as RechargeCardModel;
use app\common\library\wechat\Qrcode;
use app\common\model\Wxapp as WxappModel;
use app\store\model\Setting as SettingModel;
use app\common\model\UploadFile;

/**
 * 储值卡管理
 * Class RechargeCard
 * @package app\store\controller\market
 */
class Rechargecard extends Controller
{
    /* @var RechargeCardModel $model */
    private $model;

    /**
     * 构造方法
     * @throws \app\common\exception\BaseException
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function _initialize()
    {
        parent::_initialize();
        $this->model = new RechargeCardModel;
    }

    /**
     * 储值卡列表
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function index()
    {
        $list = $this->model->getList($this->request->param());
        return $this->fetch('index', compact('list'));
    }

    /**
     * 储值卡设置
     * @return array|bool|mixed
     * @throws \think\exception\DbException
     */
    public function setting()
    {
        if (!$this->request->isAjax()) {
            $values = SettingModel::getItem('rechargecard');
            $values['logo'] = UploadFile::detail($values['logo_image_id']);
            return $this->fetch('setting', ['values' => $values]);
        }
        $model = new SettingModel;
        if ($model->edit('rechargecard', $this->postData('rechargecard'))) {
            return $this->renderSuccess('操作成功');
        }
        return $this->renderError($model->getError() ?: '操作失败');
    }

    /**
     * 储值卡信息导出
     * @param string $dataType
     * @throws \think\exception\DbException
     */
    public function export()
    {
        return $this->model->exportList($this->request->param());
    }

    /**
     * 添加储值卡
     * @return array|mixed
     */
    public function add()
    {
        if (!$this->request->isAjax()) {
            return $this->fetch('add');
        }
        //修改最大执行时答间
        ini_set('max_execution_time', '0');
        //修改此次最大运行内存
        ini_set('memory_limit','128M');
        $input = $this->postData('rechargecard');
        $total = intval($input['total']);
        unset($input['total']);
        if ($total < 1) {
            return $this->renderError('添加失败');
        }
        for ($i = 1; $i <= $total; $i++) {
            $data = $input;
            $data['uname']  = $input['prefix'] . date('YmdHis') . randStr(8);
            $data['passwd'] = randStr(8, 'ALPHA');
            if (! $this->model->add($data)) {
                return $this->renderError($this->model->getError() ?: '添加失败');
            }
            $id = $this->model->getLastInsID();
            $qrcode = $this->saveQrcode(
                $this->getWxappId(),
                "rcid:{$id}",
                'pages/rechargecard/index'
            );
            $update = $this->savePoster($qrcode, $id);
            if (! $this->model->allowField(true)->save([
                'qrcode' => $update
            ], [
                'recharge_card_id' => $id
            ])) {
                return $this->renderError($this->model->getError() ?: '添加失败');
            }
        }
        return $this->renderSuccess('添加成功', url('market.rechargecard/index'));
    }

    /**
     * 更新储值卡
     * @param $recharge_card_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function edit($recharge_card_id)
    {
        // 储值卡详情
        $model = RechargeCardModel::detail($recharge_card_id);
        if (!$this->request->isAjax()) {
            return $this->fetch('edit', compact('model'));
        }
        // 更新记录
        if ($model->edit($this->postData('rechargecard'))) {
            return $this->renderSuccess('更新成功', url('market.rechargecard/index'));
        }
        return $this->renderError($model->getError() ?: '更新失败');
    }

    /**
     * 删除储值卡
     * @param $recharge_card_id
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function delete($recharge_card_id)
    {
        // 储值卡详情
        $model = RechargeCardModel::detail($recharge_card_id);
        // 更新记录
        if ($model->delete()) {
            return $this->renderSuccess('删除成功', url('market.rechargecard/index'));
        }
        return $this->renderError($model->getError() ?: '删除成功');
    }

    /**
     * 领取记录
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function receive()
    {
        $list = $this->model->getReceiveList();
        return $this->fetch('receive', compact('list'));
    }

    /**
     * 保存小程序码到文件
     * @param $wxapp_id
     * @param $scene
     * @param null $page
     * @return string
     * @throws \app\common\exception\BaseException
     * @throws \think\exception\DbException
     */
    protected function saveQrcode($wxapp_id, $scene, $page = null)
    {
        // 文件目录
        $dirPath = RUNTIME_PATH . 'image' . '/' . $wxapp_id;
        !is_dir($dirPath) && mkdir($dirPath, 0755, true);
        // 文件名称
        $fileName = 'qrcode_' . md5($wxapp_id . $scene . $page) . '.png';
        // 文件路径
        $savePath = "{$dirPath}/{$fileName}";
        if (file_exists($savePath)) return $savePath;
        // 小程序配置信息
        $wxConfig = WxappModel::getWxappCache($wxapp_id);
        // 请求api获取小程序码
        $Qrcode = new Qrcode($wxConfig['app_id'], $wxConfig['app_secret']);
        $content = $Qrcode->getQrcode($scene, $page);
        // 保存到文件
        file_put_contents($savePath, $content);
        return $savePath;
    }

    private function savePoster($qrcode, $key)
    {
        copy($qrcode, $this->getPosterPath($key));
        return $this->getPosterUrl($key);
    }

    /**
     * 二维码文件路径
     * @return string
     */
    private function getPosterPath($key)
    {
        // 保存路径
        $tempPath = WEB_PATH . "rechargecard/{$this->getWxappId()}/";
        !is_dir($tempPath) && mkdir($tempPath, 0755, true);
        return $tempPath . $this->getPosterName($key);
    }

    /**
     * 二维码文件名称
     * @return string
     */
    private function getPosterName($key)
    {
        return 'rechargecard_' . md5("rechargecard_{$key}") . '.png';
    }

    /**
     * 二维码url
     * @return string
     */
    private function getPosterUrl($key)
    {
        return \base_url() . 'rechargecard/' . $this->getWxappId() . '/' . $this->getPosterName($key) . '?t=' . time();
    }

}