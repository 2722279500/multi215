<style type="text/css">
    .title {background-color: #f3f0f0;}
    .am-modal-bd ul{margin-top: 4rem;height: 200px;}
    .am-modal-bd ul li{height:150px;width:120px;color:#ffffff;margin:4px 6px 4px;border-radius:4px;line-height: 65px }
    .am-modal-bd .box-1{background-color: #7ecf6b;}
    .am-modal-bd .box-2{background-color: #ffb243;}
    .am-modal-bd .box-3{background-color: #ff5555;}
    .am-modal-bd .box-4{background-color: #9e9e9e;}
</style>
<div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">页面设计</div>
                </div>
                <div class="widget-body am-fr">
                    <div class="am-u-sm-12 am-u-md-6 am-u-lg-6">
                        <div class="am-form-group">
                            <div class="am-btn-toolbar">
<!--                                --><?php //if (checkPrivilege('wxapp.page/add')): ?>
<!--                                    <div class="am-btn-group am-btn-group-xs">-->
<!--                                        <a class="am-btn am-btn-default am-btn-success am-radius"-->
<!--                                           href="--><?//= url('wxapp.page/add') ?><!--">-->
<!--                                            <span class="am-icon-plus"></span> 新增-->
<!--                                        </a>-->
<!--                                    </div>-->
<!--                                --><?php //endif; ?>

                                <div class="am-btn-group am-btn-group-xs">
                                    <a id="add" class="am-btn am-btn-default am-btn-success am-radius" href="javascript:;">
                                        <span class="am-icon-plus js-modal-toggle"></span> 新增
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap">
                            <thead>
                            <tr>
                                <th>页面ID</th>
                                <th width="40%">页面名称</th>
                                <th>页面类型</th>
                                <th>添加时间</th>
                                <th>更新时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list

                                                                   as $item): ?>
                                <tr>
                                    <td class="am-text-middle"><?= $item['page_id'] ?></td>
                                    <td class="am-text-middle">
                                        <?php if ($item['is_default']) : ?>
                                            <?php if ($item['page_type'] == 10) : ?>
                                                <span class="am-badge am-badge-danger am-radius">默认首页</span>
                                            <?php elseif ($item['page_type'] == 30) : ?>
                                                <span class="am-badge am-badge-danger am-radius">默认会员中心</span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <span><?= $item['page_name'] ?></span>
                                    </td>
                                    <td class="am-text-middle">
                                        <?php if ($item['page_type'] == 10) : ?>
                                            <span class="am-badge am-badge-warning">商城首页</span>
                                        <?php elseif ($item['page_type'] == 20) : ?>
                                            <span class="am-badge am-badge-secondary">自定义页</span>
                                        <?php elseif ($item['page_type'] == 30) : ?>
                                            <span class="am-badge am-badge-success">会员中心页</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="am-text-middle"><?= $item['create_time'] ?></td>
                                    <td class="am-text-middle"><?= $item['update_time'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <?php if (checkPrivilege('wxapp.page/edit')): ?>
                                                <a href="<?= url('wxapp.page/edit', ['page_id' => $item['page_id']]) ?>">
                                                    <i class="am-icon-pencil"></i> 编辑
                                                </a>
                                            <?php endif; ?>
                                            <?php if (!$item['is_default']) : ?>
                                                <?php if (checkPrivilege('wxapp.page/delete')): ?>
                                                    <a href="javascript:;"
                                                       class="item-delete tpl-table-black-operation-del"
                                                       data-id="<?= $item['page_id'] ?>">
                                                        <i class="am-icon-trash"></i> 删除
                                                    </a>
                                                <?php endif; ?>
                                                <?php if (checkPrivilege('wxapp.page/sethome')): ?>
                                                    <a href="javascript:;"
                                                       class="j-setHome tpl-table-black-operation-green"
                                                       data-id="<?= $item['page_id'] ?>" data-type="<?= $item['page_type'] ?>">
                                                        <i class="iconfont icon-home"></i> 设为默认
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="5" class="am-text-center">暂无记录</td>
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
<!--弹出选择框-->
<div class="am-modal am-modal-no-btn" tabindex="-1" id="your-modal">
    <div class="am-modal-dialog">
        <div class="am-modal-hd title">添加页面
            <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
        </div>
        <div class="am-modal-bd">
            <ul class="am-avg-sm-4 am-thumbnails">
                <li class="box-1">
                    <span>商城首页</span>
                    <a class="am-badge am-badge-success am-radius" href="<?= url('wxapp.page/add',['type'=>10]) ?>">立即创建</a>
                </li>
                <li class="box-2">
                    <span>会员中心</span>
                    <a class="am-badge am-badge-warning am-radius" href="<?= url('wxapp.page/add',['type'=>30]) ?>">立即创建</a>
                </li>
                <li class="box-3">
                    <span>自定义页面</span>
                    <a class="am-badge am-badge-danger  am-radius" href="<?= url('wxapp.page/add',['type'=>20]) ?>">立即创建</a>
                </li>
                <li class="box-4">敬请期待..</li>
            </ul>
        </div>
    </div>
</div>
<!--弹出选择框-->
<script type="text/javascript">
    $(function () {
        //添加页面
        var $modal = $('#your-modal');

        $('#add').on('click', function(e) {
            var $target = $(e.target);
            $modal.modal('toggle');

        });

        // 删除元素
        $('.item-delete').delete('page_id', "<?= url('wxapp.page/delete') ?>");

        // 设为首页
        $('.j-setHome').click(function () {
            var pageId = $(this).attr('data-id');
            var type = $(this).attr('data-type');
            layer.confirm('确定要将此页面设置为默认页吗？', function (index) {
                $.post("<?= url('wxapp.page/sethome') ?>", {page_id: pageId,type:type}, function (result) {
                    result.code === 1 ? $.show_success(result.msg, result.url)
                        : $.show_error(result.msg);
                });
                layer.close(index);
            });
        });

    });
</script>

