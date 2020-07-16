<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" enctype="multipart/form-data" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl">添加储值卡</div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">账号前缀 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="rechargecard[prefix]"
                                           value="RC" placeholder="请输入账号前缀" required>
                                </div>
                            </div>
                            <div class="am-form-group switch-rechargecard_type rechargecard_type__10">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">储值卡金额 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" min="0.01" class="tpl-form-input" name="rechargecard[price]"
                                           value="10" placeholder="请输入储值卡金额" required>
                                </div>
                            </div>
                            <div class="am-form-group" data-x-switch>
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">到期类型 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <!-- <label class="am-radio-inline">
                                        <input type="radio" name="rechargecard[expire_type]" value="10" checked
                                               data-am-ucheck
                                               data-switch-box="switch-expire_type"
                                               data-switch-item="expire_type__10">
                                        领取后生效
                                    </label> -->
                                    <label class="am-radio-inline">
                                        <input type="radio" name="rechargecard[expire_type]" value="20" checked
                                               data-am-ucheck
                                               data-switch-box="switch-expire_type"
                                               data-switch-item="expire_type__20">
                                        固定时间
                                    </label>
                                    <small style="display: block;">（请在下方设置储值卡有效期，不在日期内，不允许充值，充值成功后永久有效）</small>
                                </div>
                            </div>
                            <div class="am-form-group switch-expire_type expire_type__10 hide">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">有效天数 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" min="1" class="tpl-form-input" name="rechargecard[expire_day]"
                                           value="3" placeholder="请输入有效天数" required>
                                </div>
                            </div>
                            <div class="am-form-group switch-expire_type expire_type__20">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">时间范围 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="j-startTime am-form-field am-margin-bottom-sm"
                                           name="rechargecard[start_time]" placeholder="请选择开始日期" required>
                                    <input type="text" class="j-endTime am-form-field" name="rechargecard[end_time]"
                                           placeholder="请选择结束日期" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">生成数量 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="number" min="1" max="1000" class="tpl-form-input" name="rechargecard[total]"
                                           value="10" placeholder="请输入生成数量" required>
                                    <small>注意：一次性生成数量不得超过1000，建议在500个内，请在带宽闲时生成</small>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                    <button type="submit" id="submit_btn" class="j-submit am-btn am-btn-secondary">提交
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
