const App = getApp();

Page({
  data: {
    searchColor: "rgba(0,0,0,0.4)",
    searchSize: "15",
    searchName: "搜索的城市",
    list: []
  },

  onLoad() {
    let _this = this;
    let pages = getCurrentPages();
    if (pages.length) {
      let currentPage = pages[pages.length - 2];
      let city = currentPage.data.city;
      _this.citrixGetCityList(city);
    }
  },

  /**
   * 获取多商户列表中所有的城市
   */
  citrixGetCityList: function(c) {
    let _this = this;
    App._post_form('ccity/getCityList', {}, res => {
      _this.setData({
        list: res.data
      });
    });
  },

  /**
   * 跳转到首页把城市id与name带过去
   */
  citrixTargetIndex(e) {
    wx.reLaunch({
      url: '/pages/index/index?city_id=' + e.currentTarget.dataset.id + '&city_name=' + e.currentTarget.dataset.name
    });
  },
  onShareAppMessage() {
    let _this = this;
    return {
      title: _this.data.templet.share_title,
      path: '/pages/multistore/city/index?' + App.getShareUrlParams()
    };
  }

});