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
                            <?php endif; ?>
                            <?php if ($day_money['day_money'] <= $day_money['past_money']): ?>
                                本日比昨日少收入
                            <?php endif; ?>
                            <strong>
                                <?php if ($day_money['day_money'] > $day_money['past_money']): ?>
                                    <?= $day_money['day_money'] - $day_money['past_money'] ?>元
                                <?php endif; ?>
                                <?php if ($day_money['day_money'] <= $day_money['past_money']): ?>
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
                            <?php endif; ?>
                            <?php if ($week_money['week_money'] <= $week_money['past_money']): ?>
                                本周比上周少收入
                            <?php endif; ?>
                            <strong>
                                <?php if ($week_money['week_money'] > $week_money['past_money']): ?>
                                    <?= $week_money['week_money'] - $week_money['past_money'] ?>元
                                <?php endif; ?>
                                <?php if ($week_money['week_money'] <= $week_money['past_money']): ?>
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
                            <?php endif; ?>
                            <?php if ($month_money['month_money'] <= $month_money['past_money']): ?>
                                <?= date("m",time()) ?>月比<?= date('m', strtotime(date('Y-m-01') . ' -1 day')) ?>月少收入
                            <?php endif; ?>
                            <strong>
                                <?php if ($month_money['month_money'] > $month_money['past_money']): ?>
                                    <?= $month_money['month_money'] - $month_money['past_money'] ?>元
                                <?php endif; ?>
                                <?php if ($month_money['month_money'] <= $month_money['past_money']): ?>
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
                                                <?php endif; ?>
                                                <?php if($key+1 == 2): ?>
                                                <span style="background: #FF7F00;" class="citrix-iridescence">
                                                    <?= $key+1 ?></span>
                                                <?php endif; ?>
                                                <?php if($key+1 == 3): ?>
                                                <span style="background: #c7c73b;" class="citrix-iridescence">
                                                    <?= $key+1 ?></span>
                                                <?php endif; ?>
                                                <?php if($key+1 == 4): ?>
                                                <span style="background: #00FF00;" class="citrix-iridescence">
                                                    <?= $key+1 ?></span>
                                                <?php endif; ?>
                                                <?php if($key+1 == 5): ?>
                                                <span style="background: #00FFFF;" class="citrix-iridescence">
                                                    <?= $key+1 ?></span>
                                                <?php endif; ?>
                                                <?php if($key+1 == 6): ?>
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
                                            <?php endif; ?>
                                            <?php if ($log['scene'] == 20): ?>
                                            <b class="am-btn-danger" style="font-weight: 100;">
                                                <?php if (empty($log['order_id'])): ?>
                                                    &emsp;提现 <?php if (!empty($log['order_id'])): ?><a href="<?= url('order/detail', ['order_id' => $log['order_id']]) ?>" style="color:#000;" target="_blank">订单详情&emsp;</a><?php endif; ?>
                                                <?php endif; ?>&emsp;
                                            </b>
                                            <?php endif; ?>
                                            <?php if ($log['scene'] == 50): ?>
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