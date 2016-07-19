VideoCast.combo.Videos = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        xtype: 'superboxselect',
        allowBlank: true,
        msgTarget: 'under',
        allowAddNewData: true,
        addNewDataOnBlur: true,
        pinList: false,
        resizable: true,
        name: config.name || 'videos',
        anchor: '100%',
        minChars: 1,
        mode: 'remote',
        displayField: 'title',
        valueField: 'id',
        triggerAction: 'all',
        extraItemCls: 'x-tag',
        expandBtnCls: 'x-form-trigger',
        clearBtnCls: 'x-form-trigger',
        store: new Ext.data.JsonStore({
            id: (config.name || 'videos') + '-store',
            root: 'results',
            autoLoad: false,
            autoSave: false,
            totalProperty: 'total',
            fields: ['id', 'title'],
            url: VideoCast.config['url.assets.connector'],
            baseParams: {
                action: 'mgr/videos/getlist',
                combo: true
            }
        })
    });

    VideoCast.combo.Videos.superclass.constructor.call(this, config);
};

Ext.extend(VideoCast.combo.Videos, Ext.ux.form.SuperBoxSelect);
Ext.reg('vc-combo-videos', VideoCast.combo.Videos);
