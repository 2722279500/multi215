<?php

namespace app\store\model;

use app\common\model\RechargeCard as RechargeCardModel;
use app\api\model\user\BalanceLog as BalanceLogModel;
use app\common\enum\user\balanceLog\Scene as SceneEnum;
use app\store\service\rechargecard\Export as Exportservice;
use app\api\model\recharge\Order as OrderModel;

/**
 * 用户储值卡模型
 * Class RechargeCard
 * @package app\store\model
 */
class RechargeCard extends RechargeCardModel
{
    /**
     * 获取储值卡列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getList($query = [])
    {
        // 检索查询条件
        !empty($query) && $this->setWhere($query);
        return $this->order(['create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => request()->request()
            ]);
    }

    /**
     * 储值卡信息导出
     * @param $query
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function exportList($query)
    {
        // 获取订单列表
        $list = $this->getListAll($query);
        // 导出csv文件
        return (new Exportservice)->rechargecardList($list);
    }

    /**
     * 储值卡信息列表(全部)
     * @param array $query
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getListAll($query = [])
    {
        // 检索查询条件
        !empty($query) && $this->setWhere($query);
        // 获取数据列表
        return $this->order(['create_time' => 'desc'])->select();
    }

    /**
     * 设置检索查询条件
     * @param $query
     */
    private function setWhere($query)
    {
        if (isset($query['start_time']) && !empty($query['start_time'])) {
            $this->where('create_time', '>=', strtotime($query['start_time']));
        }
        if (isset($query['end_time']) && !empty($query['end_time'])) {
            $this->where('create_time', '<', strtotime($query['end_time']) + 86400);
        }
        if (isset($query['is_use']) && !empty($query['is_use'])) {
            $query['is_use'] > -1 && $this->where('is_use', '=', $query['is_use']);
        }
    }

    /**
     * 添加新记录
     * @param $data
     * @return false|int
     */
    public function add($data)
    {
        $data['wxapp_id'] = self::$wxapp_id;
        if ($data['expire_type'] == '20') {
            $data['start_time'] = strtotime($data['start_time']);
            $data['end_time'] = strtotime($data['end_time']);
        }
        return $this->newInstance()->allowField(true)->save($data);
    }

    /**
     * 更新记录
     * @param $data
     * @return bool|int
     */
    public function edit($data)
    {
        if ($data['expire_type'] == '20') {
            $data['start_time'] = strtotime($data['start_time']);
            $data['end_time'] = strtotime($data['end_time']);
        }
        return $this->allowField(true)->save($data) !== false;
    }

    /**
     * 获取储值卡列表
     * @return \think\Paginator
     * @throws \think\exception\DbException
     */
    public function getReceiveList()
    {
        return $this->with(['user'])
            ->where(['is_use' => 1])
            ->order(['create_time' => 'desc'])
            ->paginate(15, false, [
                'query' => request()->request()
            ]);
    }

    /**
     * 扫码充值
     * @param $user
     * @param $recharge_card_id
     * @return bool|false|int
     * @throws \think\exception\DbException
     */
    public function scan($user, $recharge_card_id)
    {
        // 获取储值卡信息
        $recharge_card = RechargeCardModel::detail($recharge_card_id);
        // 验证储值卡是否可充值
        if (!$this->checkReceive($user, $recharge_card)) {
            return false;
        }
        $recharge_card->transaction(function () use ($recharge_card, $user) {
            // 更新储值卡状态
            $recharge_card->save([
                'is_use' => 1,
                'user_id' => $user['user_id'],
                'receive_time' => time()
            ], [
                'recharge_card_id' => $recharge_card->recharge_card_id
            ]);
            // 累积用户余额
            $user->setInc('balance', $recharge_card->price);
            // 用户余额变动明细
            BalanceLogModel::add(SceneEnum::CARD, [
                'user_id'  => $user['user_id'],
                'money'    => $recharge_card->price,
                'wxapp_id' => $recharge_card->wxapp_id,
            ], ['order_no' => $recharge_card->uname]);
            // 创建储值卡充值订单
            $model = new OrderModel;
            $model->createCardOrder($user, $recharge_card->price);
            return true;
        });
        return true;
    }

    /**
     * 账号充值
     * @param $user
     * @param $uname
     * @param $passwd
     * @return bool|false|int
     * @throws \think\exception\DbException
     */
    public function receive($user, $uname, $passwd)
    {
        // 获取储值卡信息
        $recharge_card = RechargeCardModel::get([
            'uname' => $uname,
            'passwd' => $passwd,
        ]);
        // 验证储值卡是否可充值
        if (!$this->checkReceive($user, $recharge_card)) {
            return false;
        }
        $recharge_card->transaction(function () use ($recharge_card, $user) {
            // 更新储值卡状态
            $recharge_card->save([
                'is_use' => 1,
                'user_id' => $user['user_id'],
                'receive_time' => time()
            ], [
                'recharge_card_id' => $recharge_card->recharge_card_id
            ]);
            // 累积用户余额
            $user->setInc('balance', $recharge_card->price);
            // 用户余额变动明细
            BalanceLogModel::add(SceneEnum::CARD, [
                'user_id'  => $user['user_id'],
                'money'    => $recharge_card->price,
                'wxapp_id' => $recharge_card->wxapp_id,
            ], ['order_no' => $recharge_card->uname]);
            // 创建储值卡充值订单
            $model = new OrderModel;
            $model->createCardOrder($user, $recharge_card->price);
            return true;
        });
        return true;
    }

    /**
     * 验证储值卡是否可充值
     * @param $user
     * @param RechargeCardModel $recharge_card
     * @return bool
     */
    private function checkReceive($user, $recharge_card)
    {
        if (!$recharge_card) {
            $this->error = '储值卡不存在';
            return false;
        }
        if (!$recharge_card->recharge_card_id) {
            $this->error = '储值卡不存在';
            return false;
        }
        // 验证是否已充值
        if (!empty($recharge_card->is_use)) {
            $this->error = '该储值卡已被充值，请更换其他储值卡';
            return false;
        }
        // 验证是否已过期
        if (!empty($recharge_card->is_expire)) {
            $this->error = '储值卡已过期';
            return false;
        }
        if ($recharge_card->expire_type == 10 && (strtotime($recharge_card->create_time) + $recharge_card->expire_day * 86400) < time()) {
            $this->error = '储值卡已过期';
            return false;
        }
        if ($recharge_card->expire_type == 20 && ($recharge_card->end_time['value'] + 86400) < time()) {
            $this->error = '优惠券已过期';
            return false;
        }
        return true;
    }

}