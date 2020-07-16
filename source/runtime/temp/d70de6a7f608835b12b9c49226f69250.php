<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:97:"E:\phpstudy_pro\WWW\shop215555\shop215\web/../source/application/supplier\view\bankcard\index.php";i:1594623254;s:90:"E:\phpstudy_pro\WWW\shop215555\shop215\source\application\supplier\view\layouts\layout.php";i:1594611156;}*/ ?>
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
                    <div class="widget-title am-cf">
                        &emsp;&emsp;&emsp;
                        <a href="<?= url('withdraw/index') ?>" class="am-btn am-btn-default" style="margin-top: -6px;">提现管理</a>
                        &emsp;&emsp;&emsp;
                        <a href="<?= url('bankcard/index') ?>" class="am-btn am-btn-danger" style="margin-top: -6px;">银行卡管理</a>
                    </div>
                </div>
                <div class="page_toolbar am-margin-bottom-xs am-cf">
                    <form class="toolbar-form" action="">
                        <input type="hidden" name="s" value="/supplier/goods/index">
                        <div class="am-u-sm-12 am-u-md-3">
                            <div class="am-form-group">
                                <div class="am-btn-group am-btn-group-xs">
                                    <a class="am-btn am-btn-default am-btn-success" href="<?= url('bankcard/add') ?>">
                                        <span class="am-icon-plus">
                                        </span>
                                        新增
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="widget-body am-fr">
                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table class="am-table">
                            <thead>
                                <tr>
                                    <th width="50">编号</th>
                                    <th width="170">收款人</th>
                                    <th width="170">银行账号</th>
                                    <th width="150">所属银行</th>
                                    <th width="150">操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $colspan = 3; if (!empty($list)): foreach ($list as $item): ?>
                                <tr>
                                    <td><?= $item['id'] ?></td>
                                    <td><?= $item['username'] ?></td>
                                    <td><?= $item['name'] ?></td>
                                    <td><?= $item['type'] ?></td>
                                    <td>
                                        <div class="tpl-table-black-operation">
                                        <a href="javascript:;" class="item-delete tpl-table-black-operation-del citrixDel" data-id="<?= $item['id'] ?>">
                                            <i class="am-icon-trash"></i> 删除
                                        </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="<?= $colspan ?>" class="am-text-center">暂无记录</td>
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
<div class="am-modal am-modal-confirm" id="del-msg">
    <div class="am-modal-dialog">
        <div class="am-modal-hd" id="del-out">警告！</div>
        <div class="am-modal-bd" id="del-txt">您确定要执行当前删除命令</div>
        <div class="am-modal-footer">
            <span class="am-modal-btn" data-am-modal-cancel>取消</span>
            <span class="am-modal-btn" data-am-modal-confirm>确定</span>
        </div>
    </div>
</div>
<div class="am-modal am-modal-confirm" id="my-alert">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">提示！</div>
        <div class="am-modal-bd" id="alert-txt"></div>
        <div class="am-modal-footer">
            <span class="am-modal-btn" data-am-modal-cancel>取消</span>
            <span class="am-modal-btn" data-am-modal-confirm>确定</span>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on("click",".citrixDel",function()
    {
        var cid = $(this).attr('data-id');
        $('#del-msg').modal({
            relatedElement: this,
            closable:false
            ,onConfirm: function() 
            {
                $.ajax({
                    url:"<?= url('bankcard/del') ?>",
                    data:{id:cid},
                    type:'post',
                    async: false,
                    dataType : 'json',
                    success:function(res) 
                    {
                        $("#alert-txt").html(res.msg);
                        $('#my-alert').modal({
                            relatedElement: this,
                            onConfirm: function() 
                            {
                                window.location.reload();
                            },
                            onCancel: function() {
                                window.location.reload();
                            }
                        });
                    },
                    error: function (jqXHR, textStatus, errorThrown) 
                    {
                        window.location.reload();
                    }
                });
            },
            onCancel: function() {
                window.location.reload();
            }
        });
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
