// diy-behavior.js
const App = getApp();
module.exports = Behavior({

  /**
   * 组件的属性列表
   * 用于组件自定义设置
   */
  properties: {
    itemIndex: String,
    itemStyle: Object,
    dataList: Object
  },

  methods: {
    
    onTargetPage(e) {
      let _this = this;
      let url = e.currentTarget.dataset.path;
      if (!_this.onCheckLogin()) {
        return false;
      }
      // 记录formId
      App.saveFormId(e.detail.formId);
      App.navigationTo(url);
    },

    /**
    * 验证是否已登录
    */
    onCheckLogin() {
      let _this = this;
      if (!getApp().checkIsLogin()) {
        App.showError('很抱歉，您还没有登录');
        return false;
      }
      return true;
    },
  }
})