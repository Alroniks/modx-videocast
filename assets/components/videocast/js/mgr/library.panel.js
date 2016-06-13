VideoCast.panel.Library = function (config) {
    config = config || {};

    Ext.apply(config, {
        cls: 'container',
        items: [{
            xtype: 'modx-tabs',
            items: [
                /*{
                title: _('vc_videos_tab_title'),
                layout: 'anchor'
                // items: [{
                //     xtype: 'vc-grid-videos',
                //     id: 'vc-grid-videos'
                // }]
            }, */{
                title: _('vc_collections_tab_title'),
                layout: 'anchor',
                items: [{
                    xtype: 'vc-grid-collections',
                    id: 'vc-grid-collections'
                }]
            }, {
                title: _('vc_courses_tab_title'),
                layout: 'anchor'
            }]
        }]
    });

    VideoCast.panel.Library.superclass.constructor.call(this, config);
};
Ext.extend(VideoCast.panel.Library, MODx.Panel);
Ext.reg('vc-panel-library', VideoCast.panel.Library);
