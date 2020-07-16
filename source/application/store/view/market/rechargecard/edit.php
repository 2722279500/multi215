<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">编辑储值卡</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">储值卡账号 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="rechargecard[uname]"
                                           value="<?= $model['uname'] ?>" readonly placeholder="请输入储值卡账号" required>
                                </div>
                            </div>
                            <div class="am-form-group switch-rechargecard_type rechargecard_type__10">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">储值卡密码 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="rechargecard[passwd]"
                                           value="<?= $model['passwd'] ?>" readonly placeholder="请输入储值卡密码" required>
                                </div>
                            </div>
                            <div class="am-form-group switch-rechargecard_type rechargecard_type__10">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">储值卡金额 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" min="0.01" class="tpl-form-input" name="rechargecard[price]"
                                           value="<?= $model['price'] ?>" placeholder="请输入储值卡金额" required>
                                </div>
                            </div>
                            <div class="am-form-group" data-x-switch>
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">到期类型 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <!-- <label class="am-radio-inline">
                                        <input type="radio" name="rechargecard[expire_type]" value="10"
                                               data-am-ucheck
                                               disabled
                                               data-switch-box="switch-expire_type"
                                               data-switch-item="expire_type__10"
                                            <?= $model['expire_type'] == 10 ? 'checked' : '' ?>>
                                        领取后生效
                                    </label> -->
                                    <label class="am-radio-inline">
                                        <input type="radio" name="rechargecard[expire_type]" value="20"
                                               data-am-ucheck
                                               disabled
                                               data-switch-box="switch-expire_type"
                                               data-switch-item="expire_type__20"
                                            <?= $model['expire_type'] == 20 ? 'checked' : '' ?>>
                                        固定时间
                                    </label>
                                </div>
                            </div>
                            <div class="am-form-group switch-expire_type expire_type__10 <?= $model['expire_type'] == 10 ? '' : 'hide' ?>">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">有效天数 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" min="1" class="tpl-form-input" name="rechargecard[expire_day]"
                                           value="<?= $model['expire_day'] ?>" placeholder="请输入有效天数" required>
                                </div>
                            </div>
                            <div class="am-form-group switch-expire_type expire_type__20 <?= $model['expire_type'] == 20 ? '' : 'hide' ?>">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">时间范围 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="j-startTime am-form-field am-margin-bottom-sm"
                                           name="rechargecard[start_time]"
                                           value="<?= $model['start_time']['value'] > 1 ? $model['start_time']['text'] : '' ?>"
                                           placeholder="请选择开始日期"
                                           required>
                                    <input type="text" class="j-endTime am-form-field"
                                           name="rechargecard[end_time]"
                                           value="<?= $model['end_time']['value'] > 1 ? $model['end_time']['text'] : '' ?>"
                                           placeholder="请选择结束日期" required>
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
<script>
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

    });
</script>
