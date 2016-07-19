VideoCast.combo.Resources = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        name: 'resource',
        hiddenName: 'resource',
        displayField: 'pagetitle',
        valueField: 'id',
        fields: ['id', 'pagetitle'],
        pageSize: 20,
        typeAhead: true,
        preselectValue: false,
        value: 0,
        editable: true,
        hideMode: 'offsets',
        url: '/connectors/index.php',
        baseParams: {
            action: 'resource/getlist',
            combo: true
        }
    });

    VideoCast.combo.Resources.superclass.constructor.call(this, config);
};

Ext.extend(VideoCast.combo.Resources, MODx.combo.ComboBox);
Ext.reg('vc-combo-resources', VideoCast.combo.Resources);
