import myBehavior from '../../../utils/diy-behavior.js';
Component({

  options: {},
  lifetimes: {
    attached() {
      this.IsLogin();
    }
  },

  pageLifetimes:{
    show(){
      let _this = this;
      _this.setData({
        isLogin: getApp().checkIsLogin()
      });
    }
  },

  behaviors: [myBehavior],
  properties: {
    params: Object,
    userInfo: Object
  },
  methods: {
    IsLogin() {
      let _this = this;
      _this.setData({
        isLogin: getApp().checkIsLogin()
      });
    },
    
    onLogin() {
      getApp().doLogin()
    }
  }
})