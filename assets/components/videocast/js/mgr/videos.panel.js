VideoCast.panel.Videos = function (config) {
    config = config || {};

    Ext.apply(config, {
        border: false,
        deferredRender: true,
        baseCls: 'modx-formpanel',
        item: [{
            html: '<h2> :: fffffff</h2>',
            border: false,
            cls: 'modx-page-header container'
        }]
    });

    VideoCast.panel.Videos.superclass.constructor.call(this, config);
};
Ext.extend(VideoCast.panel.Videos, MODx.Panel);
Ext.reg('videocast-panel-videos', VideoCast.panel.Videos);
