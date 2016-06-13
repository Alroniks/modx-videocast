VideoCast.grid.Collections = function (config) {
    config = config || {};

    if (!config.id) {
        config.id = 'vc-grid-collections';
    }

    this.cm = new Ext.grid.ColumnModel({
        columns: this.getColumns()
    });

    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/collections/getlist'
        },
        cm: this.cm,
        stripeRows: false,
        pageSize: 3
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
            header: _('vc_collections_columns_cover'),
            dataIndex: 'cover',
            renderer: this.coverRenderer.createDelegate(this, [this], true),
            fixed: true,
            resizable: false,
            width: 170
        }, {
            id: 'description',
            header: _('vc_collections_columns_description'),
            dataIndex: 'title',
            renderer: this.descriptionRenderer.createDelegate(this, [this], true)
        }, {
            id: 'parameters',
            header: _('vc_collections_columns_parameters'),
            dataIndex: 'alias',
            renderer: this.parametersRenderer.createDelegate(this, [this], true)
        }];
    },

    coverRenderer: function coverRenderer(value, metaData, record) {

        record.data.cover = value ? MODx.config.base_url + value : 'http://dummyimage.com/300x300/eeeeee/ffffff&text=cl';

        var tpl =
            '<div class="collection cover">' +
                '<img src="{cover}">' +
            '</div>';

        return new Ext.XTemplate(tpl).applyTemplate(record.data);
    },

    descriptionRenderer: function titleRender(value, metaData, record) {

        record.data.status = record.data.hidden
            ? '<span class="hidden">' + _('vc_collections_status_hidden') + '</span>'
            : '<span class="active">' + _('vc_collections_status_active') + '</span>';

        var tpl =
            '<div class="collection description">' +
                '<h2>{title} {status}</h2>' +
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
            '<div class="collection parameters">' +
                '<p class="count"><strong>{videos} <small>' + _('vc_collections_videos') + '</small></strong></p>' +
                '<p class="time"><strong>{duration} <small>' + _('vc_collections_seconds') + '</small></strong>' +
                    '<br><span>' + _('vc_collections_duration', [h, m, s]) + '</span>' +
                '</p>' +
                '<p class="publishedon">' + _('vc_collections_publishedon', pubdate) + '</p>' +
            '</div>';

        return new Ext.XTemplate(tpl).applyTemplate(record.data);
    },

    getTopBar: function getTopBar() {
        return [{
            text: '<i class="icon icon-large icon-folder-o"></i>&nbsp;&nbsp;&nbsp;' + _('vc_collections_btn_new'),
            handler: this.addNewCollection,
            scope: this
        }, '->'];
        // просто поиск + предвыбранные фильтры
        // показывать активные
        // показывать скрытые
        // сначала активные
        // сначала скрытые
        // сбросить фильтр
        // мало видео
        // много видео

        // меню
        // - показать / скрыть
        // - редактировать
        // - переместить вверх
        // - переместить вниз
        // - обновить статистику (если делать денормализацию, но проще через кеш)
    },

    getListeners: function getListeners() {
        return {
            rowDblClick: function (grid, rowIndex, e) {
                var row = grid.store.getAt(rowIndex);
                this.updateCollection(grid, e, row)
            }
        };
    },

    addNewCollection: function addNewCollection() {

        var w = MODx.load({
            xtype: 'vc-window-collection',
            action: 'mgr/collections/create'
        });

        w.show();
    },

    updateCollection: function updateCollection(btn, e, row) {
        if (typeof(row) != 'undefined') {
            this.menu.record = row.data;
        }
        var id = this.menu.record.id;

        MODx.Ajax.request({
            url: this.config.url,
            params: {
                action: 'mgr/collections/get',
                id: id
            },
            listeners: {
                success: {
                    fn: function (r) {
                        var w = Ext.getCmp('vc-window-collection');
                        if (w) { w.close(); }

                        w = MODx.load({
                            xtype: 'vc-window-collection',
                            action: 'mgr/collections/update',
                            record: r.object,
                            listeners: {
                                success: {
                                    fn: function () {
                                        this.refresh();
                                    }, scope: this
                                },
                                hide: {
                                    fn: function () {
                                        Ext.getCmp('vc-grid-collections').getStore().reload();
                                    }, scope: this
                                }
                            }
                        });
                        w.fp.getForm().reset();
                        w.fp.getForm().setValues(r.object);
                        w.show(e.target);
                    }, scope: this
                }
            }
        });
    }

});
Ext.reg('vc-grid-collections', VideoCast.grid.Collections);
