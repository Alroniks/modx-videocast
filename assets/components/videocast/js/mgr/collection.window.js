VideoCast.window.Collection = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: 'Новая коллекция',
        width: 700,
        baseParams: {
            action: config.action || 'mgr/fgd'
        },
        modal: false
    });

    VideoCast.window.Collection.superclass.constructor.call(this, config);

    // this.on('afterrender', function() {
    //     MODx.loadRTE
    //     MODx.loadRTE('vc-desc-col');
    // }, this);
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
                    name: 'user_id',
                    fieldLabel: 'Название коллекции',
                    anchor: '100%'
                },{
                    xtype: 'textfield',
                    name: 'user_id',
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
                            xtype: 'textfield',
                            name: 'user_id',
                            fieldLabel: 'Позиция',
                            anchor: '100%'
                        }]
                    }, {
                        columnWidth: .3,
                        layout: 'form',
                        items: [{
                            xtype: 'datefield',
                            name: 'user_id',
                            fieldLabel: 'Дата публикации',
                            anchor: '100%'
                        }]
                    }, {
                        columnWidth: .3,
                        layout: 'form',
                        items: [{
                            xtype: 'checkbox',
                            name: 'user_id',
                            label: 'sdfsdf',
                            fieldLabel: 'Не показывать',
                            anchor: '100%'
                        }]
                    }]
                }]
            }, {
                columnWidth: .3,
                layout: 'form',
                items: [{
                    xtype: 'textfield',
                    name: 'image',
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
                name: 'desc',
                fieldLabel: 'Описание',
                anchor: '100%'
            }]
        }];
    }

});

Ext.reg('vc-window-collection', VideoCast.window.Collection);


// нужно написать роад мап с версиями и выпустить первую базову версию сначала
