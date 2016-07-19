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
        pageSize: 5,
        cls: 'main-wrapper vc-grid video'
    });

    VideoCast.grid.Videos.superclass.constructor.call(this, config);
};

Ext.extend(VideoCast.grid.Videos, VideoCast.grid.Default, {

    getFields: function getFields() {
        return [
            'id', 'title', 'alias', 'description', 'cover', 'source', 'duration', 'plays',
            'free', 'hidden', 'publishedon', 'collection', 'collection_title', 'preview'
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
            width: 170
        }, {
            id: 'description',
            header: _('vc_videos_column_description'),
            dataIndex: 'title',
            renderer: this.descriptionRenderer.createDelegate(this, [this], true)
        }, {
            id: 'details',
            header: _('vc_videos_column_details'),
            dataIndex: 'alias',
            renderer: this.detailsRenderer.createDelegate(this, [this], true)
        }];
    },

    getMenu: function getMenu() {
        var menu = [];
        menu.push({
            text: _('vc_videos_menu_edit'),
            handler: this.updateVideo
        }, {
            text: 'Обновить статистику (lex)',
            handler: this.updatePlays
        });

        this.addContextMenuItem(menu);
    },
    
    getTopBar: function getTopBar() {
        var topBar = VideoCast.grid.Videos.superclass.getTopBar.call(this);

        var buttons = {
            'mp4': {
                'icon': 'apple',

            },
            'youtube': {},
            'vimeo': {},
            'hls': {}
        };

        //console.log(MODx.config.vc_) // plugins


        topBar.unshift({
            text: '<i class="icon icon-large icon-apple"></i>&nbsp;&nbsp;&nbsp; HLS',
            handler: this.addVideo,
            scope: this
        });

        topBar.unshift({
            text: '<i class="icon icon-large icon-youtube"></i>&nbsp;&nbsp;&nbsp; YouTube',
            handler: this.addVideo,
            scope: this
        });

        topBar.unshift({
            text: '<i class="icon icon-large icon-vimeo"></i>&nbsp;&nbsp;&nbsp; Vimeo',
            handler: this.addVideo,
            scope: this
        });

        topBar.unshift({
            text: '<i class="icon icon-large icon-film"></i>&nbsp;&nbsp;&nbsp;' + 'MP4',
            handler: this.addVideo,
            scope: this
        });
        
        return topBar;
    },

    addMP4Video: function addMP4Video() {
        this.addVideo(params);
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
                    fn: function (response) {
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
            ? '<span class="visibility hidden">' + _('vc_videos_visibility_hidden') + '</span>'
            : '<span class="visibility active">' + _('vc_videos_visibility_active') + '</span>';

        record.data.availability = record.data.free
            ? '<span class="availability free">' + _('vc_videos_availability_free') + '</span>'
            : '<span class="availability paid">' + _('vc_videos_availability_paid') + '</span>';

        var tpl =
            '<div class="description">' +
            '<h2>{title}</h2>' +
            '<h4>{collection_title}</h4>' +
            '<p>{visibility} {availability}</p>' +
            '<h3>.../{alias}</h3>' +
            '<p>{description}</p>' +
            '</div>';

        return new Ext.XTemplate(tpl).applyTemplate(record.data);
    },

    detailsRenderer: function detailsRenderer(value, metaData, record) {
        var publishedon = new Date(record.data.publishedon),
            pubdate = {
                rtime: publishedon.toISOString(),
                htime: publishedon.format(MODx.config.manager_date_format + ' ' + MODx.config.manager_time_format)
            };

        record.data.duration = record.data.duration || 0;

        var h = ('0' + Math.floor(record.data.duration / 3600)).slice(-2),
            m = ('0' + Math.floor(record.data.duration / 60) % 60).slice(-2),
            s = ('0' + record.data.duration % 60).slice(-2);

        var tpl =
            '<div class="details">' +
            '<p class="plays"><strong>{plays} <small>' + _('vc_videos_grid_plays') + '</small></strong></p>' +
            '<p class="duration"><strong>{duration} <small>' + _('vc_videos_grid_seconds') + '</small></strong>' +
            '<br><span>' + [h , m, s].join(':') + '</span>' +
            '<p class="publishedon">' + _('vc_videos_grid_publishedon', pubdate) + '</p>' +
            '<i class="icon icon-large icon-youtube"></i>' +
            '</div>';

        return new Ext.XTemplate(tpl).applyTemplate(record.data);
    }

});

Ext.reg('vc-grid-videos', VideoCast.grid.Videos);
