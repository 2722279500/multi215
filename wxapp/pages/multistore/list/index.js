const App = getApp();

Page({
  data: {
    searchValue: '',
    page: 1,
    count: 10,
    lastPage: 0,
    storeList: []
  },

  onLoad: function(options) {
    this.getStore(this.data.page);
  },

  onShow: function() {},

  getSearchContent: function(e) {
    console.log(e.detail.value);
    this.data.searchValue = e.detail.value;
  },

  getStore: function(p) {
    let t = this,
      data = t.data,
      storeList = data.storeList;

    App._post_form('supplier/getSupplierList', {
      page: p,
      count: data.count,
    }, res => {

      if (res.data.length > 0) {

        if (res.data.length < data.count) {
          t.setData({
            lastPage: 1
          });
        };

        t.setData({
          storeList: storeList.concat(res.data)
        });

      };

    });
  },

  search: function() {
    console.log('你点击了搜索');
  },

  onReachBottom() {

    let t = this,
      data = t.data;

    if (!data.lastPage) {
      data.page += 1;
      t.getStore(data.page);
    };

  },

  onShareAppMessage() {
    let _this = this;
    return {
      title: _this.data.templet.share_title,
      path: '/pages/multistore/list/index?' + App.getShareUrlParams()
    };
  }
})