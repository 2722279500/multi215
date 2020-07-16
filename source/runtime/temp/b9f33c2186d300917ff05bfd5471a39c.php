<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:102:"E:\phpstudy_pro\WWW\shop215555\shop215\web/../source/application/supplier\view\goods\comment\index.php";i:1591840256;s:90:"E:\phpstudy_pro\WWW\shop215555\shop215\source\application\supplier\view\layouts\layout.php";i:1594611156;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
    <title>商家管理系统</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="icon" type="image/png" href="assets/common/i/favicon.ico"/>
    <meta name="apple-mobile-web-app-title" content="商家管理系统"/>
    <link rel="stylesheet" href="assets/common/css/amazeui.min.css"/>
    <link rel="stylesheet" href="assets/supplier/css/app.css"/>
    <link rel="stylesheet" href="//at.alicdn.com/t/font_783249_c9du3u6ahxp.css">
    <script src="assets/common/js/jquery.min.js"></script>
    <style type="text/css">
        .tpl-content-wrapper
        {
            width: 100%;
            max-width:100%;
        }
    </style>
    <script>
        BASE_URL = '<?= isset($base_url) ? $base_url : '' ?>';
        STORE_URL = '<?= isset($supplier_url) ? $supplier_url : '' ?>';
    </script>
</head>

