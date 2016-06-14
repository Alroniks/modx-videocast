VideoCast.window.Collection = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: _('vc_collections_window_title_new'),
        width: 700,
        fileUpload: true,
        baseParams: {
            action: config.action || 'mgr/collections/create'
        },
        modal: false,
        cls: 'collection window'
    });

    VideoCast.window.Collection.superclass.constructor.call(this, config);
};

Ext.extend(VideoCast.window.Collection, VideoCast.window.Default, {

    getLeftColumn: function getLeftColumn() {
        return {
            columnWidth: .7,
            layout: 'form',
            items: [{
                xtype: 'textfield',
                name: 'title',
                fieldLabel: 'Название коллекции',
                anchor: '100%'
            }, {
                xtype: 'textfield',
                name: 'alias',
                fieldLabel: 'Ссылка на коллекцию',
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
                        fieldLabel: 'Позиция',
                        anchor: '100%'
                    }]
                }, {
                    columnWidth: .3,
                    layout: 'form',
                    items: [{
                        xtype: 'datefield',
                        name: 'publishedon',
                        fieldLabel: 'Дата публикации',
                        emptyText: '',
                        format: MODx.config['manager_date_format'] || 'Y-m-d',
                        anchor: '100%'
                    }]
                }, {
                    columnWidth: .3,
                    layout: 'form',
                    items: [{
                        xtype: 'checkbox',
                        name: 'hidden',
                        label: 'Не показывать',
                        fieldLabel: 'Не показывать',
                        anchor: '100%'
                    }]
                }]
            }]
        };
    },

    getRightColumn: function getRightColumn() {

        var previewTpl = '' +
            '<div class="x-form-item">' +
                '<label class="x-form-item-label">{label}</label>' +
                '<div class="x-form-element">' +
                    '<div class="x-form-field-wrap x-form-field-trigger-wrap">{image}</div>' +
                '</div>' +
                '<div class="x-form-clear-left"></div>' +
            '</div>';

        return {
            columnWidth: .3,
            layout: 'form',
            items: [
                {
                    xtype: 'modx-combo-browser',
                    name: 'cover',
                    fieldLabel: 'Обложка',
                    anchor: '100%'
                },
                new Ext.XTemplate(previewTpl).applyTemplate({
                    label: 'Cover Preview',
                    image: 'img'
                })
            ]

            // , new Ext.Component(
            //     {
            //         autoEl: { tag: 'p', html: 'sadfasdfadf' }
            //     }
            // ), new Ext.Component(
            //     {
            //         autoEl: { tag: 'img', src: 'http://dummyimage.com/300x300/eeeeee/ffffff&text=cl', id: 'preview', class: 'cover-preview' }
            //     }
            // )]
        };
    },

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id'
        }, {
            layout: 'column',
            defaults: { msgTarget: 'under', border: false },
            items: [this.getLeftColumn(), this.getRightColumn()]
        }, {
            layout: 'form',
            style: 'margin-top: 15px',
            items: [{
                xtype: 'textarea',
                name: 'description',
                fieldLabel: 'Описание',
                anchor: '100%'
            }]
        }];
    }

});

Ext.reg('vc-window-collection', VideoCast.window.Collection);
