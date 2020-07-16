<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <form id="my-form" class="am-form tpl-form-line-form" method="post">
                    <div class="widget-body">
                        <fieldset>
                            <div class="widget-head am-cf">
                                <div class="widget-title am-fl"> 新增商家</div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 账号 </label>
                                <div class="am-u-sm-9 am-u-md-6 am-u-lg-5 am-u-end">
                                    <input type="text" class="tpl-form-input" name="active[username]"
                                           value="<?= $model['username'] ?>" required>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label "> 密码 </label>
                                <div class="am-u-sm-9 am-u-md-6 am-u-lg-5 am-u-end">
                                    <input type="password" class="tpl-form-input" name="active[password]"
                                           value="" >
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 邮箱 </label>
                                <div class="am-u-sm-9 am-u-md-6 am-u-lg-5 am-u-end">
                                    <input type="text" class="tpl-form-input" name="active[email]"
                                           value="<?= $model['email'] ?>" required>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 手机号 </label>
                                <div class="am-u-sm-9 am-u-md-6 am-u-lg-5 am-u-end">
                                    <input type="text" class="tpl-form-input" name="active[phone]"
                                           value="<?= $model['phone'] ?>" required>
                                </div>
                            </div>
                            
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 商家名称 </label>
                                <div class="am-u-sm-9 am-u-md-6 am-u-lg-5 am-u-end">
                                    <input type="text" min="1" class="tpl-form-input" name="active[name]"
                                           placeholder="" value="<?= $model['name'] ?>">

                                </div>
                            </div>
                            
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">商家分类 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <select name="active[category_id]" required
                                            data-am-selected="{searchBox: 1, btnSize: 'sm',
                                             placeholder:'请选择商家分类', maxHeight: 400}">
                                        <option value=""></option>
                                        <?php if (isset($catgory)): foreach ($catgory as $first): ?>
                                            <option value="<?= $first['category_id'] ?>"
                                                <?= $model['category_id'] == $first['category_id'] ? 'selected' : '' ?>>
                                                <?= $first['name'] ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="am-form-group am-padding-top">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 门店区域 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="x-region-select" data-region-selected>
                                        <select name="active[province_id]"
                                                data-province
                                                data-id="<?= $model['province_id'] ?>"
                                                required>
                                            <option value="">请选择省份</option>
                                        </select>
                                        <select name="active[city_id]"
                                                data-city
                                                data-id="<?= $model['city_id'] ?>"
                                                required>
                                            <option value="">请选择城市</option>
                                        </select>
                                        <select name="active[region_id]"
                                                data-region
                                                data-id="<?= $model['region_id'] ?>"
                                                required>
                                            <option value="">请选择地区</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 详细地址 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <input type="text" class="tpl-form-input" name="active[address]"
                                           placeholder="请输入详细地址" value="<?= $model['address'] ?>" required>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 门店坐标 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-block">
                                        <input type="text" style="background: none !important;" id="coordinate"
                                               class="tpl-form-input" name="active[coordinate]"
                                               placeholder="请选择门店坐标"
                                               value="<?= $model['latitude'] ?>,<?= $model['longitude'] ?>"
                                               readonly=""
                                               required>
                                    </div>
                                    <div class="am-block am-padding-top-xs">
                                        <iframe id="map" src="<?= url('shop/getpoint') ?>"
                                                width="915"
                                                height="610"></iframe>
                                    </div>
                                </div>
                            </div>

                            <div class="am-form-group am-padding-top">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 运营时间 </label>
                                <div class="am-u-sm-9 am-u-md-6 am-u-lg-5 am-u-end">
                                    <!-- 会员等级列表-->
                                    <div class="am-input-group">
                                        <input type="text" class=" am-form-field"
                                               name="active[start_time]"
                                               placeholder="开始时间" value="<?= date("Y-m-d H:i:s",$model['start_time']) ?>" readonly="readonly">
                                        <span class="am-input-group-label am-input-group-label__center">至</span>
                                        <input type="text" class=" am-form-field"
                                               name="active[end_time]"
                                               placeholder="结束时间" value="<?= date("Y-m-d H:i:s",$model['end_time']) ?>" readonly="readonly">
                                    </div>
                                    <div class="help-block">
                                        <small>商家运营的开始时间与截止时间</small>
                                    </div>
                                </div>
                            </div>

                            <div class="am-form-group am-padding-top">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 抽成比例 </label>
                                <div class="am-u-sm-9 am-u-md-6 am-u-lg-5 am-u-end">
                                    <div class="am-input-group">
                                        <input type="text" class="tpl-form-input"
                                               name="active[supplier_rebate]"
                                               placeholder="抽成比例" id="citrixSupplierRebate" value="<?= $model['supplier_rebate'] ?>" readonly="readonly">
                                    </div>
                                    <div class="help-block">
                                        <small>0-100之间</small>
                                    </div>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 关键词 </label>
                                <div class="am-u-sm-9 am-u-md-6 am-u-lg-5 am-u-end">
                                    <input type="text" class="tpl-form-input" name="active[keywords]"
                                           value="<?= $model['keywords'] ?>">
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label"> 简单描述 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <textarea  name="active[description]" type="text" rows="5"><?= $model['description'] ?></textarea>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">头像 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-form-file">
                                        <button type="button"
                                                class="upload-file-thumb am-btn am-btn-secondary am-radius" style="font-size: 1.22rem;padding: .5rem .9rem;">
                                            <i class="am-icon-cloud-upload"></i> 选择图片
                                        </button>
                                        <div class="uploader-list am-cf">
                                            <?php if ($model['thumb_id']): ?>
                                                <div class="file-item">
                                                    <img src="uploads/<?= $model['thumb']['file_name'] ?>">
                                                    <input type="hidden" name="active[thumb_id]"
                                                           value="<?= $model['thumb_id'] ?>">
                                                    <i class="iconfont icon-shanchu file-item-delete"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">封面图片 </label>
                                <div class="am-u-sm-9 am-u-end">
                                    <div class="am-form-file">
                                        <button type="button"
                                                class="upload-file am-btn am-btn-secondary am-radius">
                                            <i class="am-icon-cloud-upload"></i> 选择图片
                                        </button>
                                        <div class="uploader-list am-cf">
                                            <?php if ($model['image_id']): ?>
                                                <div class="file-item">
                                                    <img src="uploads/<?= $model['image']['file_name'] ?>">
                                                    <input type="hidden" name="active[image_id]"
                                                           value="<?= $model['image_id'] ?>">
                                                    <i class="iconfont icon-shanchu file-item-delete"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="am-form-group am-padding-top">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require"> 商家状态 </label>
                                <div class="am-u-sm-9 am-u-md-6 am-u-lg-5 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" name="active[status]" value="1" data-am-ucheck
                                            <?= $model['status'] == 1 ? 'checked' : '' ?>>
                                        启用
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" name="active[status]" value="0" data-am-ucheck
                                            <?= $model['status'] == 0 ? 'checked' : '' ?>>
                                        禁用
                                    </label>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-u-lg-2 am-form-label form-require">排序 </label>
                                <div class="am-u-sm-9 am-u-md-6 am-u-lg-5 am-u-end">
                                    <input type="number" min="0" class="tpl-form-input" name="active[sort]"
                                           value="<?= $model['sort'] ?>" readonly="readonly">
                                    <small>数字越小越靠前</small>
                                </div>
                            </div>

                            <div class="am-form-group">
                                <div class="am-u-sm-9 am-u-sm-push-3 am-margin-top-lg">
                                    <button type="submit" class="j-submit am-btn am-btn-sm am-btn-secondary"> 提交
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
{{include file="layouts/_template/tpl_file_item" /}}

