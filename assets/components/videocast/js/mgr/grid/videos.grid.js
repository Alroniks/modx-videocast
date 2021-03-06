VideoCast.grid.Videos = function (config) {
    config = config || {};
    config.id = config.id || 'vc-grid-videos';

    this.cm = new Ext.grid.ColumnModel({
        columns: this.getColumns()
    });

    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/videos/getlist',
            sort: 'id',
            dir: 'ASC'
        },
        cm: this.cm,
        stripeRows: false,
        pageSize: 10,
        cls: 'main-wrapper vc-grid video'
    });

    VideoCast.grid.Videos.superclass.constructor.call(this, config);
};

Ext.extend(VideoCast.grid.Videos, VideoCast.grid.Default, {

    getFields: function getFields() {
        return [
            'id', 'title', 'alias', 'description', 'cover', 'source', 'duration', 'language',
            'free', 'hidden', 'publishedon', 'collection', 'collection_title', 'preview', 'password'
        ];
    },
    
    getColumns: function getColumns() {
        return [{
            id: 'cover',
            header: _('vc_videos_column_cover'),
            dataIndex: 'cover',
            renderer: this.coverRenderer.createDelegate(this, [this], true),
            fixed: true,
            resizable: false,
            width: 130
        }, {
            id: 'title',
            header: _('vc_videos_column_title'),
            dataIndex: 'title',
            renderer: this.descriptionRenderer.createDelegate(this, [this], true),
            width: 45
        }, {
            id: 'language',
            header: _('vc_videos_column_language'),
            dataIndex: 'language',
            renderer: this.languageRenderer.createDelegate(this, [this], true),
            width: 7
        }, {
            id: 'duration',
            header: _('vc_videos_column_duration'),
            dataIndex: 'duration',
            renderer: this.durationRenderer.createDelegate(this, [this], true),
            width: 15
        }];
    },

    getMenu: function getMenu(grid, index) {
        var menu = [],
            record = grid.getStore().data.items[index].data;

        menu.push({
            text: '<i class="x-menu-item-icon icon icon-li icon-edit"></i> ' + _('vc_videos_menu_edit'),
            handler: this.updateVideo
        });
        
        var visibility = record.hidden
            ? { handler: this.show,
                text: '<i class="x-menu-item-icon icon icon-li icon-eye"></i> ' + _('vc_videos_menu_show') }
            : { handler: this.hide,
                text: '<i class="x-menu-item-icon icon icon-li icon-eye-slash"></i> ' +  _('vc_videos_menu_hide')};

        var privacy = record.free
            ? { handler: this.close,
                text: '<i class="x-menu-item-icon icon icon-li icon-lock"></i> ' + _('vc_videos_menu_close')}
            : { handler: this.share,
                text: '<i class="x-menu-item-icon icon icon-li icon-globe"></i> ' + _('vc_videos_menu_share')};

        menu.push(visibility, privacy);

        this.addContextMenuItem(menu);
    },
    
    getTopBar: function getTopBar() {
        var topBar = VideoCast.grid.Videos.superclass.getTopBar.call(this);

        topBar.unshift({
            text: '<i class="icon icon-large icon-video-camera"></i>&nbsp;&nbsp;&nbsp;' + _('vc_videos_add_video'),
            handler: this.addVideo,
            scope: this
        });
        
        return topBar;
    },

    getSearch: function getSearch() {
        return [{
            xtype: 'modx-combo-language',
            emptyText: _('language'),
            width: 100
        }, {
            xtype: 'vc-combo-collections',
            emptyText: _('vc_videos_filter_collection'),
            width: 120
        }, {
            xtype: 'vc-combo-video-types',
            emptyText: _('vc_videos_filter_type'),
            width: 120
        }, {
            xtype: 'textfield',
            emptyText: _('search'),
            width: 100,
            listeners: {
                render: {
                    fn: function (cmp) {
                        new Ext.KeyMap(cmp.getEl(), {
                            key: Ext.EventObject.ENTER,
                            fn: this.blur,
                            scope: cmp
                        });
                    }, scope: this
                },
                change: {
                    fn: function (field) {
                        this.search(field)
                    }, scope: this
                }
            }
        }, {
            xtype: 'button',
            text: '<i class="icon icon-large icon-trash-o"></i>',
            handler: this.clear,
            scope: this
        }];
    },
    
    addVideo: function addVideo() {
        MODx.load({
            xtype: 'vc-window-video',
            title: _('vc_videos_window_title_new'),
            grid: this,
            new: true,
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        }).show();
    },

    updateVideo: function updateVideo(btn, e) {

        var record = this.menu.record;
        record.publishedon = (new Date(record.publishedon)).format(MODx.config.manager_date_format || 'd-m-Y');

        var window = MODx.load({
            xtype: 'vc-window-video',
            title: _('vc_videos_window_title_update', [record.title]),
            record: record,
            grid: this,
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
                    }, scope: this
                }
            }
        });

        window.reset();
        window.setValues(record);
        window.show(e.target);
    },

    show: function show() { this.updateFlags('hidden', false); },
    hide: function hide() { this.updateFlags('hidden', true); },
    share: function share() { this.updateFlags('free', true); },
    close: function close() { this.updateFlags('free', false); },

    updateFlags: function updateFlags(flag, value) {
        var params = {
            action: 'mgr/videos/update',
            id: this.menu.record.id
        };

        if (this.menu.record.hasOwnProperty(flag)) {
            params[flag] = value;
        }

        MODx.Ajax.request({
            url: VideoCast.config['url.assets.connector'],
            params: params,
            listeners: {
                success: {
                    fn: function () {
                        this.refresh();
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

    descriptionRenderer: function descriptionRenderer(value, metaData, record) {

        record.data.visibility = record.data.hidden
            ? '<span class="visibility covert">' + _('vc_status_visibility_hidden') + '</span>'
            : '<span class="visibility active">' + _('vc_status_visibility_active') + '</span>';

        record.data.availability = record.data.free
            ? '<span class="availability free">' + _('vc_videos_availability_free') + '</span>'
            : '<span class="availability paid">' + _('vc_videos_availability_private') + '</span>';

        record.data.publishedoncustom =
            '<span class="publishedon">' +
            (new Date(record.data.publishedon)).format(MODx.config.manager_date_format || 'd-m-Y') +
            '</span>';

        var tpl =
            '<div class="description">' +
            '<h2>{title}</h2>' +
            '<p>{publishedoncustom} {visibility} {availability}</p>' +
            '<p><small>' + _('source') + ': {source}</small></p>' +
            '</div>';

        return new Ext.XTemplate(tpl).applyTemplate(record.data);
    },

    durationRenderer: function durationRenderer(value, metaData, record) {
        record.data.duration = record.data.duration || 0;
        var h = ('0' + Math.floor(record.data.duration / 3600)).slice(-2),
            m = ('0' + Math.floor(record.data.duration / 60) % 60).slice(-2),
            s = ('0' + record.data.duration % 60).slice(-2);

        var tpl =
            '<div class="duration">' +
            '<p class="human">' + [h , m, s].join(':') + '</p>' +
            '</div>';

        return new Ext.XTemplate(tpl).applyTemplate(record.data);
    },

    languageRenderer: function languageRenderer(value, metaData, record) {
        var tpl =
            '<div class="language">' +
            record.data.language +
            '</div>';

        return new Ext.XTemplate(tpl).applyTemplate(record.data);
    }

});

Ext.reg('vc-grid-videos', VideoCast.grid.Videos);
