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
            'id', 'title', 'alias', 'description'
        ]
    },

    getColumns: function getColumns() {
        return [this.exp, {
            header: _('id'),
            dataIndex: 'id',
            width: 20,
            sortable: true
        }, {
            header: _('vc_collections_columns_title'),
            dataIndex: 'title',
            width: 100
        }, {
            header: _('vc_collections_columns_alias'),
            dataIndex: 'alias',
            width: 50
        }];
    }
    
});
Ext.reg('vc-grid-collections', VideoCast.grid.Collections);
