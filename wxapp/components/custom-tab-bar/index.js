const App = getApp();
Component({
  lifetimes: {
    attached: function () {
      wx.hideTabBar();
      this.getTab();
    },
    ready: function () {
      this.setData({
        selected: App.globalData.selectedIndex
      });
    }
  },
  
  data: {
    selected: 0,
    color: "#6e6d6b",
    selectedColor: "#fd4a5f",
    borderStyle: "black",
    backgroundColor: "#ffffff",
    items: []
  },
  methods: {
    switchTab(e) {
      const data = e.currentTarget.dataset;
      const url = data.path;
      App.navigationTo(url);
      App.globalData.selectedIndex = data.index;
    },
    getTab(){
      let _this = this;
      App._get('page/nav', {}, function(res) {
        const items = res.data.items;
        _this.setData({items})
      });
    }
  }
})