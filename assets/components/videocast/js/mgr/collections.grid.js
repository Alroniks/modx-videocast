VideoCast.grid.Collections = function (config) {
    config = config || {};
    config.id = config.id || 'vc-grid-collections';

    this.cm = new Ext.grid.ColumnModel({
        columns: this.getColumns()
    });

    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/collections/getlist',
            sort: 'rank',
            dir: 'ASC'
        },
        cm: this.cm,
        stripeRows: false,
        pageSize: 3,
        cls: 'main-wrapper vc-grid collection'
    });

    VideoCast.grid.Collections.superclass.constructor.call(this, config);
};

Ext.extend(VideoCast.grid.Collections, VideoCast.grid.Default, {

    getFields: function getFields() {
        return [
            'id', 'title', 'alias', 'description', 'cover', 'rank', 'hidden', 'publishedon',
            'videos', 'duration'
        ]
    },

    getColumns: function getColumns() {
        return [{
            id: 'cover',
            header: _('vc_collections_column_cover'),
            dataIndex: 'cover',
            renderer: this.coverRenderer.createDelegate(this, [this], true),
            fixed: true,
            resizable: false,
            width: 170
        }, {
            id: 'description',
            header: _('vc_collections_column_description'),
            dataIndex: 'title',
            renderer: this.descriptionRenderer.createDelegate(this, [this], true)
        }, {
            id: 'parameters',
            header: _('vc_collections_column_parameters'),
            dataIndex: 'alias',
            renderer: this.parametersRenderer.createDelegate(this, [this], true)
        }];
    },

    getMenu: function getMenu() {
        var menu = [];
        menu.push({
            text: _('vc_collections_menu_edit'),
            handler: this.updateCollection
        }, {
            text: this.menu.record.hidden
                ? _('vc_collections_menu_show')
                : _('vc_collections_menu_hide'),
            handler: this.updateVisibility
        }, '-', {
            text: _('vc_collections_menu_move_up'),
            handler: this.updatePosition
        }, {
            text: _('vc_collections_menu_move_down'),
            handler: this.updatePosition
        }, '-', {
            text: _('vc_collections_menu_remove'),
            cls: 'danger',
            handler: this.removeCollection
        });

        this.addContextMenuItem(menu);
    },

    getTopBar: function getTopBar() {
        var topBar = VideoCast.grid.Collections.superclass.getTopBar.call(this);

        topBar.unshift({
            text: '<i class="icon icon-large icon-folder-o"></i>&nbsp;&nbsp;&nbsp;' + _('vc_collections_button_new'),
            handler: this.addCollection,
            scope: this
        });

        topBar.splice(topBar.indexOf('->') + 1, 0, {
            xtype: 'textfield',
            name: 'filter',
            // id: 'vc-search-collection',
            emptyText: 'filtering'
        });

        // предвыбранные фильтры
        // показывать активные
        // показывать скрытые
        // сначала активные
        // сначала скрытые
        // сбросить фильтр
        // мало видео
        // много видео

        return topBar;
    },

    addCollection: function addCollection() {
        MODx.load({
            xtype: 'vc-window-collection',
            title: _('vc_collections_window_title_new'),
            action: 'mgr/collections/create',
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

    updateCollection: function updateCollection(btn, e) {

        var record = this.menu.record;
        record.publishedon = (new Date(record.publishedon)).format(MODx.config.manager_date_format || 'd-m-Y');

        var window = MODx.load({
            xtype: 'vc-window-collection',
            title: _('vc_collections_window_title_update', [record.title]),
            action: 'mgr/collections/update',
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

    removeCollection: function removeCollection(btn, e) {
        // TBD
    },
    
    updateVisibility: function updateVisibility() {
        // TBD
    },

    updatePosition: function updatePosition() {
        // TBD
    },

    descriptionRenderer: function descriptionRenderer(value, metaData, record) {

        record.data.visibility = record.data.hidden
            ? '<span class="hidden">' + _('vc_collections_visibility_hidden') + '</span>'
            : '<span class="active">' + _('vc_collections_visibility_active') + '</span>';

        var tpl =
            '<div class="description">' +
            '<h2>{title} {visibility}</h2>' +
            '<h3>.../{alias}</h3>' +
            '<p>{description}</p>' +
            '<br><small>Rank: {rank}</small>' +
            '</div>';

        return new Ext.XTemplate(tpl).applyTemplate(record.data);
    },

    parametersRenderer: function parametersRenderer(value, metaData, record) {

        var publishedon = new Date(record.data.publishedon),
            pubdate = {
                rtime: publishedon.toISOString(),
                htime: publishedon.format(MODx.config.manager_date_format + ' ' + MODx.config.manager_time_format)
            };

        var h = Math.floor(record.data.duration / 3600),
            m = Math.floor(record.data.duration / 60) % 60,
            s = record.data.duration % 60;

        var tpl =
            '<div class="parameters">' +
            '<p class="count"><strong>{videos} <small>' + _('vc_collections_grid_videos') + '</small></strong></p>' +
            '<p class="time"><strong>{duration} <small>' + _('vc_collections_grid_seconds') + '</small></strong>' +
            '<br><span>' + _('vc_collections_grid_duration', [h, m, s]) + '</span>' +
            '</p>' +
            '<p class="publishedon">' + _('vc_collections_grid_publishedon', pubdate) + '</p>' +
            '</div>';

        return new Ext.XTemplate(tpl).applyTemplate(record.data);
    }

});
Ext.reg('vc-grid-collections', VideoCast.grid.Collections);
