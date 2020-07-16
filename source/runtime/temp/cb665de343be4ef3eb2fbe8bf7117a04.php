<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:108:"E:\phpstudy_pro\WWW\shop215555\shop215\web/../source/application/store\view\apps\merchant\withdraw\index.php";i:1594605736;s:87:"E:\phpstudy_pro\WWW\shop215555\shop215\source\application\store\view\layouts\layout.php";i:1591840256;}*/ ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title><?= $setting['store']['values']['name'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="renderer" content="webkit"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="icon" type="image/png" href="assets/common/i/favicon.ico"/>
    <meta name="apple-mobile-web-app-title" content="<?= $setting['store']['values']['name'] ?>"/>
    <link rel="stylesheet" href="assets/common/css/amazeui.min.css"/>
    <link rel="stylesheet" href="assets/store/css/app.css?v=<?= $version ?>"/>
    <link rel="stylesheet" href="//at.alicdn.com/t/font_783249_m68ye1gfnza.css">
    <script src="assets/common/js/jquery.min.js"></script>
    <script src="//at.alicdn.com/t/font_783249_e5yrsf08rap.js"></script>
    <script>
        BASE_URL = '<?= isset($base_url) ? $base_url : '' ?>';
        STORE_URL = '<?= isset($store_url) ? $store_url : '' ?>';
    </script>
</head>

<body data-type="">
<div class="am-g tpl-g">
    <!-- 头部 -->
    <header class="tpl-header">
        <!-- 右侧内容 -->
        <div class="tpl-header-fluid">
            <!-- 侧边切换 -->
            <div class="am-fl tpl-header-button switch-button">
                <i class="iconfont icon-menufold"></i>
            </div>
            <!-- 刷新页面 -->
            <div class="am-fl tpl-header-button refresh-button">
                <i class="iconfont icon-refresh"></i>
            </div>
            <!-- 其它功能-->
            <div class="am-fr tpl-header-navbar">
                <ul>
                    <!-- 欢迎语 -->
                    <li class="am-text-sm tpl-header-navbar-welcome">
                        <a href="<?= url('store.user/renew') ?>">欢迎你，<span><?= $store['user']['user_name'] ?></span>
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
    <!-- 侧边导航栏 -->
    <div class="left-sidebar dis-flex">
        <?php $menus = $menus ?: []; $group = $group ?: 0; ?>
        <div class="sidebar-scroll">
            <!-- 一级菜单 -->
            <ul class="sidebar-nav">
                <li class="sidebar-nav-heading"><?= $setting['store']['values']['name'] ?></li>
                <?php foreach ($menus as $key => $item): ?>
                    <li class="sidebar-nav-link">
                        <a href="<?= isset($item['index']) ? url($item['index']) : 'javascript:void(0);' ?>"
                           class="<?= $item['active'] ? 'active' : '' ?>">
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
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- 子级菜单-->
        <?php $second = isset($menus[$group]['submenu']) ? $menus[$group]['submenu'] : []; if (!empty($second)) : ?>
            <div class="sidebar-second-scroll">
                <ul class="left-sidebar-second">
                    <li class="sidebar-second-title"><?= $menus[$group]['name'] ?></li>
                    <li class="sidebar-second-item">
                        <?php foreach ($second as $item) : if (!isset($item['submenu'])): ?>
                                <!-- 二级菜单-->
                                <a href="<?= url($item['index']) ?>"
                                   class="<?= (isset($item['active']) && $item['active']) ? 'active' : '' ?>">
                                    <?= $item['name']; ?>
                                </a>
                            <?php else: ?>
                                <!-- 三级菜单-->
                                <div class="sidebar-third-item">
                                    <a href="javascript:void(0);"
                                       class="sidebar-nav-sub-title <?= $item['active'] ? 'active' : '' ?>">
                                        <i class="iconfont icon-caret"></i>
                                        <?= $item['name']; ?>
                                    </a>
                                    <ul class="sidebar-third-nav-sub">
                                        <?php foreach ($item['submenu'] as $third) : ?>
                                            <li>
                                                <a class="<?= $third['active'] ? 'active' : '' ?>"
                                                   href="<?= url($third['index']) ?>">
                                                    <?= $third['name']; ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; endforeach; ?>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <!-- 内容区域 start -->
    <div class="tpl-content-wrapper <?= empty($second) ? 'no-sidebar-second' : '' ?>">
        <div class="row-content am-cf">
    <div class="row">
        <div class="am-u-sm-12 am-u-md-12 am-u-lg-12">
            <div class="widget am-cf">
                <div class="widget-head am-cf">
                    <div class="widget-title am-cf">提现管理</div>
                </div>
                <div class="widget-body am-fr">
                    <!-- 工具栏 -->
                    <div class="page_toolbar am-margin-bottom-xs am-cf">
                        
                    </div>
                    <div class="am-scrollable-horizontal am-u-sm-12">
                        <table class="am-table">
                            <thead>
                                <tr>
                                    <th width="170">时间</th>
                                    <th >商家</th>
                                    <th width="150">金额</th>
                                    <th >描述/说明</th>
                                    <th width="150">类型</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $colspan = 4; if (!$list->isEmpty()): foreach ($list as $item): ?>
                                <tr>
                                    <td><?= date("Y-m-d H:i:s",$item['create_time']) ?></td>
                                    <td><?= $item['supplier_name'] ?></td>
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
                                    <td <?php if ($item['scene'] == 30): ?>class="citrixHandle" data-id="<?= $item['id'] ?>"<?php endif; ?>>
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
<div class="am-modal am-modal-confirm" tabindex="-1" id="my-verify">
    <div class="am-modal-dialog">
        <div class="am-modal-hd">
            <b style="color: #f00;">当前操作,为不可逆！请知晓</b>
            <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
        </div>
        <div class="am-modal-bd">
            <form class="am-form" id="form_array" enctype="multipart/form-data">
                <fieldset>
                    <div class="am-form-group" style="height: 60px;margin: 1.5rem 0 0 0;">
                        <input type="file" name="jt" class="am-fl citrixJt" >
                        <p class="am-form-help am-fl">请选择要上传的截图文件...</p>
                    </div>
                    <div class="am-form-group">
                        <textarea class="am-form-field citrixBz" name="bz" rows="8" placeholder="请输入备注:如已打款,打款时间等"></textarea>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="am-modal-footer">
            <input type="hidden" name="id" value="">
            <span class="am-modal-btn" data-am-modal-cancel>拒绝</span>
            <span class="am-modal-btn" data-am-modal-confirm>同意</span>
        </div>
    </div>
</div>
<div class="am-modal am-modal-alert" tabindex="-1" id="my-result">
    <div class="am-modal-dialog">
        <div class="am-modal-bd citrixMsg"></div>
        <div class="am-modal-footer">
          <span class="am-modal-btn" data-am-modal-confirm>确定</span>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on("click",".citrixHandle",function()
    {
        $('input[name="id"]').val($(this).attr("data-id"));
        $('#my-verify').modal({
            relatedTarget: this,
            onConfirm: function(data) 
            {
                citrixPopup(20,$('input[name="id"]').val());
            },
            onCancel: function(data) 
            {
                window.location.reload();
            }
        });
    });
    function citrixPopup(scene,id)
    {
        var formdata = new FormData($(".citrixJt"));
　　　　 formdata.append('jt',$(".citrixJt").get(0).files[0]); 
　　　　 formdata.append('scene',scene); 
　　　　 formdata.append('bz',$(".citrixBz").val()); 
　　　　 formdata.append('id',id); 
        $.ajax({
            url:"<?= url('apps.merchant.withdraw/add') ?>",
            data:formdata,
            type:'post',
            async: false,  
            cache: false,  
            contentType: false,  
            processData: false,
            dataType : 'json',
            success:function(res) 
            {
                $(".citrixMsg").html(res.msg);
                $('#my-result').modal({
                    relatedElement: this,
                    onConfirm: function() 
                    {
                        window.location.reload();
                    }
                });
            }
        });
    }
</script>
    </div>
    <!-- 内容区域 end -->

</div>
<script src="assets/common/plugins/layer/layer.js"></script>
<script src="assets/common/js/jquery.form.min.js"></script>
<script src="assets/common/js/amazeui.min.js"></script>
<script src="assets/common/js/webuploader.html5only.js"></script>
<script src="assets/common/js/art-template.js"></script>
<script src="assets/store/js/app.js?v=<?= $version ?>"></script>
<script src="assets/store/js/file.library.js?v=<?= $version ?>"></script>
</body>

</html>
