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
        pageSize: 3,
        cls: 'main-wrapper vc-grid video'
    });

    VideoCast.grid.Videos.superclass.constructor.call(this, config);
};

Ext.extend(VideoCast.grid.Videos, VideoCast.grid.Default, {

    getFields: function getFields() {
        return [
            'id', 'title', 'alias', 'description', 'cover', 'source', 'duration',
            'free', 'hidden', 'publishedon', 'collection'
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
        });

        this.addContextMenuItem(menu);
    },
    
    getTopBar: function getTopBar() {
        var topBar = VideoCast.grid.Videos.superclass.getTopBar.call(this);
        
        topBar.unshift({
            text: '<i class="icon icon-large icon-vimeo"></i>&nbsp;&nbsp;&nbsp;' + _('vc_videos_button_new'),
            handler: this.addVideo,
            scope: this
        });
        
        return topBar;
    },
    
    addVideo: function addVideo() {
        MODx.load({
            xtype: 'vc-window-video',
            title: _('vc_videos_window_title_new'),
            action: 'mgr/videos/create',
            grid: this,
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
            action: 'mgr/videos/update',
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

        var tpl =
            '<div class="details">' +
            '<p class="publishedon">' + _('vc_videos_grid_publishedon', pubdate) + '</p>' +
            '</div>';

        return new Ext.XTemplate(tpl).applyTemplate(record.data);
    }

});
Ext.reg('vc-grid-videos', VideoCast.grid.Videos);
