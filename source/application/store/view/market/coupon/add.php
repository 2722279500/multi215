<style type="text/css">
    .citrix-width60{
        width: 60%!important;
        float: left!important;
        padding: 0px!important;
        margin: 0px!important;
    }
    .citrix-width25{
        width: 25%!important;
        float: left!important;
        padding: 0px!important;
        margin: 0px!important;
    }
    .citrix-input{    
        background: #ddd !important;
    }
    .citrix-span{    
        height: 32px!important;
        line-height: 0px!important;
    }
    .citrix-choice
    {
        height: 25px;
        line-height: 25px;
        background: #ddd;
        display: inline-flex;
        margin: 5px;
        padding: 0 5px;
        font-size: 12px;
        border: 1px solid #999;
    }
    .citrix-select
    {
        border: 1px solid #c2cad8;
    }
    .citrix-select-item
    {
        border-bottom: 0px solid #fff!important;
    }
    .citrix-choices-ul
    {
        width: 90%;
    }
    .citrix-radio
    {
        height: 16px;
        line-height: 16px;
        width: 16px;
    }
    .citrix-category
    {
        border: 0px solid #fff!important;
        background: #ddd!important;
    }
    .citrix-goods-dl
    {
        width: 180px;
        height: 180px;
        padding: 0px;
        margin: 5px 20px 5px 0px;
        border: 1px solid #ddd;
        float: left;
    }
    .citrix-goods-dl i
    {
        padding-left: 180px;
        position: absolute;
    }
    .citrix-goods-dl dd
    {
        position: relative;
        width: 180px;
        bottom: 30px;
        height: 30px;
        line-height: 30px;
        text-align: center;
        background: rgba(0,0,0,0.8);
        color: #fff;
        font-size: 12px;
        display: inline-block;
        white-space: nowrap; 
        overflow: hidden;
        text-overflow:ellipsis;
    }
    .citrix-goods-del
    {
        z-index: 999;
    }
</style>
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">添加优惠券</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">优惠券名称 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="coupon[name]"
                                           value="" placeholder="请输入优惠券名称" required>
                                    <small>例如：满100减10</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">优惠券颜色 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[color]" value="10" checked data-am-ucheck>
                                        蓝色
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[color]" value="20" data-am-ucheck>
                                        红色
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[color]" value="30" data-am-ucheck>
                                        紫色
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[color]" value="40" data-am-ucheck>
                                        黄色
                                    </label>
                                </div>
                            </div>



                            <!-- star ------------------------------------------------------>
                            <div class="am-form-group" data-x-switch>
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">商品分类使用限制 </label>
                                <div class="am-u-sm-9 am-u-end citrix-cates-limit">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[limitgoodcatetype]" value="0" class="citrix-radio" checked >
                                        不添加商品分类限制
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[limitgoodcatetype]" value="1" class="citrix-radio" >
                                        允许以下商品分类使用
                                    </label>
                                </div>
                            </div>
                            <div class="am-form-group citrix-cates-item" data-x-switch>
                                
                            </div>
                            <div class="am-form-group" data-x-switch>
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">商品使用限制 </label>
                                <div class="am-u-sm-9 am-u-end citrix-goods-limit">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[limitgoodtype]" value="0" class="citrix-radio" checked >
                                        不添加商品限制
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[limitgoodtype]" value="1" class="citrix-radio" >
                                        允许以下商品使用
                                    </label>
                                </div>
                            </div>
                            <div class="am-form-group citrix-goods-item" data-x-switch>
                                
                            </div>
                            <!-- end  ------------------------------------------------------>



                            <div class="am-form-group" data-x-switch>
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">优惠券类型 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[coupon_type]" value="10" checked
                                               data-am-ucheck
                                               data-switch-box="switch-coupon_type"
                                               data-switch-item="coupon_type__10">
                                        满减券
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[coupon_type]" value="20"
                                               data-am-ucheck
                                               data-switch-box="switch-coupon_type"
                                               data-switch-item="coupon_type__20">
                                        折扣券
                                    </label>
                                </div>
                            </div>
                            <div class="am-form-group switch-coupon_type coupon_type__10">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">减免金额 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" min="0.01" class="tpl-form-input" name="coupon[reduce_price]"
                                           value="" placeholder="请输入减免金额" required>
                                </div>
                            </div>
                            <div class="am-form-group switch-coupon_type coupon_type__20 hide">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">折扣率 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" min="0" max="10" class="tpl-form-input"
                                           name="coupon[discount]"
                                           value="" placeholder="请输入折扣率" required>
                                    <small>折扣率范围0-10，9.5代表9.5折，0代表不折扣</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">最低消费金额 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" min="1" class="tpl-form-input" name="coupon[min_price]"
                                           value="" placeholder="请输入最低消费金额" required>
                                </div>
                            </div>
                            <div class="am-form-group" data-x-switch>
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">到期类型 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[expire_type]" value="10" checked
                                               data-am-ucheck
                                               data-switch-box="switch-expire_type"
                                               data-switch-item="expire_type__10">
                                        领取后生效
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="coupon[expire_type]" value="20"
                                               data-am-ucheck
                                               data-switch-box="switch-expire_type"
                                               data-switch-item="expire_type__20">
                                        固定时间
                                    </label>
                                </div>
                            </div>
                            <div class="am-form-group switch-expire_type expire_type__10">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">有效天数 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" min="1" class="tpl-form-input" name="coupon[expire_day]"
                                           value="3" placeholder="请输入有效天数" required>
                                </div>
                            </div>
                            <div class="am-form-group switch-expire_type expire_type__20 hide">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">时间范围 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="j-startTime am-form-field am-margin-bottom-sm"
                                           name="coupon[start_time]" placeholder="请选择开始日期" required>
                                    <input type="text" class="j-endTime am-form-field" name="coupon[end_time]"
                                           placeholder="请选择结束日期" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">发放总数量 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" min="-1" class="tpl-form-input" name="coupon[total_num]"
                                           value="-1" required>
                                    <small>限制领取的优惠券数量，-1为不限制</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">排序 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" min="0" class="tpl-form-input" name="coupon[sort]" value="100"
                                           required>
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

