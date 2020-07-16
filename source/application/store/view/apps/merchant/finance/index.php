<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">订单明细</div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom-xs am-cf">
                        <form class="toolbar-form" action="">
                            
                            
                        </form>
                    </div>
                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table class="am-table">
                            <thead>
                                <tr>
                                    <th width="170">时间</th>
                                    <th >商家</th>
                                    <th width="150">金额</th>
                                    <th >描述/说明</th>
                                    <th width="150">类型</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $colspan = 4; if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td><?= date("Y-m-d H:i:s",$item['create_time']) ?></td>
                                    <td><?= $item['supplier_name'] ?></td>
                                    <td>￥<?= $item['money'] ?></td>
                                    <td>
                                        <?php if ($item['scene'] == 10): ?>
                                            <?php 
                                                $describe = explode("   ",$item['describe']);

                                                foreach ($describe as $key => $value) 
                                                {
                                                    echo "<p>".$describe[$key]."</p>";
                                                }
                                            ?>
                                        <?php endif; ?>
                                        <?php if ($item['scene'] == 20): ?>
                                            <?php $item['describe'] = json_decode($item['describe'],true); ?>
                                            <?php if (!empty($item['describe']['apply']['zh'])): ?>
                                            <p>收款账号：<?= $item['describe']['apply']['zh'] ?></p>
                                            <?php endif; ?>
                                            <?php if (!empty($item['describe']['apply']['bz'])): ?>
                                            <p>提现备注：<?= $item['describe']['apply']['bz'] ?></p>
                                            <?php endif; ?>
                                            <?php if (!empty($item['describe']['verify']['jt'])): ?>
                                            <p>打款截图：<a href="<?= $item['describe']['verify']['jt'] ?>" target="_blank"><img src="<?= $item['describe']['verify']['jt'] ?>" height="30" width="30"></a> </p>
                                            <?php endif; ?>
                                            <?php if (!empty($item['describe']['verify']['bz'])): ?>
                                            <p>打款备注：<?= $item['describe']['verify']['bz'] ?></p>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if ($item['scene'] == 50): ?>
                                            <?php $item['describe'] = json_decode($item['describe'],true); ?>
                                            <?php if (!empty($item['describe']['verify']['bz'])): ?>
                                            <p><?= $item['describe']['verify']['bz'] ?></p>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($item['scene'] == 10): ?>
                                        <b class="am-btn am-btn-xs am-btn-success">
                                            收入
                                        </b>
                                        <?php endif; ?>
                                        <?php if ($item['scene'] == 20): ?>
                                        <b class="am-btn am-btn-xs am-btn-danger">
                                            支出
                                        </b>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
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