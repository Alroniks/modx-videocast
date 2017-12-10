VideoCast.window.Video = function (config) {
    config = config || { new: false };

    if (!config.id) {
        config.id = 'vc-window-video';
    }

    Ext.applyIf(config, {
        modal: false,
        width: 820,
        baseParams: {
            action: config.action || 'mgr/videos/' + (config.new ? 'create' : 'update')
        },
        cls: 'vc-window video',
        closeAction: 'close'
    });

    VideoCast.window.Video.superclass.constructor.call(this, config);
};

Ext.extend(VideoCast.window.Video, VideoCast.window.Default, {

    updateFields: function updateFields(data) {
        var form = this.fp.getForm();
        var self = this;

        Ext.MessageBox.confirm(
            _('vc_videos_message_update_title'),
            _('vc_videos_message_update_msg'),
            function (value) {
                if (value === 'yes') {
                    form.items.each(function(field) {
                        if (data.hasOwnProperty(field.name)) {
                            if (!self.config.new && field.name === 'alias') {
                                return;
                            }
                            field.setValue(data[field.name]);
                        }
                    });
                    if (data.hasOwnProperty('cover')) {
                        this.renderPreview(data.cover);
                    }
                }
            }, self
        );
    },

    getMetaData: function getMetaDataFromSource(e, target, object) {
        var w = Ext.getCmp('vc-window-video'), video;

        if (typeof this.getValue === 'function') {
            video = this.getValue();
        } else {
            video = MODx.config.site_url + object.fullRelativeUrl;
        }

        MODx.Ajax.request({
            url: VideoCast.config['url.assets.connector'],
            params: {
                action: 'mgr/videos/' + plugin + '/fetch',
                video: video
            },
            listeners: {
                success: {
                    fn: function (response) {
                        var answer = response.object;
                        w.updateFields(answer);
                    }, scope: this
                },
                failure: {
                    fn: function (response) {
                        MODx.msg.alert(response.message);
                    }, scope: this
                }
            }
        });
    },

    getSourceField: function (name) {

        var field,
            label = _('vc_videos_field_source');

        field = this.getFileField(label, MODx.config['videocast_media_source_mp4'] || MODx.config.default_media_source);

        if (field) {
            field.name = name;
        }

        return field;
    },

    getFileField: function (label, source) {
        return {
            xtype: 'modx-combo-browser',
            fieldLabel: label,
            anchor: '100%',
            source: source,
            listeners: {
                select: {
                    fn: function (file) {
                        this.getMetaData(null, null, file);
                    }, scope: this
                }
            }
        };
    },

    getLeftColumn: function getLeftColumn(config) {
        return {
            columnWidth: .7,
            layout: 'form',
            defaults: { msgTarget: 'under' },
            items: [{
                layout: 'column',
                items: [{
                    columnWidth: 1,
                    layout: 'form',
                    defaults: { msgTarget: 'under' },
                    items: [this.getSourceField('source')]
                }]
            }, {
                layout: 'column',
                style: 'margin-top: 15px',
                items: [{
                    columnWidth: .6,
                    layout: 'form',
                    defaults: { msgTarget: 'under' },
                    items: [{
                        xtype: 'textfield',
                        name: 'title',
                        fieldLabel: _('vc_videos_field_title'),
                        anchor: '100%'
                    }]
                }, {
                    columnWidth: .4,
                    layout: 'form',
                    defaults: { msgTarget: 'under' },
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
                    defaults: { msgTarget: 'under' },
                    items: [{
                        xtype: 'textfield',
                        name: 'alias',
                        fieldLabel: _('vc_videos_field_alias'),
                        readOnly: !config.new,
                        anchor: '100%'
                    }]
                }, {
                    columnWidth: .4,
                    layout: 'form',
                    defaults: { msgTarget: 'under' },
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
                    columnWidth: .25,
                    layout: 'form',
                    defaults: { msgTarget: 'under' },
                    items: [{
                        xtype: 'numberfield',
                        name: 'duration',
                        fieldLabel: _('vc_videos_field_duration'),
                        readOnly: false, // tmp solution, need to fetch real data from files
                        anchor: '100%'
                    }]
                }, {
                    columnWidth: .25,
                    layout: 'form',
                    defaults: { msgTarget: 'under' },
                    items: [{
                        xtype: 'modx-combo-language',
                        name: 'language',
                        fieldLabel: _('vc_videos_field_language'),
                        anchor: '100%',
                        value: MODx.config.manager_language
                    }]
                }, {
                    columnWidth: .25,
                    layout: 'form',
                    defaults: { msgTarget: 'under' },
                    items: [{
                        xtype: 'xcheckbox',
                        name: 'hidden',
                        fieldLabel: _('vc_videos_field_hidden'),
                        anchor: '100%'
                    }]
                }, {
                    columnWidth: .25,
                    layout: 'form',
                    defaults: { msgTarget: 'under' },
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

    getRightColumn: function getRightColumn(config) {
        return {
            columnWidth: .3,
            layout: 'form',
            defaults: { msgTarget: 'under' },
            items: [{
                xtype: 'modx-combo-browser',
                name: 'cover',
                id: config.id + '-cover',
                fieldLabel: _('vc_videos_field_cover'),
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
            xtype: 'modx-tabs',
            defaults: {
                listeners: {
                    activate: function () {
                        if (MODx.loadRTE) {
                            MODx.loadRTE('vc_videos_window_tab_description_editor');
                        }
                    }
                }
            },
            items: [{
                title: _('vc_videos_window_tab_settings'),
                layout: 'column',
                defaults: { msgTarget: 'under', border: false },
                items: [this.getLeftColumn(config), this.getRightColumn(config)]
            }, {
                title: _('vc_videos_window_tab_description'),
                layout: 'form',
                defaults: { msgTarget: 'under', autoHeight: true },
                items: [{
                    id: 'vc_videos_window_tab_description_editor',
                    xtype: 'textarea',
                    name: 'description',
                    anchor: '100%'
                }]
            }]
        }];
    }

});

Ext.reg('vc-window-video', VideoCast.window.Video);
