const App = getApp();

Page({

  data: {
    // 页面参数
    options: {},
    // 页面元素
    items: {},
    scrollTop: 0,
    city: {
      id: 2,
      name: '北京市'
    }
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function(options) {

    // 当前页面参数
    this.setData({
      options
    });


    /** 
     * citrix
     * 如果用户是通过地区选择的城市
     */

    if (options.city_id != undefined && options.city_name != undefined) {
      this.setData({
        city: {
          id: options.city_id,
          name: options.city_name,
        }
      });

      //把城市存储到缓存中去
      try {
        wx.setStorageSync('supplier_city', {
          id: options.city_id,
          name: options.city_name
        })
      } catch (e) {

      }
    }
    //如果用户未选择城市
    else {
      this.citrixGetCity();
    }
    
    // 加载页面数据
    this.getPageData();

  },

  /**
   * 坐标拾取定位城市
   */
  citrixGetCity: function(e) {
    var _this = this;
    wx.getLocation({
      success: function(res) {
        const url = "https://apis.map.qq.com/ws/geocoder/v1/";
        wx.request({
          url,
          data: {
            key: "2QQBZ-XTLWD-FEB4C-HNGIE-CX7T5-OUBKV",
            location: `${res.latitude},${res.longitude}`,
            output: 'json',
          },
          success: function(res) {
            var cCity = res.data.result.address_component.city;
            // 发送城市名称获取城市id
            App._post_form('ccity/cinfo', {
              city: cCity,
            }, (result) => {

              _this.setData({
                city: {
                  id: result.data.id,
                  name: result.data.name,
                }
              });

              //把城市存储到缓存中去
              try {
                wx.setStorageSync('supplier_city', {
                  id: result.data.id,
                  name: result.data.name
                })
              } catch (e) {

              }

              //当前页面数据重新加载
              _this.getPageData();

            });
          }
        })
      },
      fail: function() {
        /**
         * 用户拒绝授权定位
         * 把城市存储到缓存中去
         */
        try {
          wx.setStorageSync('supplier_city', {
            id: _this.data.city.id,
            name: _this.data.city.name
          })
        } catch (e) {

        }

        //当前页面数据重新加载
        _this.getPageData();
      }
    })
  },

  /**
   * 加载页面数据
   */
  getPageData: function(callback) {
    let _this = this;

    App._get('page/index', {
      page_id: _this.data.options.page_id || 0
    }, function(result) {
      // 设置顶部导航栏栏
      _this.setPageBar(result.data.page);
      _this.setData(result.data);
      // 回调函数
      typeof callback === 'function' && callback();
    });
  },

  /**
   * 设置顶部导航栏
   */
  setPageBar: function(page) {
    // 设置页面标题
    wx.setNavigationBarTitle({
      title: page.params.title
    });
    // 设置navbar标题、颜色
    wx.setNavigationBarColor({
      frontColor: page.style.titleTextColor === 'white' ? '#ffffff' : '#000000',
      backgroundColor: page.style.titleBackgroundColor
    })
  },

  /**
   * 分享当前页面
   */
  onShareAppMessage() {
    let _this = this;
    return {
      title: _this.data.page.params.share_title,
      path: "/pages/index/index?" + App.getShareUrlParams()
    };
  },

  /**
   * 下拉刷新
   */
  onPullDownRefresh: function() {
    // 获取首页数据
    this.getPageData(function() {
      wx.stopPullDownRefresh();
    });
  }

  // /**
  //  * 返回顶部
  //  */
  // goTop: function(t) {
  //   this.setData({
  //     scrollTop: 0
  //   });
  // },

  // scroll: function(t) {
  //   this.setData({
  //     indexSearch: t.detail.scrollTop
  //   }), t.detail.scrollTop > 300 ? this.setData({
  //     floorstatus: !0
  //   }) : this.setData({
  //     floorstatus: !1
  //   });
  // },

});