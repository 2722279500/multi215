<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:94:"E:\phpstudy_pro\WWW\shop215555\shop215\web/../source/application/supplier\view\order\index.php";i:1594288668;s:90:"E:\phpstudy_pro\WWW\shop215555\shop215\source\application\supplier\view\layouts\layout.php";i:1594611156;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
    <title>商家管理系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="icon" type="image/png" href="assets/common/i/favicon.ico"/>
    <meta name="apple-mobile-web-app-title" content="商家管理系统"/>
    <link rel="stylesheet" href="assets/common/css/amazeui.min.css"/>
    <link rel="stylesheet" href="assets/supplier/css/app.css"/>
    <link rel="stylesheet" href="//at.alicdn.com/t/font_783249_c9du3u6ahxp.css">
    <script src="assets/common/js/jquery.min.js"></script>
    <style type="text/css">
        .tpl-content-wrapper
        {
            width: 100%;
            max-width:100%;
        }
    </style>
    <script>
        BASE_URL = '<?= isset($base_url) ? $base_url : '' ?>';
        STORE_URL = '<?= isset($supplier_url) ? $supplier_url : '' ?>';
    </script>
</head>

<body data-type="">
<div class="am-g tpl-g">
    <!-- 头部 -->
    <header class="tpl-header">
        <!-- 右侧内容 -->
        <div class="tpl-header-fluid">
            <!-- logo -->
            <div style="float: left;height: 50px;line-height: 50px;">
                <a href="<?= url('index/index') ?>">多商家管理后台</a>
            </div>
            <!-- 其它功能-->
            <div class="am-fr tpl-header-navbar">
                <ul>
                    <!-- 欢迎语 -->
                    <li class="am-text-sm tpl-header-navbar-welcome">
                        <a href="<?= url('supplier.user/renew') ?>">欢迎你，
                            <span style="color: #4aaa4a;">
                            [<?= $supplier['user']['name'] ?>]
                            </span>
                            <span>
                            <?= $supplier['user']['username'] ?>
                            </span>
                        </a>
                    </li>
                    <!-- 退出 -->
                    <li class="am-text-sm">
                        <a href="<?= url('passport/logout') ?>">
                            <i class="iconfont icon-tuichu"></i> 退出
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- 内容区域 start -->
    <div class="tpl-content-wrapper dis-flex">
        <!-- 左侧菜单 -->
        <?php $menus = $menus ?: []; $group = $group ?: 0; ?>
        <div class="left-sidebar">
            <ul class="sidebar-nav">
                <?php foreach ($menus as $key => $item): ?>
                    <li class="sidebar-nav-link">
                        <a href="<?= isset($item['index']) ? url($item['index']) : 'javascript:void(0);' ?>"
                           class="sidebar-nav-link-disabled">
                            <?php if (isset($item['is_svg']) && $item['is_svg'] == true): ?>
                                <svg class="icon sidebar-nav-link-logo" aria-hidden="true">
                                    <use xlink:href="#<?= $item['icon'] ?>"></use>
                                </svg>
                            <?php else: ?>
                                <i class="iconfont sidebar-nav-link-logo <?= $item['icon'] ?>"
                                   style="<?= isset($item['color']) ? "color:{$item['color']};" : '' ?>"></i>
                            <?php endif; ?>
                            <?= $item['name'] ?>
                        </a>
                        <!-- 子级菜单-->
                        <?php if (isset($item['submenu']) && !empty($item['submenu'])) : ?>
                            <ul class="sidebar-third-nav-sub">
                                <?php foreach ($item['submenu'] as $second) : ?>
                                    <li class="sidebar-nav-link <?= $second['active'] ? 'active' : '' ?>">
                                        <a class="" href="<?= url($second['index']) ?>">
                                            <?= $second['name'] ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- 内容区域 -->
        <div class="row-content am-cf">
            <?php

use app\common\enum\DeliveryType as DeliveryTypeEnum;

