<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:94:"E:\phpstudy_pro\WWW\shop215555\shop215\web/../source/application/supplier\view\index\index.php";i:1594624404;s:90:"E:\phpstudy_pro\WWW\shop215555\shop215\source\application\supplier\view\layouts\layout.php";i:1594611156;}*/ ?>
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
                <style type="text/css">
        .theme-black .widget {
            border: 1px solid #33393c;
            border-top: 2px solid #313639;
            background: #4b5357;
            color: #ffffff;
        }
        .theme-black .widget-primary {
            border: 1px solid #11627d;
            border-top: 2px solid #105f79;
            background: #1786aa;
            color: #ffffff;
            padding: 12px 17px;
        }
        .theme-black .widget-purple {
            padding: 12px 17px;
            border: 1px solid #5e4578;
            border-top: 2px solid #5c4375;
            background: #785799;
            color: #ffffff;
        }
        .citrix-iridescence
        {
            padding: 2.5px 7px;
            border-radius: 50%;    
            height: 5px;
            color: #fff;
        }
    </style>
    <div class="row  am-cf" style="margin: 15px 0px;">
        <div class="theme-black am-u-sm-12 am-u-md-12 am-u-lg-4">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-fl">
                        本日财务利润
                    </div>
                </div>
                <div class="widget-body am-fr">
                    <div class="widget-statistic-body">
                        <div class="widget-statistic-value">
                            ￥<?= $day_money['day_money'] ?>
                        </div>
                        <div class="widget-statistic-description">
                            <?php if ($day_money['day_money'] > $day_money['past_money']): ?>
                                本日比昨日多收入
                            <?php endif; if ($day_money['day_money'] <= $day_money['past_money']): ?>
                                本日比昨日少收入
                            <?php endif; ?>
                            <strong>
                                <?php if ($day_money['day_money'] > $day_money['past_money']): ?>
                                    <?= $day_money['day_money'] - $day_money['past_money'] ?>元
                                <?php endif; if ($day_money['day_money'] <= $day_money['past_money']): ?>
                                    <?= $day_money['past_money'] - $day_money['day_money'] ?>元
                                <?php endif; ?>
                            </strong>
                            人民币
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="theme-black am-u-sm-12 am-u-md-12 am-u-lg-4">
            <div class="widget widget-primary am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-fl">
                        本周财务利润
                    </div>
                </div>
                <div class="widget-body am-fr">
                    <div class="widget-statistic-body">
                        <div class="widget-statistic-value">
                            ￥<?= $week_money['week_money'] ?>
                        </div>
                        <div class="widget-statistic-description">
                            <?php if ($week_money['week_money'] > $week_money['past_money']): ?>
                                本周比上周多收入
                            <?php endif; if ($week_money['week_money'] <= $week_money['past_money']): ?>
                                本周比上周少收入
                            <?php endif; ?>
                            <strong>
                                <?php if ($week_money['week_money'] > $week_money['past_money']): ?>
                                    <?= $week_money['week_money'] - $week_money['past_money'] ?>元
                                <?php endif; if ($week_money['week_money'] <= $week_money['past_money']): ?>
                                    <?= $week_money['past_money'] - $week_money['week_money'] ?>元
                                <?php endif; ?>
                            </strong>
                            人民币
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="theme-black am-u-sm-12 am-u-md-12 am-u-lg-4">
            <div class="widget-purple widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-fl">
                        <?= date("m",time()) ?>月度财务利润
                    </div>
                </div>
                <div class="widget-body am-fr">
                    <div class="widget-statistic-body">
                        <div class="widget-statistic-value">
                            ￥<?= $month_money['month_money'] ?>
                        </div>
                        <div class="widget-statistic-description">
                            <?php if ($month_money['month_money'] > $month_money['past_money']): ?>
                                <?= date("m",time()) ?>月比<?= date('m', strtotime(date('Y-m-01') . ' -1 day')) ?>月多收入
                            <?php endif; if ($month_money['month_money'] <= $month_money['past_money']): ?>
                                <?= date("m",time()) ?>月比<?= date('m', strtotime(date('Y-m-01') . ' -1 day')) ?>月少收入
                            <?php endif; ?>
                            <strong>
                                <?php if ($month_money['month_money'] > $month_money['past_money']): ?>
                                    <?= $month_money['month_money'] - $month_money['past_money'] ?>元
                                <?php endif; if ($month_money['month_money'] <= $month_money['past_money']): ?>
                                    <?= $month_money['past_money'] - $month_money['month_money'] ?>元
                                <?php endif; ?>
                            </strong>
                            人民币
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="//echarts.baidu.com/build/dist/echarts.js"></script>
    <div class="widget am-cf" style="width: 99%;margin: 0.6%;">
        <div id="main" style="height:400px"></div>
        <script type="text/javascript">
        // 路径配置
        require.config({
            paths: {
                echarts: '//echarts.baidu.com/build/dist'
            }
        });
        // 使用
        require(
            [
                'echarts',
                'echarts/chart/line' // 使用柱状图就加载bar模块，按需加载
            ],
            function (ec) {
                // 基于准备好的dom，初始化echarts图表
                var myChart = ec.init(document.getElementById('main')); 
                
                option = {
                    title : {
                        text: '近七日交易走势'
                    },
                    tooltip : {
                        trigger: 'axis'
                    },
                    legend: {
                        data:['成交量','成交额']
                    },
                    toolbox: {
                        show : true,
                        feature : {
                            mark : {show: true},
                            dataView : {show: true, readOnly: false},
                            magicType : {show: true, type: ['line', 'bar', 'stack', 'tiled']},
                            restore : {show: true},
                            saveAsImage : {show: true}
                        }
                    },
                    calculable : true,
                    xAxis : [
                        {
                            type : 'category',
                            boundaryGap : false,
                            data : [<?= $week_list ?>]
                        }
                    ],
                    yAxis : [
                        {
                            type : 'value'
                        }
                    ],
                    series : [
                        {
                            name:'成交额',
                            type:'line',
                            smooth:true,
                            itemStyle: {normal: {areaStyle: {type: 'default'}}},
                            data:[<?= $seven_list['turnover'] ?>]
                        },
                        {
                            name:'成交量',
                            type:'line',
                            smooth:true,
                            itemStyle: {normal: {areaStyle: {type: 'default'}}},
                            data:[<?= $seven_list['volume'] ?>]
                        }
                    ]
                };
                // 为echarts对象加载数据 
                myChart.setOption(option); 
            }
        );
    </script>
    </div>
    <div class="row am-cf" style="width: 100%;margin-left: 0;">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-6 widget-margin-bottom-lg ">
            <div class="widget am-cf widget-body-lg">
                <div class="widget-body  am-fr">
                    <div class="am-scrollable-horizontal ">
                        <div id="example-r_wrapper" class="dataTables_wrapper am-datatable am-form-inline dt-amazeui no-footer">
                            <table width="100%" class="am-table am-table-compact am-text-nowrap tpl-table-black  dataTable no-footer"
                            id="example-r" role="grid" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc">
                                            热销商品
                                        </th>
                                        <th class="sorting" >
                                            销售数量
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- more data -->
                                    <?php if (!empty($sell_well_list)): foreach ($sell_well_list as $key => $val): ?>
                                    <tr class="even gradeC odd" role="row">
                                        <td class="sorting_1">
                                            <a href="<?= url('goods/edit',
                                                    ['goods_id' => $val['goods_id']]) ?>">
                                                <?php if($key+1 == 1): ?>
                                                <span style="background: #FF0000;" class="citrix-iridescence">
                                                    <?= $key+1 ?></span>
                                                <?php endif; if($key+1 == 2): ?>
                                                <span style="background: #FF7F00;" class="citrix-iridescence">
                                                    <?= $key+1 ?></span>
                                                <?php endif; if($key+1 == 3): ?>
                                                <span style="background: #c7c73b;" class="citrix-iridescence">
                                                    <?= $key+1 ?></span>
                                                <?php endif; if($key+1 == 4): ?>
                                                <span style="background: #00FF00;" class="citrix-iridescence">
                                                    <?= $key+1 ?></span>
                                                <?php endif; if($key+1 == 5): ?>
                                                <span style="background: #00FFFF;" class="citrix-iridescence">
                                                    <?= $key+1 ?></span>
                                                <?php endif; if($key+1 == 6): ?>
                                                <span style="background: #0000FF;" class="citrix-iridescence">
                                                    <?= $key+1 ?></span>
                                                <?php endif; ?>
                                                &nbsp;<?= $val['goods_name'] ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?= $val['sum'] ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; else: ?>
                                        <tr>
                                            <td colspan="2" class="am-text-center"  style="height: 210px;line-height: 210px;">暂无记录</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-6 widget-margin-bottom-lg">
            <div class="widget am-cf widget-body-lg">
                <div class="widget-body  am-fr">
                    <div class="am-scrollable-horizontal ">
                        <div id="example-r_wrapper" class="dataTables_wrapper am-datatable am-form-inline dt-amazeui no-footer">
                            <table width="100%" class="am-table am-table-compact am-text-nowrap tpl-table-black  dataTable no-footer"
                            id="example-r" role="grid" style="width: 100%;">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" >
                                            类型
                                        </th>
                                        <th class="sorting" >
                                            
                                        </th>
                                        <th class="sorting" >
                                            金额
                                        </th>
                                        <th class="sorting" >
                                            时间
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- more data -->
                                    <?php if (!empty($consume_list)): foreach ($consume_list as $log): ?>
                                    <tr class="even gradeC odd" role="row" >
                                        <td class="sorting" colspan="2">
                                            <?php if ($log['scene'] == 10): ?>
                                            <b class="am-btn-success" style="font-weight: 100;">
                                                &emsp;收入 <?php if (!empty($log['order_id'])): ?><a href="<?= url('order/detail', ['order_id' => $log['order_id']]) ?>" style="color:#000;" target="_blank">订单详情&emsp;</a><?php endif; ?>
                                            </b>
                                            <?php endif; if ($log['scene'] == 20): ?>
                                            <b class="am-btn-danger" style="font-weight: 100;">
                                                <?php if (empty($log['order_id'])): ?>
                                                    &emsp;提现 <?php if (!empty($log['order_id'])): ?><a href="<?= url('order/detail', ['order_id' => $log['order_id']]) ?>" style="color:#000;" target="_blank">订单详情&emsp;</a><?php endif; endif; ?>&emsp;
                                            </b>
                                            <?php endif; if ($log['scene'] == 50): ?>
                                            <b class="am-btn-warning" style="font-weight: 100;">
                                                &emsp;售后 <?php if (!empty($log['order_refund_id'])): ?><a href="<?= url('refund/detail', ['order_refund_id' => $log['order_refund_id']]) ?>" style="color:#000;" target="_blank">售后详情&emsp;</a><?php endif; ?>
                                            </b>
                                            <?php endif; ?>
                                        </td>
                                        <td class="sorting" >
                                            ￥<?= $log['money'] ?>
                                        </td>
                                        <td class="sorting" >
                                            <?= date("Y-m-d H:i:s",$log['create_time']) ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; else: ?>
                                        <tr>
                                            <td colspan="4" class="am-text-center"  style="height: 210px;line-height: 210px;">暂无记录</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
