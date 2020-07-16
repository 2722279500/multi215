const App = getApp();

Page({

  /**
   * 页面的初始数据
   */
  data: {
	  // 当前页面参数
	  options: {},
	  setting: {},
	  uname: '',
	  passwd: ''
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function(options) {
	let _this = this,
    // 当前页面参数
	scene = App.getSceneData(options);
	// 记录options
	_this.setData({
	  options: scene
	});
	if (typeof _this.data.options.rcid != 'undefined') {
		_this.use();
	}
	_this.getInfo();
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function() {},
  
  getInfo: function() {
    let _this = this;
    App._get('recharge.card/index', {}, function(result) {
      _this.setData({
        setting: result.data.setting
      });
    });
  },
  
  bindUnameInput: function (e) {
	this.setData({
	  uname: e.detail.value
	})
  },
  
  bindPasswdInput: function (e) {
	this.setData({
	  passwd: e.detail.value
	})
  },
  
  /**
   * 生命周期函数--监听页面显示
   */
  scan_code: function() {
	wx.scanCode({
	  success: (res) => {
		  if (typeof res.path != 'undefined') {
			  wx.redirectTo({
				  url: '/' + res.path
			  })
		  } else {
			  App.showError('小程序码识别失败');
		  }
	  },
	  fail: () => {
		App.showError('小程序码识别失败');
	  }
	})
  },

  /**
   * 立即领取
   */
  use: function(e) {
    let _this = this,
      rcid = _this.data.options.rcid;
    App._post_form('recharge.card/submit', {
      rcid: rcid,
	  type: 1,
    }, function(result) {
      App.showSuccess(result.msg);
    });
  },
  
  /**
   * 立即领取
   */
  receive: function(e) {
    let _this = this,
		uname = _this.data.uname,
		passwd = _this.data.passwd;
	if (!uname) {
		App.showError('请输入账号');
		return false
	}
	if (!passwd) {
		App.showError('请输入密码');
		return false
	}
    App._post_form('recharge.card/submit', {
      uname: uname,
      passwd: passwd,
	  type: 2
    }, function(result) {
      App.showSuccess(result.msg);
    });
  },

});