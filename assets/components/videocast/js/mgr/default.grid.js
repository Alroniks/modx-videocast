VideoCast.grid.Default = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        sm: new Ext.grid.RowSelectionModel({ singleSelect: true }),
        url: VideoCast.config['url.assets.connector'],
        baseParams: {},
        cls: config['cls'] || 'main-wrapper',
        autoHeight: true,
        paging: true,
        remoteSort: true,
        fields: this.getFields(),
        columns: this.getColumns(),
        tbar: this.getTopBar(),
        listeners: this.getListeners(),
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            autoFill: true,
            showPreview: true,
            scrollOffset: -10,
            getRowClass: function (rec) {
                var cls = [];
                return cls.join(' ');
            }
        }
    });

    VideoCast.grid.Default.superclass.constructor.call(this, config);
};

Ext.extend(VideoCast.grid.Default, MODx.grid.Grid, {

    /**
     * Returns available fields for table
     * @returns {string[]}
     */
    getFields: function getFields() {
        return ['id'];
    },

    /**
     * Returns columns list for table
     * @returns {*[]}
     */
    getColumns: function getColumns() {
        return [{
            header: _('id'),
            dataIndex: 'id',
            width: 35,
            sortable: true
        }];
    },

    /**
     * Returns initialized top bar for data grid
     * @returns {*[]}
     */
    getTopBar: function getTopBar() {
        var tb = [];

        tb.push('->');
        tb.push(this.getSearch());

        return tb;
    },

    /**
     * Returns list of field for do search in tabled data
     * @param width
     */
    getSearch: function getSearchField(width) {
        return [{
            xtype: 'textfield',
            width: width || 150,
            emptyText: _('search'),
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
            text: _('clear_filter'),
            handler: this.clear,
            scope: this
        }];
    },

    /**
     * Returns available listeners for table
     * @returns {{}}
     */
    getListeners: function getListeners() {
        return {};
    },

    /**
     * Makes context menu for each row in table
     */
    getMenu: function getMenu() {
        this.addContextMenuItem([{
            text: 'Menu Item (should be implemented)',
            handler: null
        }]);
    },

    /**
     * Refreshes table data
     */
    refresh: function refrech() {
        this.getStore().reload();
    },

    /**
     * Does search by user request
     * @param tf
     * @private
     */
    search: function search(tf) {
        this.getStore().baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
    },

    /**
     * Does clearance of search query
     * @private
     */
    clear: function clear() {
        this.getStore().baseParams.query = '';
        this.getBottomToolbar().changePage(1);
    },

    // Renders
    coverRenderer: function coverRenderer(value) {
        return new Ext
            .XTemplate('<div class="cover"><img src="{cover}"></div>')
            .applyTemplate({
                cover: value
                    ? MODx.config.base_url + value
                    : 'http://dummyimage.com/300x300/eeeeee/ffffff&text=cl'
            });
    }
    
});

Ext.reg('vc-grid-default', VideoCast.grid.Default);
