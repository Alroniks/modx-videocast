VideoCast.window.Collection = function (config) {
    config = config || { new: false };

    Ext.applyIf(config, {
        modal: false,
        width: 700,
        baseParams: {
            action: config.action || 'mgr/collections/' + (config.new ? 'create' : 'update')
        },
        cls: 'vc-window collection'
    });

    VideoCast.window.Collection.superclass.constructor.call(this, config);
};

Ext.extend(VideoCast.window.Collection, VideoCast.window.Default, {

    getLeftColumn: function getLeftColumn(config) {
        return {
            columnWidth: .6,
            layout: 'form',
            defaults: { msgTarget: 'under' },
            items: [{
                xtype: 'textfield',
                name: 'title',
                fieldLabel: _('vc_collections_field_title'),
                anchor: '100%'
            }, {
                xtype: 'textfield',
                name: 'alias',
                fieldLabel: _('vc_collections_field_alias'),
                readOnly: !config.new,
                anchor: '100%'
            }, {
                layout: 'column',
                style: 'margin-top: 15px',
                defaults: {
                    msgTarget: 'under',
                    border: false
                },
                items: [{
                    columnWidth: .3,
                    layout: 'form',
                    items: [{
                        xtype: 'numberfield',
                        name: 'rank',
                        fieldLabel: _('vc_collections_field_rank'),
                        anchor: '100%'
                    }]
                }, {
                    columnWidth: .3,
                    layout: 'form',
                    items: [{
                        xtype: 'datefield',
                        name: 'publishedon',
                        fieldLabel: _('vc_collections_field_publishedon'),
                        format: 'd.m.Y',
                        startDay: 1,
                        anchor: '100%'
                    }]
                }, {
                    columnWidth: .3,
                    layout: 'form',
                    items: [{
                        xtype: 'xcheckbox',
                        name: 'hidden',
                        fieldLabel: _('vc_collections_field_hidden'),
                        anchor: '100%'
                    }]
                }]
            }, {
                xtype: 'textarea',
                name: 'description',
                fieldLabel: _('vc_collections_field_description'),
                height: 115,
                anchor: '100%'
            }]
        };
    },

    getRightColumn: function getRightColumn(config) {
        return {
            columnWidth: .4,
            layout: 'form',
            defaults: { msgTarget: 'under' },
            items: [{
                xtype: 'modx-combo-browser',
                name: 'cover',
                id: config.id + '-cover',
                fieldLabel: _('vc_collections_field_cover'),
                anchor: '100%',
                source: MODx.config['videocast_media_source_cover'] || MODx.config.default_media_source,
                listeners: {
                    'select': {
                        fn: function (image) {
                            var coverField = Ext.getCmp(config.id + '-cover');
                            if (coverField) {
                                coverField.setValue(image.fullRelativeUrl);
                            }
                            this.renderPreview(image.fullRelativeUrl);
                        }, scope: this
                    }
                }
            }, {
                html: new Ext.XTemplate('<label class="x-form-item-label">{label}</label>').applyTemplate({
                    label: _('vc_collections_field_preview')
                }),
                cls: 'x-form-item'
            }, new Ext.Component({
                autoEl: {
                    tag: 'img',
                    src: 'http://dummyimage.com/300x300/eeeeee/ffffff&text=cl',
                    class: 'cover-preview',
                    id: 'cover-preview'
                }
            })]
        };
    },

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id'
        }, {
            layout: 'column',
            defaults: { msgTarget: 'under', border: false },
            items: [this.getLeftColumn(config), this.getRightColumn(config)]
        }, {
            layout: 'form',
            style: 'margin-top: 15px',
            defaults: { msgTarget: 'under' },
            items: [{
                html: 'here will be list of videos',
                cls: 'disabled'
            }]
        }];
    }

});

Ext.reg('vc-window-collection', VideoCast.window.Collection);
