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
                <div class="page_toolbar am-margin-bottom-xs am-cf">
                    <form class="toolbar-form" action="">
                        <input type="hidden" name="s" value="/supplier/goods/index">
                        <div class="am-u-sm-12 am-u-md-3">
                            <div class="am-form-group">
                                <div class="am-btn-group am-btn-group-xs">
                                    <a class="am-btn am-btn-default am-btn-success" href="<?= url('bankcard/add') ?>">
                                        <span class="am-icon-plus">
                                        </span>
                                        新增
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="widget-body am-fr">
                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table class="am-table">
                            <thead>
                                <tr>
                                    <th width="50">编号</th>
                                    <th width="170">收款人</th>
                                    <th width="170">银行账号</th>
                                    <th width="150">所属银行</th>
                                    <th width="150">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $colspan = 3; if (!empty($list)): foreach ($list as $item): ?>
                                <tr>
                                    <td><?= $item['id'] ?></td>
                                    <td><?= $item['username'] ?></td>
                                    <td><?= $item['name'] ?></td>
                                    <td><?= $item['type'] ?></td>
                                    <td>
                                        <div class="tpl-table-black-operation">
                                        <a href="javascript:;" class="item-delete tpl-table-black-operation-del citrixDel" data-id="<?= $item['id'] ?>">
                                            <i class="am-icon-trash"></i> 删除
                                        </a>
                                        </div>
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
                </div>
            </div>
        </div>
    </div>
</div>
<div class="am-modal am-modal-confirm" id="del-msg">
    <div class="am-modal-dialog">
        <div class="am-modal-hd" id="del-out">警告！</div>
        <div class="am-modal-bd" id="del-txt">您确定要执行当前删除命令</div>
        <div class="am-modal-footer">
            <span class="am-modal-btn" data-am-modal-cancel>取消</span>
            <span class="am-modal-btn" data-am-modal-confirm>确定</span>
        </div>
    </div>
</div>
<div class="am-modal am-modal-confirm" id="my-alert">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">提示！</div>
        <div class="am-modal-bd" id="alert-txt"></div>
        <div class="am-modal-footer">
            <span class="am-modal-btn" data-am-modal-cancel>取消</span>
            <span class="am-modal-btn" data-am-modal-confirm>确定</span>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on("click",".citrixDel",function()
    {
        var cid = $(this).attr('data-id');
        $('#del-msg').modal({
            relatedElement: this,
            closable:false
            ,onConfirm: function() 
            {
                $.ajax({
                    url:"<?= url('bankcard/del') ?>",
                    data:{id:cid},
                    type:'post',
                    async: false,
                    dataType : 'json',
                    success:function(res) 
                    {
                        $("#alert-txt").html(res.msg);
                        $('#my-alert').modal({
                            relatedElement: this,
                            onConfirm: function() 
                            {
                                window.location.reload();
                            },
                            onCancel: function() {
                                window.location.reload();
                            }
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) 
                    {
                        window.location.reload();
                    }
                });
            },
            onCancel: function() {
                window.location.reload();
            }
        });
    });
</script>