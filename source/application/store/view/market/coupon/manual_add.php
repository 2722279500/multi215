<style type="text/css">
    .citrix-users-del
    {
        position: absolute;
        margin-left: 110px;
    }
</style>
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div id="app" class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="am-form-group">
                                <label class="am-u-sm-3  am-u-lg-2 am-form-label form-require"> 选择用户 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="widget-become-goods am-form-file am-margin-top-xs">
                                        <button type="button"
                                                class="j-selectUser upload-file am-btn am-btn-secondary am-radius">
                                            <i class="am-icon-cloud-upload"></i> 选择用户
                                        </button>
                                        <div class="user-list uploader-list am-cf">
                                            
                                        </div>
                                        <div class="am-block">
                                            <small>选择后不可更改</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 选择优惠卷 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <select name="manual[coupon_id]"
                                            data-am-selected="{searchBox: 1, btnSize: 'sm', placeholder:'请选择', maxHeight: 400}"
                                            required>
                                        <option value=""></option>
                                        <?php if (!empty($coupon_list)): ?>
                                        <?php foreach ($coupon_list as $item): ?>
                                            <option value="<?= $item['coupon_id'] ?>"><?= $item['name'] ?></option>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                        </select>
                                    <div class="help-block">
                                        <small>请选择所发放的优惠券，如选择的会员已经领取，则发放失败</small>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                    <button type="submit" class="j-submit am-btn am-btn-secondary">提交
                                    </button>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 图片文件列表模板 -->
<script id="tpl-user-item" type="text/template">
    {{ each $data }}
    <div class="file-item">
        <a href="{{ $value.avatarUrl }}" title="{{ $value.nickName }} (ID:{{ $value.user_id }})" target="_blank">
            <img src="{{ $value.avatarUrl }}">
        </a>
        <input type="hidden" name="clerk[user_id]" value="{{ $value.user_id }}">
    </div>
    {{ /each }}
</script>

<script src="assets/store/js/select.data.js?v=<?= $version ?>"></script>
<script>
    $(function () {

        // 选择用户
        $('.j-selectUser').click(function () {
            var $userList = $('.user-list');
            $.selectData({
                title: '选择用户',
                uri: 'user/lists',
                dataIndex: 'user_id',
                done: function (data) {

                    console.log(data)
                    var template = ``;
                    for (i = 0; i < data.length; i++) 
                    { 
                        if($(".citrix-users-item-"+data[i]['user_id']).length>0)
                        {
                            continue;
                        }
                        template  += `<div class="file-item citrix-users-item-`+data[i]['user_id']+`">
                        <i class="iconfont icon-shibai citrix-users-del " data-id="`+data[i]['user_id']+`">&nbsp;</i>
                        <a href="`+data[i]['avatarUrl']+`" title="`+data[i]['nickName']+` (ID:`+data[i]['user_id']+`)" target="_blank">
                            <img src="`+data[i]['avatarUrl']+`">
                        </a>
                        <input type="hidden" name="manual[user_id][`+data[i]['user_id']+`]" value="`+data[i]['user_id']+`">
                        <input type="hidden" name="manual[username][`+data[i]['user_id']+`]" value="`+data[i]['nickName']+`">
                        <input type="hidden" name="manual[image][`+data[i]['user_id']+`]" value="`+data[i]['avatarUrl']+`">
                    </div>`;
                    }
                    $(".uploader-list").append(template);
                }
            });
        });
        //删除会员
        $(document).on("click",".citrix-users-del",function()
        {
            var id = $(this).attr("data-id");
            $(".citrix-users-item-"+id).remove();
        });

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

    });
</script>

