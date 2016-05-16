VideoCast.grid.Collections = function (config) {
    config = config || {};

    if (!config.id) {
        config.id = 'vc-grid-collections';
    }

    this.exp = new VideoCast.grid.RowExpander({
        expandOnDblClick: false,
        tpl: new Ext.XTemplate('{description}')
    });

    this.cm = new Ext.grid.ColumnModel({
        columns: this.getColumns()
    });

    Ext.applyIf(config, {
        baseParams: {
            action: 'mgr/collections/getlist'
        },
        cm: this.cm,
        plugins: this.exp
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
        return [this.exp, {
            header: _('id'),
            dataIndex: 'id',
            sortable: true,
            hidden: true
        }, {
            header: _('vc_collections_columns_cover') + 'Обложка',
            dataIndex: 'cover',
            width: 30
        }, {
            header: _('vc_collections_columns_title') + 'основные с-ва',
            dataIndex: 'title',
            width: 100
        }, {
            header: _('vc_collections_columns_alias') + 'дополнительные с-ва и статистика',
            dataIndex: 'alias',
            width: 50
        }];
    },

    getTopBar: function getTopBar() {
        return [{
            text: 'new collection',
            handler: this.addNewCollection,
            scope: this
        }, '->'];
    },

    addNewCollection: function addNewCollection() {
        // ???
        var w = MODx.load({
            xtype: 'vc-window-collection'
        });

        w.show();
    }

});
Ext.reg('vc-grid-collections', VideoCast.grid.Collections);
