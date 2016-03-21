VideoCast.page.Videos = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        components: [{
            xtype: 'videocast-panel-videos',
            renderTo: 'videocast-panel-videos-div'
        }]
    });

    VideoCast.page.Videos.superclass.constructor.call(this, config);
};
Ext.extend(VideoCast.page.Videos, MODx.Component);
Ext.reg('videocast-page-videos', VideoCast.page.Videos);
