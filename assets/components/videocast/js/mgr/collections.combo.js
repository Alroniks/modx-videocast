VideoCast.combo.Collections = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        name: config.name || 'collections',
        fieldLabel: config.fieldLabel || 'Collections',
        hiddenName: config.name || 'collections',
        displayField: 'title',
        valueField: 'id',
        fields: ['title', 'id'],
        anchor: '99%',
        pageSize: 20,
        typeAhead: true,
        editable: true,
        allowBlank: true,
        emptyText: _('no'),
        url: VideoCast.config['url.assets.connector'],
        baseParams: {
            action: 'mgr/collections/getlist',
            combo: true,
            id: config.value
        }
    });

    VideoCast.combo.Collections.superclass.constructor.call(this, config);
};

Ext.extend(VideoCast.combo.Collections, MODx.combo.ComboBox);

Ext.reg('vc-combo-collections', VideoCast.combo.Collections);
