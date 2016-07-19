VideoCast.grid.Channels = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'vc-grid-channels'
    });

    VideoCast.grid.Channels.superclass.constructor.call(this, config);
};

Ext.extend(VideoCast.grid.Channels, VideoCast.grid.Default, {
    windows: {}

});
Ext.reg('vc-grid-channels', VideoCast.grid.Channels);
