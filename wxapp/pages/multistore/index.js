const App = getApp();

Page({
  data: {
    page: 1,
    count: 10,
    lastPage: 0,
    list: []
  },

  onLoad: function(ops) {
    this.setData({
      supplier_id: ops.id
    });
    this.getDetail();
    this.getList(this.data.page);
  },

  onShow: function() {

  },

  getDetail: function() {
    let t = this;
    App._post_form('supplier/getSupplierInfo', {
      supplier_id: t.data.supplier_id
    }, res => {

      console.log(res.data);
      t.setData({
        info: res.data
      });
    });
  },

  getList: function(p) {
    let t = this,
      data = t.data,
      list = data.list;

    App._post_form('supplier/getSupplierGoodsList', {
      page: p,
      count: data.count,
      is_autarky: 1,
      supplier_id: data.supplier_id
    }, res => {

      if (res.data.length > 0) {

        if (res.data.length < data.count) {
          t.setData({
            lastPage: 1
          });
        };

        t.setData({
          list: list.concat(res.data)
        });
      };

    });
  },

  onReachBottom() {
    let t = this,
      data = t.data;

    if (!data.lastPage) {
      data.page += 1;
      t.getList(data.page);
    };

  },

  onShareAppMessage() {
    let _this = this;
    return {
      title: _this.data.templet.share_title,
      path: '/pages/multistore/index?' + App.getShareUrlParams()
    };
  }
})