<form class="am-form" style="background: #fff;padding: 15px;" id="form_array">
    <div class="widget-head am-cf">
        <div class="widget-title am-cf">
            &emsp;&emsp;&emsp;
            <a href="<?= url('withdraw/index') ?>" class="am-btn am-btn-default" style="margin-top: -6px;">提现管理</a>
            &emsp;&emsp;&emsp;
            <a href="<?= url('bankcard/index') ?>" class="am-btn am-btn-danger" style="margin-top: -6px;">银行卡管理</a>
        </div>
    </div>
    <fieldset>
    <legend>
        银行卡管理
    </legend>
    <div class="am-form-group">
        <label for="doc-ipt-email-1">
            收款人
        </label>
        <input type="text" name="username" placeholder="输入收款人(中文)">
    </div>
    <div class="am-form-group">
        <label for="doc-ipt-email-1">
            银行卡号
        </label>
        <input type="text" name="name" placeholder="输入10-19位银行卡号">
    </div>

    <div class="am-form-group">
        <label for="doc-select-1">所属银行</label>
        <select name="type">
            <option value="中国工商银行">中国工商银行</option>
            <option value="中国农业银行">中国农业银行</option>
            <option value="中国银行">中国银行</option>
            <option value="中国建设银行">中国建设银行</option>
            <option value="中国交通银行">中国交通银行</option>
            <option value="中国招商银行">中国招商银行</option>
            <option value="中国中信银行">中国中信银行</option>
            <option value="中国民生银行">中国民生银行</option>
            <option value="中国兴业银行">中国兴业银行</option>
            <option value="中国华夏银行">中国华夏银行</option>
            <option value="中国光大银行">中国光大银行</option>
            <option value="中国上海浦东发展银行">中国上海浦东发展银行</option>
            <option value="中国深圳发展银行">中国深圳发展银行</option>
            <option value="中国北京银行">中国北京银行</option>
            <option value="中国广东发展银行">中国广东发展银行</option>
            <option value="中国宁波银行">中国宁波银行</option>
            <option value="中国江苏银行">中国江苏银行</option>
            <option value="中国天津银行">中国天津银行</option>
            <option value="中国上海银行">中国上海银行</option>
            <option value="中国南京银行">中国南京银行</option>
            <option value="中国徽商银行">中国徽商银行</option>
            <option value="中国深圳平安银行">中国深圳平安银行</option>
            <option value="中国上海农村商业银行">中国上海农村商业银行</option>
            <option value="中国北京农村商业银行">中国北京农村商业银行</option>
            <option value="中国浙商银行">中国浙商银行</option>
            <option value="中国汇丰银行">中国汇丰银行</option>
            <option value="中国东亚银行">中国东亚银行</option>
            <option value="中国杭州银行">中国杭州银行</option>
            <option value="中国渣打银行">中国渣打银行</option>
            <option value="中国大连银行">中国大连银行</option>
            <option value="微信">微信</option>
            <option value="支付宝">支付宝</option>
        </select>
        <span class="am-form-caret"></span>
    </div>
    <p>
        <p class="am-btn am-btn-danger citrixSubmit">提交</p>
    </p>
    </fieldset>
</form>
<div class="am-modal am-modal-alert" id="error-msg">
    <div class="am-modal-dialog">
        <div class="am-modal-hd" id="error-msg-out"></div>
        <div class="am-modal-bd" id="error-msg-txt"></div>
        <div class="am-modal-footer">
            <span class="am-modal-btn">确定</span>
        </div>
    </div>
</div>
<div class="am-modal am-modal-confirm" id="success-msg">
  <div class="am-modal-dialog">
    <div class="am-modal-hd" id="success-msg-out"></div>
    <div class="am-modal-bd" id="success-msg-txt"></div>
    <div class="am-modal-footer">
      <span class="am-modal-btn" data-am-modal-cancel>取消</span>
      <span class="am-modal-btn" data-am-modal-confirm>确定</span>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(document).on("click",".citrixSubmit",function()
    {
        $.ajax({
            url:"<?= url('bankcard/add') ?>",
            data:$('#form_array').serialize(),
            type:'post',
            async: false,
            dataType : 'json',
            success:function(res) 
            {
                if(res.code == 0)
                {
                    $("#error-msg-txt").html(res.msg);
                    $("#error-msg-out").html("警告!");
                    $('#error-msg').modal({
                        relatedElement: this,
                    });
                }else
                {
                    $("#success-msg-txt").html(res.msg);
                    $("#success-msg-out").html("提示!");
                    $('#success-msg').modal({
                        relatedElement: this
                        ,onConfirm: function() 
                        {
                            location.href = '<?= url('bankcard/index') ?>';
                        }
                        ,onCancel: function() 
                        {
                            location.href = '<?= url('bankcard/index') ?>';
                        }
                    });
                }
            }
        });
    });
</script>