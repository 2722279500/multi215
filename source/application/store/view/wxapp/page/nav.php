<link rel="stylesheet" href="assets/common/plugins/umeditor/themes/default/css/umeditor.css">
<link rel="stylesheet" href="assets/store/css/nav.css?v=<?= $version ?>">
<div class="row-content am-cf">
    <div class="widget am-cf">
        <div class="widget-body">
            <!-- diy 工作区 -->
            <div id="app" class="work-diy dis-flex flex-x-between">
                <!--手机diy容器-->
                <div class='diy-phone-box'>
                    <div class="diy-phone" v-cloak>
                        <!-- 手机顶部标题 -->
                        <div id="diy-page" class="phone-top optional" @click.stop="onEditer('page')"
                             :class="{selected: 'page' === selectedIndex}"
                             :style="{background: diyData.page.style.titleBackgroundColor + ' url(assets/store/img/diy/phone-top-' + diyData.page.style.titleTextColor + '.png) no-repeat center / contain'}">
                            <h4 :style="{color: diyData.page.style.titleTextColor}">{{ diyData.page.params.title }}</h4>
                        </div>
                        <!-- 小程序内容区域 -->
                        <div id="phone-main" class="phone-main" v-cloak>
                            <draggable :list="diyData.items" class="dragArea" @update="onDragItemEnd"
                                       :options="{animation: 120, filter: '.drag__nomove' }">
                                <div class='items-box'>
                                    <template v-for="(item, index) in diyData.items">
                                        <!-- diy元素: 导航组 -->
                                        <template v-if="item.type == 'navBar'">
                                            <div @click.stop="onEditer(index)" class='nav-div'>
                                                <div class="drag optional" :class="{selected:index === selectedIndex}">
                                                    <div class="diy-navBar" :style="{background:item.style.background}">
                                                        <ul style="display: flex;justify-content: space-around;" >
                                                            <li class="" v-for="(navBar,index) in item.data">
                                                                <div class="item-image">
                                                                    <img :src="navBar.default_imgUrl">
                                                                </div>
                                                                <p class="item-text am-text-truncate"
                                                                   :style="{color:navBar.color}">
                                                                    {{navBar.text}}</p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>

                                    </template>
                                </div>
                            </draggable>
                        </div>

                    </div>
                    <button @click.stop="onSubmit" type="button" class="am-btn am-btn-xs am-btn-secondary" style="width: 100%;height: 40px;margin-top: 24px;">
                        保存数据
                    </button>
                </div>


                <!-- 编辑器容器 -->
                <div id="diy-editor" ref="diy-editor" class="diy-editor form-horizontal"
                     :style="{ visibility: selectedIndex != -1 ? 'visible' : 'hidden' } " v-cloak>

                    <!-- 编辑器: 标题栏 -->
                    <div id="tpl_editor_page" v-if="selectedIndex === 'page'">
                        <div class="editor-title"><span>{{ diyData.page.name }}</span></div>
                        <form class="am-form tpl-form-line-form">
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label am-text-xs">页面名称 </label>
                                <div class="am-u-sm-8 am-u-end">
                                    <input class="tpl-form-input" type="text"
                                           v-model="diyData.page.params.name">
                                    <div class="help-block am-margin-top-xs">
                                        <small>页面名称仅用于后台查找</small>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label am-text-xs">页面标题 </label>
                                <div class="am-u-sm-8 am-u-end">
                                    <input class="tpl-form-input" type="text"
                                           v-model="diyData.page.params.title">
                                    <div class="help-block am-margin-top-xs">
                                        <small>小程序端顶部显示的标题</small>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label am-text-xs">分享标题 </label>
                                <div class="am-u-sm-8 am-u-end">
                                    <input class="tpl-form-input" type="text"
                                           v-model="diyData.page.params.share_title">
                                    <div class="help-block am-margin-top-xs">
                                        <small>小程序端转发时显示的标题</small>
                                    </div>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label am-text-xs">标题栏文字 </label>
                                <div class="am-u-sm-8 am-u-end">
                                    <label class="am-radio-inline">
                                        <input type="radio" value="black"
                                               v-model="diyData.page.style.titleTextColor">
                                        黑色
                                    </label>
                                    <label class="am-radio-inline">
                                        <input type="radio" value="white"
                                               v-model="diyData.page.style.titleTextColor">
                                        白色
                                    </label>
                                </div>
                            </div>
                            <div class="am-form-group">
                                <label class="am-u-sm-3 am-form-label am-text-xs">标题栏背景 </label>
                                <div class="am-u-sm-8 am-u-end">
                                    <input class="" type="color"
                                           v-model="diyData.page.style.titleBackgroundColor">
                                    <button type="button" class="btn-resetColor am-btn am-btn-xs"
                                            @click.stop="onEditorResetColor(diyData.page.style, 'titleBackgroundColor', '#ffffff')">
                                        重置
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <template v-if="diyData.items.length && curItem">
                        <!--编辑器: 导航组-->
                        <div id="tpl_editor_navBar" v-if="curItem.type == 'navBar'">
                            <div class="editor-title"><span>{{ curItem.name }}</span></div>
                            <form class="am-form tpl-form-line-form">
                                <div class="am-form-group">
                                    <label class="am-u-sm-4 am-form-label am-text-xs">背景颜色 </label>
                                    <div class="am-u-sm-8 am-u-end">
                                        <input class="" type="color"
                                               v-model="curItem.style.background">
                                        <button type="button" class="btn-resetColor am-btn am-btn-xs"
                                                @click.stop="onEditorResetColor(curItem.style, 'background', '#ffffff')">
                                            重置
                                        </button>
                                    </div>
                                </div>

                                <div class="form-items">
                                    <draggable :list="curItem.data"
                                               :options="{ animation: 120, filter: 'input', preventOnFilter: false }">
                                        <div class="form-item drag" v-for="(navBar, index) in curItem.data">
                                            <i class="iconfont icon-shanchu item-delete"
                                               @click="onEditorDeleleData(index, selectedIndex)"></i>
                                            <div class="item-inner">
                                                <div class="am-form-group">
                                                    <label class="am-u-sm-3 am-form-label am-text-xs">默认图标 </label>
                                                    <div class="am-u-sm-8 am-u-end">
                                                        <div class="data-image">
                                                            <img :src="navBar.default_imgUrl" alt=""
                                                                 @click="onEditorSelectImage(navBar, 'default_imgUrl')">
                                                        </div>
                                                        <div class="help-block">
                                                            <small>建议尺寸100x100</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="am-form-group">
                                                    <label class="am-u-sm-3 am-form-label am-text-xs">选中图标 </label>
                                                    <div class="am-u-sm-8 am-u-end">
                                                        <div class="data-image">
                                                            <img :src="navBar.select_imgUrl" alt=""
                                                                 @click="onEditorSelectImage(navBar, 'select_imgUrl')">
                                                        </div>
                                                        <div class="help-block">
                                                            <small>建议尺寸100x100</small>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="am-form-group">
                                                    <label class="am-u-sm-3 am-form-label am-text-xs">文字内容 </label>
                                                    <div class="am-u-sm-8 am-u-end">
                                                        <input type="text" v-model="navBar.text">
                                                    </div>
                                                </div>
                                                <div class="am-form-group">
                                                    <label class="am-u-sm-3 am-form-label am-text-xs">文字颜色 </label>
                                                    <div class="am-u-sm-8 am-u-end">
                                                        <input type="color" v-model="navBar.color">
                                                        <button type="button" class="btn-resetColor am-btn am-btn-xs"
                                                                @click.stop="onEditorResetColor(navBar, 'color', '#666666')">
                                                            重置
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="am-form-group">
                                                    <label class="am-u-sm-3 am-form-label am-text-xs">选中颜色 </label>
                                                    <div class="am-u-sm-8 am-u-end">
                                                        <input type="color" v-model="navBar.select_color">
                                                        <button type="button" class="btn-resetColor am-btn am-btn-xs"
                                                                @click.stop="onEditorResetColor(navBar, 'select_color', '#f44336')">
                                                            重置
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="am-form-group">
                                                    <label class="am-u-sm-3 am-form-label am-text-xs">链接地址 </label>
                                                    <div class="am-u-sm-8 am-u-end">
                                                        <input type="text" v-model="navBar.linkUrl">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </draggable>
                                </div>
                                <div class="j-data-add form-item-add" @click="onEditorAddData">
                                    <i class="fa fa-plus"></i> 添加一个
                                </div>

                            </form>
                        </div>

                    </template>
                </div>
            </div>
            <!-- 提示 -->
            <div class="tips am-margin-top-lg am-margin-bottom-sm">
                <div class="pre">
                    <p>1. 设计完成后点击"保存页面"，在小程序端页面下拉刷新即可看到效果。</p>
                    <p>2. 如需填写链接地址请参考<a href="<?= url('wxapp.page/links') ?>" target="_blank">页面链接</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 文件库弹窗 -->
{{include file="layouts/_template/file_library" /}}

<script src="assets/common/js/vue.min.js?v=<?= $version ?>"></script>
<script src="assets/common/js/Sortable.min.js?v=<?= $version ?>"></script>
<script src="assets/common/js/vuedraggable.min.js?v=<?= $version ?>"></script>
<script src="assets/store/js/select.data.js?v=<?= $version ?>"></script>
<script src="assets/common/plugins/umeditor/umeditor.config.js?v=<?= $version ?>"></script>
<script src="assets/common/plugins/umeditor/umeditor.min.js?v=<?= $version ?>"></script>
<script src="assets/store/js/nav.js?v=<?= $version ?>"></script>
<script>

    $(function () {
        // 渲染diy页面
        new diyPhone(<?= $defaultData ?>,<?= $jsonData ?>);

    });

</script>