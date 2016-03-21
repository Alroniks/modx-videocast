VideoCast.grid.Videos = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'videocast-grid-videos'
    });

    VideoCast.grid.Videos.superclass.constructor.call(this, config);
};

Ext.extend(VideoCast.grid.Videos, MODx.grid.Grid, {
    windows: {}


});
Ext.reg('videocast-grid-videos', VideoCast.grid.Videos);
