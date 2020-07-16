<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">储值卡列表</div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom-xs am-cf">
                        <form id="form-search" class="toolbar-form" action="">
                            <input type="hidden" name="s" value="/<?= $request->pathinfo() ?>">
                            <div class="am-u-sm-12 am-u-md-3">
                                <div class="am-form-group">
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <?php if (checkPrivilege('market.rechargecard/export')): ?>
                                                <a class="j-export am-btn am-btn-success am-radius"
                                                   href="javascript:void(0);">
                                                    <i class="iconfont icon-daochu am-margin-right-xs"></i>导出
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="am-form-group am-btn-group-xs">
                                            <div class="am-btn-toolbar">
                                                <?php if (checkPrivilege('market.rechargecard/add')): ?>
                                                    <div class="am-btn-group am-btn-group-xs">
                                                        <a class="am-btn am-btn-default am-btn-success am-radius"
                                                        href="<?= url('market.rechargecard/add') ?>">
                                                            <span class="am-icon-plus"></span> 新增
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="am-u-sm-12 am-u-md-9">
                                <div class="am fr">
                                    <div class="am-form-group am-fl">
                                        <?php $is_use = (int) $request->get('is_use', '-1'); ?>
                                        <select name="is_use"
                                                data-am-selected="{btnSize: 'sm', placeholder: '是否使用'}">
                                            <option value=""></option>
                                            <option value="-1"
                                                <?= $is_use === '-1' ? 'selected' : '' ?>>全部
                                            </option>
                                            <option value="0"
                                                <?= 0 == $is_use ? 'selected' : '' ?>>未使用
                                            </option>
                                            <option value="1"
                                                <?= 1 == $is_use ? 'selected' : '' ?>>已使用
                                            </option>
                                        </select>
                                    </div>
                                    <div class="am-form-group tpl-form-border-form am-fl">
                                        <input type="text" name="start_time"
                                               class="am-form-field"
                                               value="<?= $request->get('start_time') ?>" placeholder="请选择起始日期"
                                               data-am-datepicker>
                                    </div>
                                    <div class="am-form-group tpl-form-border-form am-fl">
                                        <input type="text" name="end_time"
                                               class="am-form-field"
                                               value="<?= $request->get('end_time') ?>" placeholder="请选择截止日期"
                                               data-am-datepicker>
                                    </div>
                                    <div class="am-form-group am-fl">
                                        <div class="am-input-group am-input-group-sm tpl-form-border-form">
                                            <div class="am-input-group-btn">
                                                <button class="am-btn am-btn-default am-icon-search"
                                                        type="submit"></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="am-u-sm-12 am-scrollable-horizontal">
                        <table width="100%"
                               class="am-table am-table-compact am-table-striped tpl-table-black am-text-nowrap">
                            <thead>
                            <tr>
                                <th>储值卡ID</th>
                                <th>二维码</th>
                                <th>储值卡账号</th>
                                <th>储值卡密码</th>
                                <th>储值卡金额</th>
                                <th>有效期</th>
                                <th>是否使用</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): ?>
                                <?php foreach ($list as $item): ?>
                                    <tr>
                                        <td class="am-text-middle"><?= $item['recharge_card_id'] ?></td>
                                        <td class="am-text-middle">
                                            <a href="<?= $item['qrcode'] ?>" title="点击查看大图" target="_blank">
                                                <img src="<?= $item['qrcode'] ?>" height="72" alt="">
                                            </a>
                                        </td>
                                        <td class="am-text-middle"><?= $item['uname'] ?></td>
                                        <td class="am-text-middle"><?= $item['passwd'] ?></td>
                                        <td class="am-text-middle"><?= $item['price'] ?></td>
                                        <td class="am-text-middle">
                                            <?php if ($item['expire_type'] == 10) : ?>
                                                <span>领取 <strong><?= $item['expire_day'] ?></strong> 天内有效</span>
                                            <?php elseif ($item['expire_type'] == 20) : ?>
                                                <span><?= $item['start_time']['text'] ?>
                                                    ~ <?= $item['end_time']['text'] ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="am-text-middle"><?= $item['is_use'] ? '是' : '否' ?></td>
                                        <td class="am-text-middle"><?= $item['create_time'] ?></td>
                                        <td class="am-text-middle">
                                            <div class="tpl-table-black-operation">
                                                <?php if (checkPrivilege('market.rechargecard/edit')): ?>
                                                    <a href="<?= url('market.rechargecard/edit', ['recharge_card_id' => $item['recharge_card_id']]) ?>">
                                                        <i class="am-icon-pencil"></i> 编辑
                                                    </a>
                                                <?php endif; ?>
                                                <?php if (checkPrivilege('market.rechargecard/delete')): ?>
                                                    <a href="javascript:void(0);"
                                                       class="item-delete tpl-table-black-operation-del"
                                                       data-id="<?= $item['recharge_card_id'] ?>">
                                                        <i class="am-icon-trash"></i> 删除
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="am-text-center">暂无记录</td>
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
<script>
    $(function () {

        // 删除元素
        var url = "<?= url('market.rechargecard/delete') ?>";
        $('.item-delete').delete('recharge_card_id', url);
        // 导出
        $('.j-export').click(function () {
            var data = {};
            var formData = $('#form-search').serializeArray();
            $.each(formData, function () {
                this.name !== 's' && (data[this.name] = this.value);
            });
            window.location = "<?= url('market.rechargecard/export') ?>" + '&' + $.urlEncode(data);
        });

    });
</script>

