VideoCast.window.Video = function (config) {
    config = config || { new: false };

    Ext.applyIf(config, {
        modal: false,
        width: 800,
        baseParams: {
            action: config.action || 'mgr/videos/' + (config.new ? 'create' : 'update')
        },
        cls: 'vc-window video'
    });

    VideoCast.window.Video.superclass.constructor.call(this, config);
};

Ext.extend(VideoCast.window.Video, VideoCast.window.Default, {

    getMetaDataFromVimeo: function getMetaDataFromVimeo() {

        var video = this.getValue();

        MODx.Ajax.request({
            url: VideoCast.config['url.assets.connector'],
            params: {
                action: 'mgr/videos/fetch',
                video: video
            },
            listeners: {
                success: {
                    fn: function () {
                        console.log('dsdsafsdf');
                    }, scope: this
                }
            }
        });
    },

    getLeftColumn: function getLeftColumn(config) {
        return {
            columnWidth: .7,
            layout: 'form',
            items: [{
                layout: 'column',
                items: [{
                    columnWidth: 1,
                    layout: 'form',
                    items: [{
                        xtype: 'trigger',
                        name: 'source',
                        fieldLabel: _('vc_videos_field_source'),
                        emptyText: '12345678',
                        anchor: '100%',
                        triggerConfig: {
                            html: _('vc_videos_field_source_fetch'),
                            cls: 'x-form-trigger fetcher'
                        },
                        onTriggerClick: this.getMetaDataFromVimeo
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
                        name: 'title',
                        fieldLabel: _('vc_videos_field_title'),
                        anchor: '100%'
                    }]
                }, {
                    columnWidth: .4,
                    layout: 'form',
                    items: [{
                        xtype: 'vc-combo-collections',
                        name: 'collection',
                        fieldLabel: _('vc_videos_field_collection'),
                        emptyText: _('vc_videos_field_collection_empty'),
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
                        fieldLabel: _('vc_videos_field_alias'),
                        disabled: !config.new,
                        anchor: '100%'
                    }]
                }, {
                    columnWidth: .4,
                    layout: 'form',
                    items: [{
                        xtype: 'datefield',
                        name: 'publishedon',
                        fieldLabel: _('vc_videos_field_publishedon'),
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
                        fieldLabel: _('vc_videos_field_duration'),
                        disabled: true,
                        anchor: '100%',
                        listeners: {
                            render: function () {
                                // добавить мутатор для рисования правильного человеческого значения
                            }
                        }
                    }]
                }, {
                    columnWidth: .3,
                    layout: 'form',
                    items: [{
                        xtype: 'xcheckbox',
                        name: 'hidden',
                        fieldLabel: _('vc_videos_field_hidden'),
                        anchor: '100%'
                    }]
                }, {
                    columnWidth: .3,
                    layout: 'form',
                    items: [{
                        xtype: 'xcheckbox',
                        name: 'free',
                        fieldLabel: _('vc_videos_field_free'),
                        anchor: '100%'
                    }]
                }]
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
                fieldLabel: _('vc_videos_field_cover'),
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
                    label: _('vc_videos_field_preview')
                }),
                cls: 'x-form-item'
            }, new Ext.Component({
                autoEl: {
                    tag: 'img',
                    src: 'https://dummyimage.com/216x135/eeeeee/ffffff&text=cl',
                    class: 'cover-preview',
                    id: 'cover-preview'
                }
            })]
        }
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
            items: [{
                xtype: 'textarea',
                name: 'description',
                fieldLabel: _('vc_videos_field_description'),
                anchor: '100%'
            }]
        }];
    }

});

Ext.reg('vc-window-video', VideoCast.window.Video);
