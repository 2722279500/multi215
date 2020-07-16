<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">提现管理</div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom-xs am-cf">
                        
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
                                    <td <?php if ($item['scene'] == 30): ?>class="citrixHandle" data-id="<?= $item['id'] ?>"<?php endif; ?>>
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
<div class="am-modal am-modal-confirm" tabindex="-1" id="my-verify">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">
            <b style="color: #f00;">当前操作,为不可逆！请知晓</b>
            <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
        </div>
        <div class="am-modal-bd">
            <form class="am-form" id="form_array" enctype="multipart/form-data">
                <fieldset>
                    <div class="am-form-group" style="height: 60px;margin: 1.5rem 0 0 0;">
                        <input type="file" name="jt" class="am-fl citrixJt" >
                        <p class="am-form-help am-fl">请选择要上传的截图文件...</p>
                    </div>
                    <div class="am-form-group">
                        <textarea class="am-form-field citrixBz" name="bz" rows="8" placeholder="请输入备注:如已打款,打款时间等"></textarea>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="am-modal-footer">
            <input type="hidden" name="id" value="">
            <span class="am-modal-btn" data-am-modal-cancel>拒绝</span>
            <span class="am-modal-btn" data-am-modal-confirm>同意</span>
        </div>
    </div>
</div>
<div class="am-modal am-modal-alert" tabindex="-1" id="my-result">
    <div class="am-modal-dialog">
        <div class="am-modal-bd citrixMsg"></div>
        <div class="am-modal-footer">
          <span class="am-modal-btn" data-am-modal-confirm>确定</span>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on("click",".citrixHandle",function()
    {
        $('input[name="id"]').val($(this).attr("data-id"));
        $('#my-verify').modal({
            relatedTarget: this,
            onConfirm: function(data) 
            {
                citrixPopup(20,$('input[name="id"]').val());
            },
            onCancel: function(data) 
            {
                window.location.reload();
            }
        });
    });
    function citrixPopup(scene,id)
    {
        var formdata = new FormData($(".citrixJt"));
　　　　 formdata.append('jt',$(".citrixJt").get(0).files[0]); 
　　　　 formdata.append('scene',scene); 
　　　　 formdata.append('bz',$(".citrixBz").val()); 
　　　　 formdata.append('id',id); 
        $.ajax({
            url:"<?= url('apps.merchant.withdraw/add') ?>",
            data:formdata,
            type:'post',
            async: false,  
            cache: false,  
            contentType: false,  
            processData: false,
            dataType : 'json',
            success:function(res) 
            {
                $(".citrixMsg").html(res.msg);
                $('#my-result').modal({
                    relatedElement: this,
                    onConfirm: function() 
                    {
                        window.location.reload();
                    }
                });
            }
        });
    }
</script>