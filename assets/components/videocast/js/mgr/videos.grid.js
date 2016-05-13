VideoCast.grid.Videos = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'vc-grid-videos'
    });

    VideoCast.grid.Videos.superclass.constructor.call(this, config);
};

Ext.extend(VideoCast.grid.Videos, VideoCast.grid.Default, {
    windows: {}
});
Ext.reg('vc-grid-videos', VideoCast.grid.Videos);
