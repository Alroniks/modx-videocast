VideoCast.grid.Collections = function (config) {
    config = config || {};

    if (!config.id) {
        config.id = 'vc-grid-collections';
    }

    // this.exp = new VideoCast.grid.RowExpander({
    //     expandOnDblClick: false,
    //     tpl: new Ext.XTemplate('{description}')
    // });

    this.cm = new Ext.grid.ColumnModel({
        columns: this.getColumns()
    });

    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/collections/getlist'
        },
        cm: this.cm,
        stripeRows: false
    });

    VideoCast.grid.Collections.superclass.constructor.call(this, config);
};

Ext.extend(VideoCast.grid.Collections, VideoCast.grid.Default, {

    getFields: function getFields() {
        return [
            'id', 'title', 'alias', 'description', 'cover'
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
        var tpl =
            '<div class="collection cover">' +
                '<img src="http://modcasts.video.loc/assets/themes/modcastsvideo/img/cls/1.jpeg">' +
            '</div>';

        return new Ext.XTemplate(tpl).applyTemplate(record.data);
    },

    descriptionRenderer: function titleRender(value, metaData, record) {
        var tpl =
            '<div class="collection description">' +
                '<h2>{rank}. {title} <span class="active">показывается</span>' +
                '<span class="hidden">скрыто</span>' +
                '</h2>' +
                '<h3>.../{alias}</h3>' +
                '<p>{description}</p>' +
            '</div>';

        return new Ext.XTemplate(tpl).applyTemplate(record.data);
    },

    parametersRenderer: function parametersRenderer(value, metaData, record) {
        var tpl =
            '<div class="collection parameters">' +
                '<p class="count"><strong>12 <small>видео</small></strong></p>' +
                '<p class="time"><strong>7 200 <small>секунд</small></strong>' +
                '<br><span>2ч 23м 34c</span>' +
                '</p>' +
                '<p class="publishedon"><b>Опубликована:</b><br><time>17.05.2016</time></p>' +
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

    addNewCollection: function addNewCollection() {

        var w = MODx.load({
            xtype: 'vc-window-collection'
        });

        w.show();
    }

});
Ext.reg('vc-grid-collections', VideoCast.grid.Collections);
