VideoCast.panel.Videos = function (config) {
    config = config || {};

    Ext.apply(config, {
        cls: 'container',
        items: [{
            xtype: 'modx-tabs',
            items: [{
                //title: _('videos'),
                title: 'Видеогалерея',
                layout: 'anchor',
                items: [{
                    html: 'asdfsdfsd'
                }]
            }]
        }]
    });

    VideoCast.panel.Videos.superclass.constructor.call(this, config);
};
Ext.extend(VideoCast.panel.Videos, MODx.Panel);
Ext.reg('videocast-panel-videos', VideoCast.panel.Videos);
