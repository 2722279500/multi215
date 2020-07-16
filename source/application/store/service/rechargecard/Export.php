<?php

namespace app\store\service\rechargecard;

/**
 * 储值卡导出服务类
 * Class Export
 * @package app\store\service\order
 */
class Export
{
    /**
     * 表格标题
     * @var array
     */
    private $tileArray = [
        '储值卡账号', '储值卡密码', '储值卡金额', '有效期', '二维码'
    ];

    /**
     * 储值卡导出
     * @param $list
     */
    public function rechargecardList($list)
    {
        // 表格内容
        $dataArray = [];
        foreach ($list as $item) {
            $dataArray[] = [
                '储值卡账号' => $this->filterValue($item['uname']),
                '储值卡密码' => $this->filterValue($item['passwd']),
                '储值卡金额' => $this->filterValue($item['price']),
                '有效期至' => $this->filterExpire($item),
                '二维码' => $this->filterValue($item['qrcode']),
            ];
        }
        // 导出csv文件
        $filename = 'rechargecard-' . date('YmdHis');
        return export_excel($filename . '.csv', $this->tileArray, $dataArray);
    }

    /**
     * 格式化商品信息
     * @param $order
     * @return string
     */
    private function filterExpire($item)
    {
        $expire = '';
        if ($item['expire_type'] == 10) {
            $expire = date('Y-m-d', strtotime($item['create_time']) + $item['expire_day'] * 86400);
        } elseif ($item['expire_type'] == 10) {
            $expire = date('Y-m-d', $item['end_time']['value'] + 86400);
        }
        return $expire;
    }

    /**
     * 表格值过滤
     * @param $value
     * @return string
     */
    private function filterValue($value)
    {
        return "\t" . $value . "\t";
    }

    /**
     * 日期值过滤
     * @param $value
     * @return string
     */
    private function filterTime($value)
    {
        if (!$value) return '';
        return $this->filterValue(date('Y-m-d H:i:s', $value));
    }

}