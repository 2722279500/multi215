<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">
                        &emsp;&emsp;&emsp;
                        <a href="<?= url('withdraw/index') ?>" class="am-btn am-btn-default" style="margin-top: -6px;">提现管理</a>
                        &emsp;&emsp;&emsp;
                        <a href="<?= url('bankcard/index') ?>" class="am-btn am-btn-danger" style="margin-top: -6px;">银行卡管理</a>
                    </div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom-xs am-cf">
                        <table class="am-table am-table-bordered" style="margin: 15px;">
                            <thead>
                                <tr>
                                    <th>可提现</th>
                                    <th>冻结中</th>
                                    <th>总收入</th>
                                    <th>已提现</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= citrixGetSupplierMoneyCount($supplier_user['supplier_user_id']) ?></td>
                                    <td><?= citrixGetSupplierFrozenMoneyCount($supplier_user['supplier_user_id']) ?></td>
                                    <td><?= citrixGetSupplierCanMoneyCount($supplier_user['supplier_user_id']) ?></td>
                                    <td><?= citrixGetSupplierNoMoneyCount($supplier_user['supplier_user_id']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <form class="toolbar-form am-form" id="form_array">
                            <div class="am-u-sm-12 am-u-md-9">
                                <div class="am fr">
                                    <div class="am-form-group am-fl">
                                        <div class="am-input-group am-input-group-sm tpl-form-border-form" style="width: 255px;">
                                            <div class="am-form-group">
                                                <select name="zh">
                                                    <option value="">&nbsp;请选择提现账号&nbsp;</option>
                                                    <?php foreach ($bankcard as $val): ?>
                                                    <option value="[<?= $val['username'] ?>][<?= $val['type'] ?>]<?= $val['name'] ?>">&nbsp;[<?= $val['username'] ?>]&nbsp;[<?= $val['type'] ?>]&nbsp;<?= $val['name'] ?>&nbsp;</option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="am fr">
                                    <div class="am-form-group am-fl">
                                        <div class="am-input-group am-input-group-sm tpl-form-border-form" style="width: 220px;">
                                            <input type="text" class="am-form-field" name="je"
                                                   placeholder="请输入提现金额" >
                                        </div>
                                    </div>
                                </div>
                                <div class="am fr">
                                    <div class="am-form-group">
                                        <textarea name="bz" class="am-form-field" rows="8" placeholder="请输入备注:如信用卡或储值卡" style="border: 1px solid #c2cad8;width: 482px;"></textarea>
                                    </div>
                                    <div class="am-form-group">
                                        <b class="am-btn am-btn-danger citrixAdd">提交</b>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table class="am-table">
                            <thead>
                                <tr>
                                    <th width="170">时间</th>
                                    <th width="150">金额</th>
                                    <th >描述/说明</th>
                                    <th width="150">类型</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $colspan = 4; if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td><?= date("Y-m-d H:i:s",$item['create_time']) ?></td>
                                    <td>￥<?= $item['money'] ?></td>
                                    <td>
                                        <?php $item['describe'] = json_decode($item['describe'],true); ?>
                                        <?php if ($item['scene'] == 30): ?>
                                            <p>账号：<?= $item['describe']['apply']['zh'] ?></p>
                                            <p>备注：<?= $item['describe']['apply']['bz'] ?></p>
                                        <?php endif; ?>
                                        <?php if ($item['scene'] == 40): ?>
                                            <p>账号：<?= $item['describe']['apply']['zh'] ?></p>
                                            <p>备注：<?= $item['describe']['apply']['bz'] ?></p>
                                            <?php if (!empty($item['describe']['verify']['jt'])): ?>
                                            <p>审核截图：<a href="<?= $item['describe']['verify']['jt'] ?>" target="_blank"><img src="<?= $item['describe']['verify']['jt'] ?>" height="30" width="30"></a> </p>
                                            <?php endif; ?>
                                            <p>审核备注：<?= $item['describe']['verify']['bz'] ?></p>
                                        <?php endif; ?>
                                        <?php if ($item['scene'] == 20): ?>
                                            <p>账号：<?= $item['describe']['apply']['zh'] ?></p>
                                            <p>备注：<?= $item['describe']['apply']['bz'] ?></p>
                                            <?php if (!empty($item['describe']['verify']['jt'])): ?>
                                            <p>审核截图：<a href="<?= $item['describe']['verify']['jt'] ?>" target="_blank"><img src="<?= $item['describe']['verify']['jt'] ?>" height="30" width="30"></a> </p>
                                            <?php endif; ?>
                                            <p>审核备注：<?= $item['describe']['verify']['bz'] ?></p>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($item['scene'] == 30): ?>
                                        <b class="am-btn am-btn-xs am-btn-warning">
                                            待审核
                                        </b>
                                        <?php endif; ?>
                                        <?php if ($item['scene'] == 40): ?>
                                        <b class="am-btn am-btn-xs am-btn-default">
                                            已拒绝
                                        </b>
                                        <?php endif; ?>
                                        <?php if ($item['scene'] == 20): ?>
                                        <b class="am-btn am-btn-xs am-btn-danger">
                                            已审核
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
<div class="am-modal am-modal-confirm" tabindex="-1" id="my-confirm">
    <div class="am-modal-dialog">
        <div class="am-modal-bd"></div>
        <div class="am-modal-footer">
            <span class="am-modal-btn" data-am-modal-confirm>确定</span>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on("click",".citrixAdd",function()
    {
        $.ajax({
            url:"<?= url('withdraw/add') ?>",
            data:$('#form_array').serialize(),
            type:'post',
            async: false,
            dataType : 'json',
            success:function(res) 
            {
                $(".am-modal-bd").html(res.msg);
                $('#my-confirm').modal({
                    relatedElement: this,
                    onConfirm: function() 
                    {
                        window.location.reload();
                    }
                });
            }
        });
    });
</script>