<body data-type="">
<div class="am-g tpl-g">
    <!-- 头部 -->
    <header class="tpl-header">
        <!-- 右侧内容 -->
        <div class="tpl-header-fluid">
            <!-- logo -->
            <div style="float: left;height: 50px;line-height: 50px;">
                <a href="<?= url('index/index') ?>">多商家管理后台</a>
            </div>
            <!-- 其它功能-->
            <div class="am-fr tpl-header-navbar">
                <ul>
                    <!-- 欢迎语 -->
                    <li class="am-text-sm tpl-header-navbar-welcome">
                        <a href="<?= url('supplier.user/renew') ?>">欢迎你，
                            <span style="color: #4aaa4a;">
                            [<?= $supplier['user']['name'] ?>]
                            </span>
                            <span>
                            <?= $supplier['user']['username'] ?>
                            </span>
                        </a>
                    </li>
                    <!-- 退出 -->
                    <li class="am-text-sm">
                        <a href="<?= url('passport/logout') ?>">
                            <i class="iconfont icon-tuichu"></i> 退出
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- 内容区域 start -->
    <div class="tpl-content-wrapper dis-flex">
        <!-- 左侧菜单 -->
        <?php $menus = $menus ?: []; $group = $group ?: 0; ?>
        <div class="left-sidebar">
            <ul class="sidebar-nav">
                <?php foreach ($menus as $key => $item): ?>
                    <li class="sidebar-nav-link">
                        <a href="<?= isset($item['index']) ? url($item['index']) : 'javascript:void(0);' ?>"
                           class="sidebar-nav-link-disabled">
                            <?php if (isset($item['is_svg']) && $item['is_svg'] == true): ?>
                                <svg class="icon sidebar-nav-link-logo" aria-hidden="true">
                                    <use xlink:href="#<?= $item['icon'] ?>"></use>
                                </svg>
                            <?php else: ?>
                                <i class="iconfont sidebar-nav-link-logo <?= $item['icon'] ?>"
                                   style="<?= isset($item['color']) ? "color:{$item['color']};" : '' ?>"></i>
                            <?php endif; ?>
                            <?= $item['name'] ?>
                        </a>
                        <!-- 子级菜单-->
                        <?php if (isset($item['submenu']) && !empty($item['submenu'])) : ?>
                            <ul class="sidebar-third-nav-sub">
                                <?php foreach ($item['submenu'] as $second) : ?>
                                    <li class="sidebar-nav-link <?= $second['active'] ? 'active' : '' ?>">
                                        <a class="" href="<?= url($second['index']) ?>">
                                            <?= $second['name'] ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- 内容区域 -->
        <div class="row-content am-cf">
            <div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">评价列表</div>
                </div>
                <div class="widget-body am-fr">
                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table width="100%" class="am-table am-table-compact am-table-striped
                         tpl-table-black am-text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>商品图片</th>
                                <th>商品名称</th>
                                <th class="am-text-middle">用户</th>
                                <th>评分</th>
                                <th>评价内容</th>
                                <th>是否有图片</th>
                                <th>显示状态</th>
                                <th>评价排序</th>
                                <th>评价时间</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td class="am-text-middle"><?= $item['comment_id'] ?></td>
                                    <td class="am-text-middle">
                                        <a href="<?= $item['order_goods']['image']['file_path'] ?>"
                                           title="点击查看大图" target="_blank">
                                            <img src="<?= $item['order_goods']['image']['file_path'] ?>"
                                                 width="50" height="50" alt="商品图片">
                                        </a>
                                    </td>
                                    <td class="am-text-middle">
                                        <p class="item-title"><?= $item['order_goods']['goods_name'] ?></p>
                                    </td>
                                    <td class="am-text-middle">
                                        <p class=""><?= $item['user']['nickName'] ?></p>
                                        <p class="am-link-muted">(用户id：<?= $item['user']['user_id'] ?>)</p>
                                    </td>
                                    <td class="am-text-middle">
                                        <?php if ($item['score'] == 10) : ?>
                                            <span class="x-color-green">好评</span>
                                        <?php elseif ($item['score'] == 20) : ?>
                                            <span class="x-color-yellow">中评</span>
                                        <?php else: ?>
                                            <span class="x-color-red">差评</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="am-text-middle">
                                        <p class="item-title"><?= $item['content'] ?></p>
                                    </td>
                                    <td class="am-text-middle">
                                        <?php if ($item['is_picture']) : ?>
                                            <span class="x-color-green">是</span>
                                        <?php else: ?>
                                            <span class="">否</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="am-text-middle">
                                        <?php if ($item['status']) : ?>
                                            <span class="x-color-green">显示</span>
                                        <?php else: ?>
                                            <span class="x-color-red">隐藏</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="am-text-middle"><?= $item['sort'] ?></td>
                                    <td class="am-text-middle"><?= $item['create_time'] ?></td>
                                    <td class="am-text-middle">
                                        <div class="tpl-table-black-operation">
                                            <?php if (checkPrivilege('goods.comment/detail')): ?>
                                                <a class="tpl-table-black-operation-default"
                                                   href="<?= url('goods.comment/detail', ['comment_id' => $item['comment_id']]) ?>">
                                                    <i class="am-icon-pencil"></i> 详情
                                                </a>
                                            <?php endif; if (checkPrivilege('goods.comment/delete')): ?>
                                                <a href="javascript:void(0);"
                                                   class="item-delete tpl-table-black-operation-default"
                                                   data-id="<?= $item['comment_id'] ?>">
                                                    <i class="am-icon-trash"></i> 删除
                                                </a>
                                            <?php endif; if (checkPrivilege('order/detail')): ?>
                                                <a class="tpl-table-black-operation-default"
                                                   href="<?= url('order/detail', ['order_id' => $item['order_id']]) ?>">
                                                    <i class="iconfont icon-order-o"></i> 订单详情
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="11" class="am-text-center">暂无记录</td>
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
        var url = "<?= url('goods.comment/delete') ?>";
        $('.item-delete').delete('comment_id', url);
    });
</script>


        </div>

    </div>
    <!-- 内容区域 end -->

    <div class="help-block am-text-center am-padding-sm">
        <small>当前系统版本号：v<?= $version ?></small>
    </div>
</div>
<script src="assets/common/plugins/layer/layer.js"></script>
<script src="assets/common/js/jquery.form.min.js"></script>
<script src="assets/common/js/amazeui.min.js"></script>
<script src="assets/common/js/webuploader.html5only.js"></script>
<script src="assets/common/js/art-template.js"></script>
<script src="assets/store/js/app.js"></script>
<script src="assets/store/js/file.library.js?v=1.1.42"></script>

</body>

</html>
