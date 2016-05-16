VideoCast.window.Collection = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: 'title',
        width: 600,
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
                columnWidth: .5,
                layout: 'form',
                items: [{
                    xtype: 'textfield',
                    name: 'user_id',
                    fieldLabel: 'Название коллекции',
                    anchor: '95%'
                },{
                    xtype: 'textfield',
                    name: 'user_id',
                    fieldLabel: 'Ссылка на коллекцию',
                    anchor: '95%'
                }, {
                    layout: 'column',
                    defaults: {},
                    items: [{
                        columnWidth: .5,
                        layout: 'form',
                        items: [{
                            xtype: 'textfield',
                            name: 'user_id',
                            fieldLabel: 'Позиция',
                            anchor: '95%'
                        }]
                    }, {
                        columnWidth: .5,
                        layout: 'form',
                        items: [{
                            xtype: 'textfield',
                            name: 'user_id',
                            fieldLabel: 'Дата публикации',
                            anchor: '95%'
                        }]
                    }]
                }]
            }, {
                columnWidth: .5,
                layout: 'form',
                items: [{
                    xtype: 'textfield',
                    name: 'image',
                    fieldLabel: 'Обложка',
                    anchor: '95%'
                }]
                // todo: добавить блок для вывода превью обложки + плагин для ресайзинга картинки с кропом
            }]
        }, {
            layout: 'form',
            items: [{
                xtype: 'textarea',
                name: 'desc',
                id: 'vc-desc-col'
            }]
        }];
    }

});

Ext.reg('vc-window-collection', VideoCast.window.Collection);


// нужно написать роад мап с версиями и выпустить первую базову версию сначала
