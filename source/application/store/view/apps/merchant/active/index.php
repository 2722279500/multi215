<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf"> 多商家列表</div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom am-cf">
                        <form class="toolbar-form" action="">
                            <input type="hidden" name="s" value="/<?= $request->pathinfo() ?>">
                            <div class="am-u-sm-12 am-u-md-3">
                                <div class="am-form-group">
                                    <div class="am-btn-toolbar">
                                        <?php if (checkPrivilege('apps.merchant.active/add')): ?>
                                            <div class="am-btn-group am-btn-group-xs">
                                                <a class="am-btn am-btn-default am-btn-success am-radius"
                                                   href="<?= url('apps.merchant.active/add') ?>">
                                                    <span class="am-icon-plus"></span> 新增
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="am-u-sm-12 am-u-md-9">
                                <div class="am fr">
                                    <div class="am-form-group am-fl">
                                        <?php $category_id = $request->get('category_id') ?: null; ?>
                                        <select name="category_id"
                                                data-am-selected="{searchBox: 1, btnSize: 'sm',  placeholder: '商品分类', maxHeight: 400}">
                                            <option value=""></option>
                                            <?php if (isset($catgory)): foreach ($catgory as $first): ?>
                                                <option value="<?= $first['category_id'] ?>"
                                                    <?= $category_id == $first['category_id'] ? 'selected' : '' ?>>
                                                    <?= $first['name'] ?></option>
                                                <?php if (isset($first['child'])): foreach ($first['child'] as $two): ?>
                                                    <option value="<?= $two['category_id'] ?>"
                                                        <?= $category_id == $two['category_id'] ? 'selected' : '' ?>>
                                                        　　<?= $two['name'] ?></option>
                                                    <?php if (isset($two['child'])): foreach ($two['child'] as $three): ?>
                                                        <option value="<?= $three['category_id'] ?>"
                                                            <?= $category_id == $three['category_id'] ? 'selected' : '' ?>>
                                                            　　　<?= $three['name'] ?></option>
                                                    <?php endforeach; endif; ?>
                                                <?php endforeach; endif; ?>
                                            <?php endforeach; endif; ?>
                                        </select>
                                    </div>
                                    <div class="am-form-group am-fl">
                                        <div class="am-input-group am-input-group-sm tpl-form-border-form">
                                            <input type="text" class="am-form-field" name="search"
                                                   placeholder="请输入商家名称"
                                                   value="<?= $request->get('search') ?>">
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
                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap">
                            <thead>
                            <tr>
                                <th width="100px">商家ID</th>
                                <th>账号</th>
                                <th>所属分类</th>
                                <th width="20%">商家名称</th>
                                <th width="200px">运营时间</th>
                                <th width="80px">排序</th>
                                <th width="80px">活动状态</th>
                                <th width="160px">创建时间</th>
                                <th width="210px">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td class="am-text-middle"><?= $item['active_id'] ?></td>
                                    <td class="am-text-middle"><?= $item['username'] ?></td>
                                    <td class="am-text-middle"><?= $item['category']['name'] ?></td>
                                    <td class="goods-detail am-text-middle">
                                        <?= $item['name'] ?>
                                    </td>
                                    <td class="am-text-middle">
                                        <p><span>开始时间：</span><?= date('Y-m-d H:i:s',$item['start_time']) ?></p>
                                        <p><span>结束时间：</span><?= date('Y-m-d H:i:s',$item['end_time']) ?></p>
                                    </td>
                                    <td class="am-text-middle"><?= $item['sort'] ?></td>
                                    <td class="am-text-middle">
                                        <span class="am-badge am-badge-<?= $item['status'] ? 'success' : 'warning' ?>">
                                               <?= $item['status'] ? '启用' : '禁用' ?></span>
                                    </td>
                                    <td class="am-text-middle"><?= $item['create_time'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <a href="<?= url('supplier/index/index',['active_id' => $item['active_id']]) ?>"
                                                   class="tpl-table-black-operation-default" target="_blank">
                                                    <i class="am-icon-home"></i> 进入后台
                                                </a>
                                            <?php if (checkPrivilege('apps.merchant.active/edit')): ?>
                                                <a href="<?= url('apps.merchant.active/edit', ['active_id' => $item['active_id']]) ?>"
                                                   class="tpl-table-black-operation-default">
                                                    <i class="am-icon-pencil"></i> 编辑
                                                </a>
                                            <?php endif; ?>
                                            <?php if (checkPrivilege('apps.merchant.active/delete')): ?>
                                                <a href="javascript:void(0);"
                                                   class="item-delete tpl-table-black-operation-default"
                                                   data-id="<?= $item['active_id'] ?>">
                                                    <i class="am-icon-trash"></i> 删除
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="10" class="am-text-center">暂无记录</td>
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
        var url = "<?= url('apps.merchant.active/delete') ?>";
        $('.item-delete').delete('active_id', url);

    });
</script>

