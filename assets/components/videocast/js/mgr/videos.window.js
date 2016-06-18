VideoCast.window.Video = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        modal: false,
        title: 'create video',
        width: 800,
        baseParams: {
            action: config.action || 'mgr/videos/create'
        },
        cls: 'video window'
    });

    VideoCast.window.Video.superclass.constructor.call(this, config);

    // todo: move to common - def
    this.on('show', function () {
        this.renderPreview(this.record.cover);
    });
};

Ext.extend(VideoCast.window.Video, VideoCast.window.Default, {

    getLeftColumn: function getLeftColumn() {
        return {
            columnWidth: .7,
            layout: 'form',
            items: [{
                layout: 'column',
                items: [{
                    columnWidth: .6,
                    layout: 'form',
                    items: [{
                        xtype: 'textfield',
                        name: 'title',
                        //fieldLabel: _('vc_videos_field_title'),
                        fieldLabel: 'Название видео',
                        anchor: '100%'
                    }]
                }, {
                    columnWidth: .4,
                    layout: 'form',
                    items: [{
                        xtype: 'textfield',
                        name: 'collection',
                        fieldLabel: 'Коллекция',
                        anchor: '100%'
                    }]
                }]
            }, {
                layout: 'column',
                style: 'margin-top: 15px',
                items: [{
                    columnWidth: .6,
                    layout: 'form',
                    items: [{
                        xtype: 'textfield',
                        name: 'alias',
                        //fieldLabel: _('vc_videos_field_alias'),
                        fieldLabel: 'Ссылка',
                        anchor: '100%'
                    }]
                }, {
                    columnWidth: .4,
                    layout: 'form',
                    items: [{
                        xtype: 'datefield',
                        name: 'publishedon',
                        // fieldLabel: _('vc_collections_field_publishedon'),
                        fieldLabel: _('vc_collections_field_publishedon'),
                        format: 'd.m.Y',
                        startDay: 1,
                        anchor: '100%'
                    }]
                }]
            }, {
                layout: 'column',
                style: 'margin-top: 15px',
                items: [{
                    columnWidth: .3,
                    layout: 'form',
                    items: [{
                        xtype: 'numberfield',
                        name: 'duration',
                        //fieldLabel: _('vc_collections_field_rank'),
                        fieldLabel: 'Продолжительность',
                        disabled: true,
                        value: 345,
                        anchor: '100%'
                    }]
                }, {
                    columnWidth: .3,
                    layout: 'form',
                    items: [{
                        xtype: 'checkbox',
                        name: 'hidden',
                        fieldLabel: _('vc_collections_field_hidden'),
                        anchor: '100%'
                    }]
                }, {
                    columnWidth: .3,
                    layout: 'form',
                    items: [{
                        xtype: 'checkbox',
                        name: 'free',
                        fieldLabel: 'FREE',
                        anchor: '100%'
                    }]
                }]
            }, {
                xtype: 'textarea',
                name: 'source',
                fieldLabel: 'Исходник',
                anchor: '100%'
            }]
        }
    },

    getRightColumn: function getRightColumn() {
        return {
            columnWidth: .3,
            layout: 'form',
            items: [{
                xtype: 'modx-combo-browser',
                name: 'cover',
                fieldLabel: _('vc_collections_field_cover'),
                anchor: '100%',
                listeners: {
                    'select': {
                        fn: function (image) {
                            this.renderPreview(image.relativeUrl);
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
        }
    },

    getFields: function () {
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
                fieldLabel: _('vc_collections_field_description'),
                anchor: '100%'
            }]
        }];
    }

});

Ext.reg('vc-window-video', VideoCast.window.Video);
