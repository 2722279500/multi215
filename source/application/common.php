<?php

// 应用公共函数库文件

use think\Request;
use think\Log;
use think\Db;

/**
 * 打印调试函数
 * @param $content
 * @param $is_die
 */
function pre($content, $is_die = true)
{
    header('Content-type: text/html; charset=utf-8');
    echo '<pre>' . print_r($content, true);
    $is_die && die();
}

/**
 * 驼峰命名转下划线命名
 * @param $str
 * @return string
 */
function toUnderScore($str)
{
    $dstr = preg_replace_callback('/([A-Z]+)/', function ($matchs) {
        return '_' . strtolower($matchs[0]);
    }, $str);
    return trim(preg_replace('/_{2,}/', '_', $dstr), '_');
}

/**
 * 生成密码hash值
 * @param $password
 * @return string
 */
function yoshop_hash($password)
{
    return md5(md5($password) . 'yoshop_salt_SmTRx');
}

/**
 * 获取当前域名及根路径
 * @return string
 */
function base_url()
{
    static $baseUrl = '';
    if (empty($baseUrl)) {
        $request = Request::instance();
        $subDir = str_replace('\\', '/', dirname($request->server('PHP_SELF')));
        $baseUrl = $request->scheme() . '://' . $request->host() . $subDir . ($subDir === '/' ? '' : '/');
    }
    return $baseUrl;
}

/**
 * 写入日志 (废弃)
 * @param string|array $values
 * @param string $dir
 * @return bool|int
 */
//function write_log($values, $dir)
//{
//    if (is_array($values))
//        $values = print_r($values, true);
//    // 日志内容
//    $content = '[' . date('Y-m-d H:i:s') . ']' . PHP_EOL . $values . PHP_EOL . PHP_EOL;
//    try {
//        // 文件路径
//        $filePath = $dir . '/logs/';
//        // 路径不存在则创建
//        !is_dir($filePath) && mkdir($filePath, 0755, true);
//        // 写入文件
//        return file_put_contents($filePath . date('Ymd') . '.log', $content, FILE_APPEND);
//    } catch (\Exception $e) {
//        return false;
//    }
//}

/**
 * 写入日志 (使用tp自带驱动记录到runtime目录中)
 * @param $value
 * @param string $type
 */
function log_write($value, $type = 'yoshop-info')
{
    $msg = is_string($value) ? $value : var_export($value, true);
    Log::record($msg, $type);
}

/**
 * curl请求指定url (get)
 * @param $url
 * @param array $data
 * @return mixed
 */
function curl($url, $data = [])
{
    // 处理get数据
    if (!empty($data)) {
        $url = $url . '?' . http_build_query($data);
    }
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
    $result = curl_exec($curl);
    curl_close($curl);
    return $result;
}

/**
 * curl请求指定url (post)
 * @param $url
 * @param array $data
 * @return mixed
 */
function curlPost($url, $data = [])
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