<!-- 商品列表 -->
<script id="tpl-goods-list-item" type="text/template">
    {{ each $data }}
    <div class="file-item">
        <a href="{{ $value.image }}" title="{{ $value.goods_name }}" target="_blank">
            <img src="{{ $value.image }}">
        </a>
        <input type="hidden" name="active[goods_id]" value="{{ $value.goods_id }}">
    </div>
    {{ /each }}
</script>

<script src="assets/common/plugins/laydate/laydate.js"></script>
<script src="assets/store/js/select.data.js?v=<?= $version ?>"></script>
<script type="text/javascript">
    /**
     * 时间选择
     */
    $(function () {
        var nowTemp = new Date();
        var nowDay = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0).valueOf();
        var nowMoth = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), 1, 0, 0, 0, 0).valueOf();
        var nowYear = new Date(nowTemp.getFullYear(), 0, 1, 0, 0, 0, 0).valueOf();
        var $startTime = $('.j-startTime');
        var $endTime = $('.j-endTime');

        var checkin = $startTime.datepicker({
            onRender: function (date, viewMode) {
                // 默认 days 视图，与当前日期比较
                var viewDate = nowDay;
                switch (viewMode) {
                    // moths 视图，与当前月份比较
                    case 1:
                        viewDate = nowMoth;
                        break;
                    // years 视图，与当前年份比较
                    case 2:
                        viewDate = nowYear;
                        break;
                }
                return date.valueOf() < viewDate ? 'am-disabled' : '';
            }
        }).on('changeDate.datepicker.amui', function (ev) {
            if (ev.date.valueOf() > checkout.date.valueOf()) {
                var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 1);
                checkout.setValue(newDate);
            }
            checkin.close();
            $endTime[0].focus();
        }).data('amui.datepicker');

        var checkout = $endTime.datepicker({
            onRender: function (date, viewMode) {
                var inTime = checkin.date;
                var inDay = inTime.valueOf();
                var inMoth = new Date(inTime.getFullYear(), inTime.getMonth(), 1, 0, 0, 0, 0).valueOf();
                var inYear = new Date(inTime.getFullYear(), 0, 1, 0, 0, 0, 0).valueOf();
                // 默认 days 视图，与当前日期比较
                var viewDate = inDay;
                switch (viewMode) {
                    // moths 视图，与当前月份比较
                    case 1:
                        viewDate = inMoth;
                        break;
                    // years 视图，与当前年份比较
                    case 2:
                        viewDate = inYear;
                        break;
                }
                return date.valueOf() <= viewDate ? 'am-disabled' : '';
            }
        }).on('changeDate.datepicker.amui', function (ev) {
            checkout.close();
        }).data('amui.datepicker');
    });
</script>

