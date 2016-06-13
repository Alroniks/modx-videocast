VideoCast.window.Collection = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: 'Новая коллекция', // TODO: lex
        width: 700,
        baseParams: {
            action: config.action || 'mgr/collections/create'
        },
        modal: false
    });

    VideoCast.window.Collection.superclass.constructor.call(this, config);


};

Ext.extend(VideoCast.window.Collection, VideoCast.window.Default, {

    getFields: function (config) {
        return [{
            xtype: 'hidden',
            name: 'id'
        }, {
            layout: 'column',
            defaults: {
                msgTarget: 'under',
                border: false
            },
            items: [{
                columnWidth: .7,
                layout: 'form',
                items: [{
                    xtype: 'textfield',
                    name: 'title',
                    fieldLabel: 'Название коллекции',
                    anchor: '100%'
                },{
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
            }, {
                columnWidth: .3,
                layout: 'form',
                items: [{
                    xtype: 'modx-combo-browser',
                    name: 'cover',
                    fieldLabel: 'Обложка',
                    anchor: '100%'
                }]
                // todo: добавить блок для вывода превью обложки + плагин для ресайзинга картинки с кропом
            }]
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