if (!function_exists('array_column')) {
    /**
     * array_column 兼容低版本php
     * (PHP < 5.5.0)
     * @param $array
     * @param $columnKey
     * @param null $indexKey
     * @return array
     */
    function array_column($array, $columnKey, $indexKey = null)
    {
        $result = array();
        foreach ($array as $subArray) {
            if (is_null($indexKey) && array_key_exists($columnKey, $subArray)) {
                $result[] = is_object($subArray) ? $subArray->$columnKey : $subArray[$columnKey];
            } elseif (array_key_exists($indexKey, $subArray)) {
                if (is_null($columnKey)) {
                    $index = is_object($subArray) ? $subArray->$indexKey : $subArray[$indexKey];
                    $result[$index] = $subArray;
                } elseif (array_key_exists($columnKey, $subArray)) {
                    $index = is_object($subArray) ? $subArray->$indexKey : $subArray[$indexKey];
                    $result[$index] = is_object($subArray) ? $subArray->$columnKey : $subArray[$columnKey];
                }
            }
        }
        return $result;
    }
}
if (!function_exists('p')) {
    //打印
    function p($a)
    {
        if(empty($a))
        {
            echo "<pre>";
                var_dump($a);
            echo "</pre>\r\n";
        }else
        {
            echo "<pre>";
                print_r($a);
            echo "</pre>\r\n";
        }
    }
}
if (!function_exists('citrixCheckSupplier')) 
{
    //检查平台是否开启多商户
    function citrixCheckSupplier()
    {
        if($info = Db::name("merchant_setting")->where(['key'=>'basic'])->find())
        {
            $info['values'] = json_decode($info['values'],true);
            if($info['values']['is_open'] == true)
            {
                return true;
            }
        }
        return false;
    }
}
if (!function_exists('citrixCheckPartialShip')) 
{
    //检查这个订单，自己是不是最后一个发货的
    function citrixCheckPartialShip($supplier_id,$order_id)
    {
        if($list = Db::name("order_goods")->where('supplier_id','NEQ',$supplier_id)->where(['delivery_status'=>10,'order_id'=>$order_id])->group("delivery_status")->column("delivery_status"))
        {
            return $list;
        }
        return false;
    }
}
if (!function_exists('citrixGetShipPrice')) 
{
    //获得当前订单的运费(所属商户)
    function citrixGetShipPrice($supplier_id,$order_id)
    {
        if($list = Db::name("order_goods")->field("order_goods_id,goods_id,total_num as goods_num,goods_sku_id")->where(['supplier_id'=>$supplier_id,"order_id"=>$order_id,"delivery_status"=>10])->select()->toArray())
        {
            return $list;
        }
        return false;
    }
}
if (!function_exists('citrixGetSupplierExpressPrice')) 
{
    //获得当前商户可以获得的运费
    function citrixGetSupplierExpressPrice($order_id,$supplier_id)
    {
        if($express_price = Db::name("order_goods")->where(['supplier_id'=>$supplier_id,"order_id"=>$order_id])->value("express_price"))
        {
            return $express_price;
        }
        return sprintf("%.2f",0);
    }
}
if (!function_exists('citrixCheckFullPackage')) 
{
    //检查是否开启满额包邮
    function citrixCheckFullPackage()
    {
        if($info = Db::name("setting")->where(['key'=>'full_free'])->find())
        {
            $info['values'] = json_decode($info['values'],true);
            if($info['values']['is_open'] == true)
            {
                return true;
            }
        }
        return false;
    }
}
if (!function_exists('citrixGetCouponMoney')) 
{
    //获取这一笔订单,优惠金额
    function citrixGetCouponMoney($order_id,$supplier_id)
    {
        if($coupon_money = Db::name("order")->where(['order_id'=>$order_id])->value("coupon_money"))
        {
            if($info = Db::name("order_goods")->where(['order_id'=>$order_id])->group("supplier_id")->column("supplier_id"))
            {
                if(count($info) == 1 && array_shift($info)==$supplier_id)
                {
                    return "- ￥".sprintf("%.2f",$coupon_money);
                }
                else if(count($info) >= 2)
                {
                    $coupon_money = Db::name("order_goods")->where(['order_id'=>$order_id,'supplier_id'=>$supplier_id])->column("coupon_money");
                    return '<span style="color:#f00;">- ￥'.sprintf("%.2f",array_sum($coupon_money)).'</span>';
                }
            }
        }
        return sprintf("%.2f",0);
    }
}
if (!function_exists('citrixCheckCouponMoney')) 
{
    //这一笔订单当前商户是否使用了自己的优惠劵
    function citrixCheckCouponMoney($order_id,$supplier_id)
    {
        if($coupon_money = Db::name("order")->where(['order_id'=>$order_id])->value("coupon_money"))
        {
            if($info = Db::name("order_goods")->where(['order_id'=>$order_id])->group("supplier_id")->column("supplier_id"))
            {
                if(count($info) == 1 && array_shift($info)==$supplier_id)
                {
                    return true;
                }
            }
        }
        return false;
    }
}
if (!function_exists('citrixExpectedMoney')) 
{
    //当前商户预计可得金额
    function citrixExpectedMoney($order_id,$supplier_id)
    {
        $express_price = Db::name("order_goods")->where(['order_id'=>$order_id,'supplier_id'=>$supplier_id])->group("express_price")->column("express_price");
        if(citrixCheckCouponMoney($order_id,$supplier_id))
        {
            $total_price = Db::name("order_goods")->where(['order_id'=>$order_id,'supplier_id'=>$supplier_id])->column("total_price");
            return sprintf("%.2f",array_sum($express_price)+array_sum($total_price));
        }else
        {
            $total_pay_price = Db::name("order_goods")->where(['order_id'=>$order_id,'supplier_id'=>$supplier_id])->column("total_pay_price");
            return sprintf("%.2f",array_sum($express_price)+array_sum($total_pay_price));
        }
        return sprintf("%.2f",0);
    }
}
if (!function_exists('citrixSupplierProportional')) 
{
    //获取当前商户抽成比例
    function citrixGetSupplierProportional($supplier_id)
    {
        return Db::name("merchant_active")->where(['active_id'=>$supplier_id])->value("supplier_rebate");
    }
}
if (!function_exists('citrixCheckCoupon')) 
{
    //获取当前优惠券所属类型
    function citrixCheckCoupon($coupon_id = 0)
    {
        if($coupon_type = Db::name("coupon")->where(['coupon_id'=>$coupon_id])->value("coupon_type"))
        {
            return $coupon_type;
        }
        return false;
    }
}
if (!function_exists('citrixGetSupplierName')) 
{
    //获取当前商家名称
    function citrixGetSupplierName($supplier_id)
    {
        if(empty($supplier_id))
        {
            return "<span style='color:#5eb95e;'>自营</span>";
        }
        return Db::name("merchant_active")->where(['active_id'=>$supplier_id])->value("name"); 
    }
}
if (!function_exists('citrixCheckisIndDealer')) 
{
    //获取当前系统是否开启了分销
    function citrixCheckisIndDealer()
    {
        if($info = Db::name("dealer_setting")->where(['key'=>'basic'])->find())
        {
            $info['values'] = json_decode($info['values'],true);
            if(empty($info['values']))
            {
                return false;
            }
            return $info['values']['is_open'];
        }
        return false;
    }
}
if (!function_exists('citrixAddSupplierRefund')) 
{
    //多商户商品退款
    function citrixAddSupplierRefund($id)
    {
        $info = Db::name("order_refund")->where(['order_refund_id'=>$id])->find();
        $goods_info = Db::name("order_goods")->where(['order_goods_id'=>$info['order_goods_id']])->find();

        $data['money'] = $goods_info['total_pay_price'];
        $data['supplier_id'] = $info['supplier_id'];
        $data['scene'] = 50;
        $data['wxapp_id'] = $info['wxapp_id'];
        $data['create_time'] = time();
        $data['order_refund_id'] = $info['order_refund_id'];
        $data['describe'] = json_encode(['verify'=>['bz'=>"售后退货退款【{$goods_info['goods_name']}】"]]);

        if(true == Db::name("merchant_balance_log")->where(['supplier_id'=>$data['supplier_id'],'scene'=>20])->where("create_time",">",time()+60)->find())
        {
            return false;
        }
        if(Db::name("merchant_balance_log")->insert($data))
        {
            return true;
        }
        return false;
    }
}