<script>
    $(function () {

        // swith切换
        var $mySwitch = $('[data-x-switch]');
        $mySwitch.find('[data-switch-item]').click(function () {
            var $mySwitchBox = $('.' + $(this).data('switch-box'));
            $mySwitchBox.hide().filter('.' + $(this).data('switch-item')).show();
        });

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

        //商品分类选中事件
        $(document).on("change",".citrix-select-item",function()
        {
            var id  = $(this).val()
            var txt = $(this).find("option:selected").data('val');
            $(".citrix-select-item option[value='"+id+"']").remove();
            $(".citrix-choices-ul").append(`<li class="citrix-choice citrix-choice-del-`+id+`" data-id="`+id+`" data-val="`+txt+`">
                                            <i class="iconfont icon-shibai citrix-choice-item-del" data-id="`+id+`">&nbsp;</i>
                                            <input type="text" name="coupon[category][`+id+`]" readonly="" value="`+txt+`" class="citrix-category" style="background: #ddd!important;">
                                        </li>`);
            var len = $(this).find("option").length;
            if(len <= 1)
            {
                $("#citrix-select-item-default").html('没有找到匹配项');
            }
        });
        //商品分类删除事件
        $(document).on("click",".citrix-choice-item-del",function()
        {
            var id  = $(this).attr("data-id");
            var cid  = $(".citrix-choice-del-"+id).attr("data-id");
            var txt  = $(".citrix-choice-del-"+id).attr("data-val");
            $(".citrix-select-item").append("<option value='"+id+"' data-val='"+txt+"'>"+txt+"</option>");
            $(".citrix-choice-del-"+id).remove();
            $("#citrix-select-item-default").html('选择商品分类');
        });

        //商品分类限制
        $(document).on("click",".citrix-cates-limit",function()
        {
            var checked = $("input[name='coupon[limitgoodcatetype]']:checked").val();
            switch(checked) 
            {
                case '1'://允许商品分类限制
                        $(".citrix-cates-item").html(`<label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">选择商品分类 </label>
                                <div class="am-u-sm-9 am-u-end citrix-select">
                                    <ul class="citrix-choices-ul">
                                    </ul>
                                    <select name="cates[]" class="citrix-select-item">
                                        <option value="" id="citrix-select-item-default">选择商品分类</option>
                                        <?php if (!empty($catelist)): foreach ($catelist as $k1 => $v1): ?>
                                        <option value="<?= $v1['category_id'] ?>" data-val="<?= $v1['name'] ?>">
                                            <?= $v1['name'] ?>
                                        </option>
                                        <?php if (isset($v1['child'])): foreach ($v1['child'] as $k2 => $v2): ?>
                                        <option value="<?= $v2['category_id'] ?>" data-val="<?= $v2['name'] ?>">
                                            <?= $v2['name'] ?>
                                        </option>
                                        <?php if (isset($v2['child'])): foreach ($v2['child'] as $k3 => $v3): ?>
                                        <option value="<?= $v3['category_id'] ?>" data-val="<?= $v3['name'] ?>">
                                            <?= $v3['name'] ?>
                                        </option>
                                        <?php endforeach; endif; ?>
                                        <?php endforeach; endif; ?>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>`);
                    break;
                default://不允许商品分类限制
                        $(".citrix-cates-item").html('');
                    break;
            }
        });
        //商品使用限制
        $(document).on("click",".citrix-goods-limit",function()
        {
            var checked = $("input[name='coupon[limitgoodtype]']:checked").val();
            switch(checked) 
            {
                case '1'://允许商品使用限制
                        $(".citrix-goods-item").html(`<label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">选择商品 </label>
                                <div class="am-u-sm-9 am-u-end citrix-goods-list">
                                    <label class="am-radio-inline citrix-width60">
                                        <input type="text" value="" class="form-control text valid citrix-input" readonly="" aria-invalid="false" style="background: #ddd!important;">
                                    </label>
                                    <label class="am-radio-inline citrix-width25">
                                        <button type="button"
                                                class="j-selectGoods upload-file am-btn am-btn-secondary am-radius citrix-span">
                                            <i class="am-icon-cloud-upload"></i> 选择商品
                                        </button>
                                        <span>点击二次调起商品列表</span>
                                    </label>
                                </div>`);
                    break;
                default://不允许商品使用限制
                        $(".citrix-goods-item").html('');
                    break;
            } 
        });
        //选择商品
        $(document).on("click",".j-selectGoods",function()
        {
            $('.j-selectGoods').selectData({
                title: '选择商品',
                uri: 'goods/lists',
                dataIndex: 'goods_id',
                done: function (data) 
                {
                    var template = ``;
                    for (i = 0; i < data.length; i++) 
                    { 
                        if($(".citrix-goods-item-"+data[i]['goods_id']).length>0)
                        {
                            continue;
                        }
                        template  += `<dl class="citrix-goods-dl citrix-goods-item-`+data[i]['goods_id']+`" data-id="`+data[i]['goods_id']+`">
                                            <i class="iconfont icon-shibai citrix-goods-del" data-id="`+data[i]['goods_id']+`">&nbsp;</i>
                                            <dt>
                                                <img src="`+data[i]['goods_image']+`" width="180" height="180">
                                            </dt>
                                            <input type="hidden" name="coupon[goods][`+data[i]['goods_id']+`]" value="`+data[i]['goods_id']+`">
                                            <input type="hidden" name="coupon[goods_image][`+data[i]['goods_id']+`]" value="`+data[i]['goods_image']+`">
                                            <input type="hidden" name="coupon[goods_name][`+data[i]['goods_id']+`]" value="`+data[i]['goods_name']+`">
                                            <dd>`+data[i]['goods_name']+`</dd>
                                        </dl>`;
                    }
                    $(".citrix-goods-list").append(template);
                }
            });
        });
        //删除商品
        $(document).on("click",".citrix-goods-del",function()
        {
            var id = $(this).attr("data-id");
            $(".citrix-goods-item-"+id).remove();
        });
    });
</script>