$_supplier_user = \think\session::get("yoshop_supplier.user");
?>

<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf"><?= $title ?></div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom-xs am-cf">
                        <form id="form-search" class="toolbar-form" action="">
                            <input type="hidden" name="s" value="/<?= $request->pathinfo() ?>">
                            <input type="hidden" name="dataType" value="<?= $dataType ?>">
                            <div class="am-u-sm-12 am-u-md-3">
                                <div class="am-form-group">
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <?php if (checkPrivilege('supplier/order.operate/export')): ?>
                                                <a class="j-export am-btn am-btn-success am-radius"
                                                   href="javascript:void(0);">
                                                    <i class="iconfont icon-daochu am-margin-right-xs"></i>订单导出
                                                </a>
                                            <?php endif; ?>
                                            <!-- <?php if (checkPrivilege('supplier/order.operate/batchdelivery')): if (in_array($dataType, ['all', 'delivery'])): ?>
                                                    <a class="j-export am-btn am-btn-secondary am-radius"
                                                       href="<?= url('supplier/order.operate/batchdelivery') ?>">
                                                        <i class="iconfont icon-daoru am-margin-right-xs"></i>批量发货
                                                    </a>
                                                <?php endif; endif; ?> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-u-sm-12 am-u-md-9">
                                <div class="am fr">
                                    <div class="am-form-group am-fl">
                                        <?php $deliveryType = $request->get('delivery_type'); ?>
                                        <select name="delivery_type"
                                                data-am-selected="{btnSize: 'sm', placeholder: '配送方式'}">
                                            <option value=""></option>
                                            <option value="-1"
                                                <?= $deliveryType === '-1' ? 'selected' : '' ?>>全部
                                            </option>
                                            <?php foreach (DeliveryTypeEnum::data() as $item): ?>
                                                <option value="<?= $item['value'] ?>"
                                                    <?= $item['value'] == $deliveryType ? 'selected' : '' ?>><?= $item['name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="am-form-group tpl-form-border-form am-fl">
                                        <input type="text" name="start_time"
                                               class="am-form-field"
                                               value="<?= $request->get('start_time') ?>" placeholder="请选择起始日期"
                                               data-am-datepicker>
                                    </div>
                                    <div class="am-form-group tpl-form-border-form am-fl">
                                        <input type="text" name="end_time"
                                               class="am-form-field"
                                               value="<?= $request->get('end_time') ?>" placeholder="请选择截止日期"
                                               data-am-datepicker>
                                    </div>
                                    <div class="am-form-group am-fl">
                                        <div class="am-input-group am-input-group-sm tpl-form-border-form">
                                            <input type="text" class="am-form-field" name="search"
                                                   placeholder="请输入订单号/用户昵称" value="<?= $request->get('search') ?>">
                                            <div class="am-input-group-btn">
                                                <button class="am-btn am-btn-default am-icon-search"
                                                        type="submit"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="order-list am-scrollable-horizontal am-u-sm-12 am-margin-top-xs">
                        <table width="100%" class="am-table am-table-centered
                        am-text-nowrap am-margin-bottom-xs">
                            <thead>
                            <tr>
                                <th width="25%" class="goods-detail">商品信息</th>
                                <th width="10%">单价/数量</th>
                                <th width="15%">实付款</th>
                                <th>毛利润</th>
                                <th>利润</th>
                                <th>买家</th>
                                <th>支付方式</th>
                                <th>配送方式</th>
                                <th>交易状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $colspan = 10; if (!$list->isEmpty()): foreach ($list as $order): ?>
                                <tr class="order-empty">
                                    <td colspan="<?= $colspan ?>"></td>
                                </tr>
                                <tr>
                                    <td class="am-text-middle am-text-left" colspan="<?= $colspan ?>">
                                        <span class="am-margin-right-lg"> <?= $order['create_time'] ?></span>
                                        <span class="am-margin-right-lg">订单号：<?= $order['order_no'] ?></span>
                                    </td>
                                </tr>
                                <?php $i = 0;
                                foreach ($order['goods'] as $goods): $i++; ?>
                                    <tr>
                                        <td class="goods-detail am-text-middle">
                                            <?php if($goods['supplier_id'] == $_supplier_user['supplier_user_id']): ?>
                                            <div class="goods-image">
                                                <img src="<?= $goods['image']['file_path'] ?>" alt="">
                                            </div>
                                            <div class="goods-info" >
                                                <p class="goods-title"><?= $goods['goods_name'] ?></p>
                                                <p class="goods-spec am-link-muted"><?= $goods['goods_attr'] ?></p>
                                                <p style="overflow:hidden;text-overflow:ellipsis;white-space: nowrap;">所属商家：<?= citrixGetSupplierName($goods['supplier_id']) ?></p>
                                            </div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="am-text-middle">
                                            <?php if($goods['supplier_id'] == $_supplier_user['supplier_user_id']): ?>
                                            <p>￥<?= $goods['goods_price'] ?></p>
                                            <p>×<?= $goods['total_num'] ?></p>
                                            <?php endif; ?>
                                        </td>
                                        <?php if ($i === 1) : $goodsCount = count($order['goods']); ?>
                                            <td class="am-text-middle" rowspan="<?= $goodsCount ?>">
                                                <p>￥<?= $order['gross_profit']['money'] ?></p>
                                                <!-- <p>￥<?= $order['pay_price'] ?></p>
                                                <p class="am-link-muted">(含运费：￥<?= $order['express_price'] ?>)<span style="font-weight: 700;color: #f60;">&nbsp;(￥<?= citrixGetSupplierExpressPrice($order['order_id'],$_supplier_user['supplier_user_id']) ?>)</span></p> -->
                                            </td>
                                            <td class="am-text-middle" rowspan="<?= $goodsCount ?>">
                                                <p style="text-align: left;"><?= $order['gross_profit']['describe'][0] ?></p>
                                                <p style="text-align: left;"><?= $order['gross_profit']['describe'][1] ?></p>
                                                <p style="text-align: left;"><?= $order['gross_profit']['describe'][2] ?></p>
                                                <p style="text-align: left;"><?= $order['gross_profit']['describe'][3] ?></p>
                                                <p style="text-align: left;"><?= $order['gross_profit']['describe'][4] ?></p>
                                                <p style="text-align: left;"><?= $order['gross_profit']['describe'][5] ?></p>
                                                <p style="text-align: left;"><?= $order['gross_profit']['describe'][6] ?></p>
                                                <p style="text-align: left;"><?= $order['gross_profit']['describe'][7] ?></p>
                                            </td>
                                            <td class="am-text-middle" rowspan="<?= $goodsCount ?>">
                                                <p >￥<?= $order['gross_profit']['money'] ?></p>
                                                <?php if ($order['receipt_status']['value'] == 10): ?>
                                                    <p class="am-btn am-btn-default">&nbsp;待结算&nbsp;</p>
                                                <?php endif; if ($order['receipt_status']['value'] == 20): ?>
                                                    <p class="am-btn am-btn-success">&nbsp;已结算&nbsp;</p>
                                                <?php endif; ?>
                                            </td>
                                            <td class="am-text-middle" rowspan="<?= $goodsCount ?>">
                                                <p><?= $order['user']['nickName'] ?></p>
                                                <p class="am-link-muted">(用户id：<?= $order['user']['user_id'] ?>)</p>
                                            </td>
                                            <td class="am-text-middle" rowspan="<?= $goodsCount ?>">
                                                <span class="am-badge am-badge-secondary">
                                                    <?= $order['pay_type']['text'] ?>
                                                </span>
                                            </td>
                                            <td class="am-text-middle" rowspan="<?= $goodsCount ?>">
                                                <span class="am-badge am-badge-secondary">
                                                    <?= $order['delivery_type']['text'] ?>
                                                </span>
                                            </td>
                                            <td class="am-text-middle" rowspan="<?= $goodsCount ?>">
                                                <p>付款状态：
                                                    <span class="am-badge
                                                <?= $order['pay_status']['value'] == 20 ? 'am-badge-success' : '' ?>">
                                                        <?= $order['pay_status']['text'] ?></span>
                                                </p>
                                                <p>发货状态：
                                                    <span class="am-badge
                                                <?= $order['delivery_status']['value'] == 20 ? 'am-badge-success' : '' ?>">
                                                        <?= $order['delivery_status']['text'] ?></span>
                                                </p>
                                                <p>收货状态：
                                                    <span class="am-badge
                                                <?= $order['receipt_status']['value'] == 20 ? 'am-badge-success' : '' ?>">
                                                        <?= $order['receipt_status']['text'] ?></span>
                                                </p>
                                                <?php if ($order['order_status']['value'] == 20 || $order['order_status']['value'] == 21): ?>
                                                    <p>订单状态：
                                                        <span class="am-badge am-badge-warning"><?= $order['order_status']['text'] ?></span>
                                                    </p>
                                                <?php endif; ?>
                                            </td>
                                            <td class="am-text-middle" rowspan="<?= $goodsCount ?>">
                                                <div class="tpl-table-black-operation">
                                                    <?php if (checkPrivilege('order/detail')): ?>
                                                        <a class="tpl-table-black-operation-green"
                                                           href="<?= url('order/detail', ['order_id' => $order['order_id']]) ?>">
                                                            订单详情</a>
                                                    <?php endif; if (checkPrivilege(['order/detail', 'order/delivery'])): if ($order['pay_status']['value'] == 20
                                                            && $order['delivery_status']['value'] == 10
                                                            && $order['order_status']['value'] != 20
                                                            && $order['order_status']['value'] != 21
                                                        ): ?>
                                                            <a class="tpl-table-black-operation"
                                                               href="<?= url('order/detail#delivery',
                                                                   ['order_id' => $order['order_id']]) ?>">去发货</a>
                                                        <?php endif; endif; if (checkPrivilege(['order/detail', 'order.operate/confirmcancel'])): if ($order['order_status']['value'] == 21): ?>
                                                            <a class="tpl-table-black-operation-del"
                                                               href="<?= url('order/detail#cancel',
                                                                   ['order_id' => $order['order_id']]) ?>">去审核</a>
                                                        <?php endif; endif; ?>
                                                </div>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; endforeach; else: ?>
                                <tr>
                                    <td colspan="<?= $colspan ?>" class="am-text-center">暂无记录</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="am-u-lg-12 am-cf">
                        <div class="am-fr"><?= $list->render() ?> </div>
                        <div class="am-fr pagination-total am-margin-right">
                            <div class="am-vertical-align-middle">总记录：<?= $list->total() ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $(function () {

        /**
         * 订单导出
         */
        $('.j-export').click(function () {
            var data = {};
            var formData = $('#form-search').serializeArray();
            $.each(formData, function () {
                this.name !== 's' && (data[this.name] = this.value);
            });
            window.location = "<?= url('order.operate/export') ?>" + '&' + $.urlEncode(data);
        });

    });

</script>


        </div>

    </div>
    <!-- 内容区域 end -->

    <div class="help-block am-text-center am-padding-sm">
        <small>当前系统版本号：v<?= $version ?></small>
    </div>
</div>
<script src="assets/common/plugins/layer/layer.js"></script>
<script src="assets/common/js/jquery.form.min.js"></script>
<script src="assets/common/js/amazeui.min.js"></script>
<script src="assets/common/js/webuploader.html5only.js"></script>
<script src="assets/common/js/art-template.js"></script>
<script src="assets/store/js/app.js"></script>
<script src="assets/store/js/file.library.js?v=1.1.42"></script>

</body>

</html>
