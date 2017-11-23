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
            'id', 'title', 'alias', 'description', 'cover', 'source', 'duration', 'plays',
            'free', 'hidden', 'publishedon', 'collection', 'collection_title', 'preview', 'type'
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
            width: 100
        }, {
            id: 'description',
            header: _('vc_videos_column_title'),
            dataIndex: 'title',
            renderer: this.descriptionRenderer.createDelegate(this, [this], true)
        }, {
            id: 'language',
            header: ('lang'),
            dataIndex: 'language',
            width: 10
        }, {
            id: 'duration',
            header: _('vc_videos_column_duration'),
            dataIndex: 'duration',
            renderer: this.durationRenderer.createDelegate(this, [this], true),
            width: 15
        }, {
            id: 'publishedon',
            header: _('vc_videos_column_publishedon'),
            dataIndex: 'publishedon',
            // renderer: this.publishedRenderer.createDelegate(this, [this], true)
            width: 15
        }, {
            id: 'plays',
            header: _('vc_videos_column_statistics'),
            dataIndex: 'plays',
            renderer: this.detailsRenderer.createDelegate(this, [this], true),
            width: 20
        }];
    },

    getMenu: function getMenu() {
        var menu = [];
        menu.push({
            text: '<i class="x-menu-item-icon icon icon-li icon-edit"></i> ' + _('vc_videos_menu_edit'),
            handler: this.updateVideo
        }, {
            text: '<span><i class="x-menu-item-icon icon icon-li icon-refresh"></i> Обновить статистику (lex)</span>',
            handler: this.updatePlays
        }, {
            text: 'Скрыть с сайта / Показать на сайте'
        }, '-', {
            text: 'Удалить'
        }, {
            text: 'Сделать приватным / Открыть для всех'
        });

        this.addContextMenuItem(menu);
    },
    
    getTopBar: function getTopBar() {
        var topBar = VideoCast.grid.Videos.superclass.getTopBar.call(this);

        var plugins = MODx.config.videocast_plugins.split(',').reverse();

        var buttonsMap = {
            mp4: { icon: 'film', handler: this.addMP4Video },
            youtube: { icon: 'youtube', handler: this.addYouTubeVideo },
            vimeo: { icon: 'vimeo', handler: this.addVimeoVideo },
            hls: { icon: 'apple', handler: this.addHLSVideo }
        };

        for (var key in plugins) {
            if (!plugins.hasOwnProperty(key)) {
                continue;
            }
            var plugin = plugins[key];
            if (buttonsMap.hasOwnProperty(plugin)) {
                topBar.unshift({
                    text: '<i class="icon icon-large icon-' + buttonsMap[plugin].icon + '"></i>&nbsp;&nbsp;&nbsp;' + _('vc_videos_add_' + plugin),
                    handler: buttonsMap[plugin].handler,
                    scope: this
                });
            }
        }
        
        return topBar;
    },

    addMP4Video: function addMP4Video() {
        this.addVideo('mp4');
    },

    addVimeoVideo: function addVimeoVideo() {
        this.addVideo('vimeo');
    },

    addYouTubeVideo: function addYouTubeVideo() {
        this.addVideo('youtube');
    },

    addHLSVideo: function addHLSVideo() {
        this.addVideo('hls');
    },
    
    addVideo: function addVideo(plugin) {
        MODx.load({
            xtype: 'vc-window-video',
            title: _('vc_videos_window_title_new'),
            grid: this,
            new: true,
            plugin: plugin,
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
            plugin: record.type,
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
    
    updatePlays: function updatePlays(btn, e) {
        
        var record = this.menu.record;
        
        MODx.Ajax.request({
            url: VideoCast.config['url.assets.connector'],
            params: {
                action: 'mgr/videos/plays',
                video: record.id,
                source: record.source
            },
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
            ? '<span class="visibility hidden">' + _('vc_status_visibility_hidden') + '</span>'
            : '<span class="visibility active">' + _('vc_status_visibility_active') + '</span>';

        record.data.availability = record.data.free
            ? '<span class="availability free">' + _('vc_videos_availability_free') + '</span>'
            : '<span class="availability paid">' + _('vc_videos_availability_private') + '</span>';

        var tpl =
            '<div class="description">' +
            '<h2>{title}</h2>' +
            '<p>{visibility} {availability}</p>' +
            '</div>';

        return new Ext.XTemplate(tpl).applyTemplate(record.data);
    },

    durationRenderer: function durationRenderer(value, metaData, record) {
        record.data.duration = record.data.duration || 0;
        var h = ('0' + Math.floor(record.data.duration / 3600)).slice(-2),
            m = ('0' + Math.floor(record.data.duration / 60) % 60).slice(-2),
            s = ('0' + record.data.duration % 60).slice(-2);

        record.data.duration = Ext.util.Format.declension(
            record.data.duration,
            _('vc_videos_grid_seconds').split('|')
        );

        var tpl =
            '<div class="duration">' +
            '<p class="human">' + [h , m, s].join(':') + '</p>' +
            '<p class="seconds">{duration}</p>' +
            '</div>';

        return new Ext.XTemplate(tpl).applyTemplate(record.data);
    },

    publishedRenderer: function publishedRenderer(value, metaData, record) {
        record.data.publishedon = record.data.publishedon || 0;


    },

    detailsRenderer: function detailsRenderer(value, metaData, record) {
        record.data.plays = Ext.util.Format.declension(record.data.plays, _('vc_videos_grid_plays').split('|'));
        var tpl = '<div class="plays">{plays}</div>';
        
        return new Ext.XTemplate(tpl).applyTemplate(record.data);
    }

});

Ext.reg('vc-grid-videos', VideoCast.grid.Videos);
