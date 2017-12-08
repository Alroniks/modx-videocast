VideoCast.combo.VideoTypes = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        store: new Ext.data.SimpleStore({
            fields: ['key', 'caption'],
            data: [
                ['showed', _('vc_videos_filter_type_showed')],
                ['hidden', _('vc_videos_filter_type_hidden')],
                ['closed', _('vc_videos_filter_type_closed')],
                ['shared', _('vc_videos_filter_type_shared')]
            ]
        }),
        name: 'videotypes',
        hiddenName: 'videotypes',
        displayField: 'caption',
        valueField: 'key',
        mode: 'local',
        triggerAction: 'all',
        editable: false,
        selectOnFocus: false,
        preventRender: true
    });

    VideoCast.combo.VideoTypes.superclass.constructor.call(this, config);
};

Ext.extend(VideoCast.combo.VideoTypes, MODx.combo.ComboBox);
Ext.reg('vc-combo-video-types', VideoCast.combo.VideoTypes);