if (!function_exists('citrixDb')) 
{
    /**
     * [citrixDb 获取数据库字段]
     * @param  [type] $db    [数据库]
     * @param  [type] $id    [条件]
     * @param  [type] $field [条件字段]
     * @param  [type] $value [字段结果]
     * @return [type]        [description]
     */
    function citrixDb($db,$field,$id,$value)
    {
        return Db::name($db)->where([$field=>$id])->value($value);
    }
}

if (!function_exists('citrixGetTrade')) 
{
    //获取当前系统多天允许申请售后
    function citrixGetTrade()
    {
        $user = \think\Session::get("yoshop_supplier.user");
        $wxapp_id = $user['wxapp_id'];
        if($info = Db::name("setting")->where(['key'=>'trade','wxapp_id'=>$wxapp_id])->find())
        {
            $info['values'] = json_decode($info['values'],true);
            if(empty($info['values']))
            {
                return false;
            }
            if(empty($info['values']['order']))
            {
                return false;
            }
            return $info['values']['order']['refund_days'];
        }
        return false;
    }
}
//获取当前商户,历史收入金额
function citrixGetSupplierCanMoneyCount($supplier_id)
{   
    $after_day = citrixGetTrade();
    if($after_day >= 1)
    {
        $days = citrixGetTrade();
        $days = $days*86400;
        $time = time()-$days;
        return sprintf("%.2f",Db::name("merchant_balance_log")->where("create_time","<=",$time)->where(['supplier_id'=>$supplier_id,"scene"=>10])->sum("money"));
    }
    return sprintf("%.2f",Db::name("merchant_balance_log")->where(['supplier_id'=>$supplier_id,"scene"=>10])->sum("money"));
}
//获取当前商户,历史支出金额
function citrixGetSupplierNoMoneyCount($supplier_id)
{
    return sprintf("%.2f",Db::name("merchant_balance_log")->where(['supplier_id'=>$supplier_id,"scene"=>20])->sum("money"));
}
//获取当前商户,可以使用的金额
function citrixGetSupplierMoneyCount($supplier_id)
{
    return sprintf("%.2f",citrixGetSupplierCanMoneyCount($supplier_id)-citrixGetSupplierNoMoneyCount($supplier_id));
}
//获取当前商户,冻结中的金额
function citrixGetSupplierFrozenMoneyCount($supplier_id)
{
    $after_day = citrixGetTrade();
    if($after_day >= 1)
    {
        $days = citrixGetTrade();
        $days = $days*86400;
        $time = time()-$days;
        return sprintf("%.2f",Db::name("merchant_balance_log")->where("create_time",">=",$time)->where(['supplier_id'=>$supplier_id,"scene"=>10])->sum("money"));
    }
    return sprintf("%.2f",0);
}
// 计算出上个月第一天
function citrixGetLastMonthFirstDay()
{
    return date('Y-m-d 00:00:00', strtotime(date('Y-m-01') . ' -1 month'));
}
// 计算出上个月最后一天
function citrixGetLastMonthTheLastDay()
{
    return date('Y-m-d 23:59:59', strtotime(date('Y-m-01') . ' -1 day'));
}
// 计算出本月第一天
function citrixGetThisMonthFirstDay()
{
    return date("Y-m-01 00:00:00");
}
// 计算出本月最后一天
function citrixGetThisMonthTheLastDay()
{
    return date("Y-m-d 23:59:59",strtotime(date('Y-m-01', strtotime(date("Y-m-d")))." +1 month -1 day"));
}
//计算上周一的时间戳
function citrixGetLastMonday()
{
    return date("Y-m-d 00:00:00",mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y')));
}
//计算上周日的时间戳
function citrixGetLastSunday()
{
    return date("Y-m-d 23:59:59",mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y')));
}
/**
 * 多维数组合并
 * @param $array1
 * @param $array2
 * @return array
 */
function array_merge_multiple($array1, $array2)
{
    $merge = $array1 + $array2;
    $data = [];
    foreach ($merge as $key => $val) {
        if (
            isset($array1[$key])
            && is_array($array1[$key])
            && isset($array2[$key])
            && is_array($array2[$key])
        ) {
            $data[$key] = array_merge_multiple($array1[$key], $array2[$key]);
        } else {
            $data[$key] = isset($array2[$key]) ? $array2[$key] : $array1[$key];
        }
    }
    return $data;
}

/**
 * 二维数组排序
 * @param $arr
 * @param $keys
 * @param bool $desc
 * @return mixed
 */
function array_sort($arr, $keys, $desc = false)
{
    $key_value = $new_array = array();
    foreach ($arr as $k => $v) {
        $key_value[$k] = $v[$keys];
    }
    if ($desc) {
        arsort($key_value);
    } else {
        asort($key_value);
    }
    reset($key_value);
    foreach ($key_value as $k => $v) {
        $new_array[$k] = $arr[$k];
    }
    return $new_array;
}

/**
 * 数据导出到excel(csv文件)
 * @param $fileName
 * @param array $tileArray
 * @param array $dataArray
 */
function export_excel($fileName, $tileArray = [], $dataArray = [])
{
    ini_set('memory_limit', '512M');
    ini_set('max_execution_time', 0);
    ob_end_clean();
    ob_start();
    header("Content-Type: text/csv");
    header("Content-Disposition:filename=" . $fileName);
    $fp = fopen('php://output', 'w');
    fwrite($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));// 转码 防止乱码(比如微信昵称)
    fputcsv($fp, $tileArray);
    $index = 0;
    foreach ($dataArray as $item) {
        if ($index == 1000) {
            $index = 0;
            ob_flush();
            flush();
        }
        $index++;
        fputcsv($fp, $item);
    }
    ob_flush();
    flush();
    ob_end_clean();
}

/**
 * 隐藏敏感字符
 * @param $value
 * @return string
 */
function substr_cut($value)
{
    $strlen = mb_strlen($value, 'utf-8');
    if ($strlen <= 1) return $value;
    $firstStr = mb_substr($value, 0, 1, 'utf-8');
    $lastStr = mb_substr($value, -1, 1, 'utf-8');
    return $strlen == 2 ? $firstStr . str_repeat('*', $strlen - 1) : $firstStr . str_repeat("*", $strlen - 2) . $lastStr;
}

/**
 * 获取当前系统版本号
 * @return mixed|null
 * @throws Exception
 */
function get_version()
{
    static $version = null;
    if ($version) {
        return $version;
    }
    $file = dirname(ROOT_PATH) . '/version.json';
    if (!file_exists($file)) {
        throw new Exception('version.json not found');
    }
    $version = json_decode(file_get_contents($file), true);
    if (!is_array($version)) {
        throw new Exception('version cannot be decoded');
    }
    return $version['version'];
}

/**
 * 获取全局唯一标识符
 * @param bool $trim
 * @return string
 */
function getGuidV4($trim = true)
{
    // Windows
    if (function_exists('com_create_guid') === true) {
        $charid = com_create_guid();
        return $trim == true ? trim($charid, '{}') : $charid;
    }
    // OSX/Linux
    if (function_exists('openssl_random_pseudo_bytes') === true) {
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
    // Fallback (PHP 4.2+)
    mt_srand((double)microtime() * 10000);
    $charid = strtolower(md5(uniqid(rand(), true)));
    $hyphen = chr(45);                  // "-"
    $lbrace = $trim ? "" : chr(123);    // "{"
    $rbrace = $trim ? "" : chr(125);    // "}"
    $guidv4 = $lbrace .
        substr($charid, 0, 8) . $hyphen .
        substr($charid, 8, 4) . $hyphen .
        substr($charid, 12, 4) . $hyphen .
        substr($charid, 16, 4) . $hyphen .
        substr($charid, 20, 12) .
        $rbrace;
    return $guidv4;
}

/**
 * 时间戳转换日期
 * @param $timeStamp
 * @return false|string
 */
function format_time($timeStamp)
{
    return date('Y-m-d H:i:s', $timeStamp);
}

/**
 * 左侧填充0
 * @param $value
 * @param int $padLength
 * @return string
 */
function pad_left($value, $padLength = 2)
{
    return \str_pad($value, $padLength, "0", STR_PAD_LEFT);
}

/**
 * 过滤emoji表情
 * @param $text
 * @return null|string|string[]
 */
function filter_emoji($text)
{
    // 此处的preg_replace用于过滤emoji表情
    // 如需支持emoji表情, 需将mysql的编码改为utf8mb4
    return preg_replace('/[\xf0-\xf7].{3}/', '', $text);
}

/**
 * 根据指定长度截取字符串
 * @param $str
 * @param int $length
 * @return bool|string
 */
function str_substr($str, $length = 30)
{
    if (strlen($str) > $length) {
        $str = mb_substr($str, 0, $length, 'utf-8');
    }
    return $str;
}
