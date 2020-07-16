<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:97:"E:\phpstudy_pro\WWW\shop215555\shop215\web/../source/application/supplier\view\withdraw\index.php";i:1594623457;s:90:"E:\phpstudy_pro\WWW\shop215555\shop215\source\application\supplier\view\layouts\layout.php";i:1594611156;}*/ ?>
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
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom-xs am-cf">
                        <table class="am-table am-table-bordered" style="margin: 15px;">
                            <thead>
                                <tr>
                                    <th>可提现</th>
                                    <th>冻结中</th>
                                    <th>总收入</th>
                                    <th>已提现</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= citrixGetSupplierMoneyCount($supplier_user['supplier_user_id']) ?></td>
                                    <td><?= citrixGetSupplierFrozenMoneyCount($supplier_user['supplier_user_id']) ?></td>
                                    <td><?= citrixGetSupplierCanMoneyCount($supplier_user['supplier_user_id']) ?></td>
                                    <td><?= citrixGetSupplierNoMoneyCount($supplier_user['supplier_user_id']) ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <form class="toolbar-form am-form" id="form_array">
                            <div class="am-u-sm-12 am-u-md-9">
                                <div class="am fr">
                                    <div class="am-form-group am-fl">
                                        <div class="am-input-group am-input-group-sm tpl-form-border-form" style="width: 255px;">
                                            <div class="am-form-group">
                                                <select name="zh">
                                                    <option value="">&nbsp;请选择提现账号&nbsp;</option>
                                                    <?php foreach ($bankcard as $val): ?>
                                                    <option value="[<?= $val['username'] ?>][<?= $val['type'] ?>]<?= $val['name'] ?>">&nbsp;[<?= $val['username'] ?>]&nbsp;[<?= $val['type'] ?>]&nbsp;<?= $val['name'] ?>&nbsp;</option>
                                                    <?php endforeach;?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="am fr">
                                    <div class="am-form-group am-fl">
                                        <div class="am-input-group am-input-group-sm tpl-form-border-form" style="width: 220px;">
                                            <input type="text" class="am-form-field" name="je"
                                                   placeholder="请输入提现金额" >
                                        </div>
                                    </div>
                                </div>
                                <div class="am fr">
                                    <div class="am-form-group">
                                        <textarea name="bz" class="am-form-field" rows="8" placeholder="请输入备注:如信用卡或储值卡" style="border: 1px solid #c2cad8;width: 482px;"></textarea>
                                    </div>
                                    <div class="am-form-group">
                                        <b class="am-btn am-btn-danger citrixAdd">提交</b>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table class="am-table">
                            <thead>
                                <tr>
                                    <th width="170">时间</th>
                                    <th width="150">金额</th>
                                    <th >描述/说明</th>
                                    <th width="150">类型</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $colspan = 4; if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td><?= date("Y-m-d H:i:s",$item['create_time']) ?></td>
                                    <td>￥<?= $item['money'] ?></td>
                                    <td>
                                        <?php $item['describe'] = json_decode($item['describe'],true); if ($item['scene'] == 30): ?>
                                            <p>账号：<?= $item['describe']['apply']['zh'] ?></p>
                                            <p>备注：<?= $item['describe']['apply']['bz'] ?></p>
                                        <?php endif; if ($item['scene'] == 40): ?>
                                            <p>账号：<?= $item['describe']['apply']['zh'] ?></p>
                                            <p>备注：<?= $item['describe']['apply']['bz'] ?></p>
                                            <?php if (!empty($item['describe']['verify']['jt'])): ?>
                                            <p>审核截图：<a href="<?= $item['describe']['verify']['jt'] ?>" target="_blank"><img src="<?= $item['describe']['verify']['jt'] ?>" height="30" width="30"></a> </p>
                                            <?php endif; ?>
                                            <p>审核备注：<?= $item['describe']['verify']['bz'] ?></p>
                                        <?php endif; if ($item['scene'] == 20): ?>
                                            <p>账号：<?= $item['describe']['apply']['zh'] ?></p>
                                            <p>备注：<?= $item['describe']['apply']['bz'] ?></p>
                                            <?php if (!empty($item['describe']['verify']['jt'])): ?>
                                            <p>审核截图：<a href="<?= $item['describe']['verify']['jt'] ?>" target="_blank"><img src="<?= $item['describe']['verify']['jt'] ?>" height="30" width="30"></a> </p>
                                            <?php endif; ?>
                                            <p>审核备注：<?= $item['describe']['verify']['bz'] ?></p>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($item['scene'] == 30): ?>
                                        <b class="am-btn am-btn-xs am-btn-warning">
                                            待审核
                                        </b>
                                        <?php endif; if ($item['scene'] == 40): ?>
                                        <b class="am-btn am-btn-xs am-btn-default">
                                            已拒绝
                                        </b>
                                        <?php endif; if ($item['scene'] == 20): ?>
                                        <b class="am-btn am-btn-xs am-btn-danger">
                                            已审核
                                        </b>
                                        <?php endif; ?>
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
<div class="am-modal am-modal-confirm" tabindex="-1" id="my-confirm">
    <div class="am-modal-dialog">
        <div class="am-modal-bd"></div>
        <div class="am-modal-footer">
            <span class="am-modal-btn" data-am-modal-confirm>确定</span>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on("click",".citrixAdd",function()
    {
        $.ajax({
            url:"<?= url('withdraw/add') ?>",
            data:$('#form_array').serialize(),
            type:'post',
            async: false,
            dataType : 'json',
            success:function(res) 
            {
                $(".am-modal-bd").html(res.msg);
                $('#my-confirm').modal({
                    relatedElement: this,
                    onConfirm: function() 
                    {
                        window.location.reload();
                    }
                });
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