<!-- 文件库弹窗 -->
{{include file="layouts/_template/file_library" /}}

<script src="assets/store/js/select.region.js?v=1.2"></script>
<script>
    /**
     * 设置坐标
     */
    function setCoordinate(value) {
        var $coordinate = $('#coordinate');
        $coordinate.val(value);
        // 触发验证
        $coordinate.trigger('change');
    }
</script>

<script src="assets/common/plugins/laydate/laydate.js"></script>
<script src="assets/common/plugins/umeditor/umeditor.config.js?v=<?= $version ?>"></script>
<script src="assets/common/plugins/umeditor/umeditor.min.js"></script>

<script>
    $(function () {

        // 时间选择器
        laydate.render({
            elem: '.j-laydate-start'
            , type: 'datetime'
        });

        // 时间选择器
        laydate.render({
            elem: '.j-laydate-end'
            , type: 'datetime'
        });

        // 选择图片
        $('.upload-file').selectImages({
            name: 'active[image_id]'
        });

        // 选择图片
        $('.upload-file-thumb').selectImages({
            name: 'active[thumb_id]'
        });

        /**
         * 表单验证提交
         * @type {*}
         */
        $('#my-form').superForm();

        //抽成比例只允许输入0-100
        var cloud = document.getElementById("citrixSupplierRebate");
        cloud.onkeyup = function(){
            this.value=this.value.replace(/\D/g,'');
            if(cloud.value>100){
                cloud.value = 100;
            }
        }
    });
</script>
