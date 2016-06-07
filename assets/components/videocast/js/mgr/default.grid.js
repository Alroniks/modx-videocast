VideoCast.grid.Default = function (config) {
    config = config || {};

    Ext.applyIf(config, {
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
        return [];
        //}, '->', this.getSearchField()];
    },

    /**
     * Returns list of field for do search in tabled data
     * @param width
     * @returns {{xtype: string, width: (*|number), listeners: {search: {fn: listeners.search.fn, scope: BPS.grid.Default}, clear: {fn: listeners.clear.fn, scope: BPS.grid.Default}}}}
     */
    /*
    getSearchField: function getSearchField(width) {
        return {
            xtype: 'vc-field-search',
            width: width || 250,
            listeners: {
                search: {
                    fn: function (field) {
                        this._doSearch(field);
                    },
                    scope: this
                },
                clear: {
                    fn: function (field) {
                        field.setValue('');
                        this._clearSearch();
                    },
                    scope: this
                }
            }
        };
    },
    */

    /**
     * Returns available listeners for table
     * @returns {{}}
     */
    getListeners: function getListeners() {
        return {};
    },

    /**
     * Makes context menu for each row in table
     * @param grid
     * @param rowIndex
     */
    getMenu: function getMenu(grid, rowIndex) {
        var row = grid.getStore().getAt(rowIndex);

        var menu = this._getMenu(row.data['actions'], this, [rowIndex]);

        this.addContextMenuItem(menu);
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
    _doSearch: function _doSearch(tf) {
        this.getStore().baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
    },

    /**
     * Does clearance of search query
     * @private
     */
    _clearSearch: function _clearSeach() {
        this.getStore().baseParams.query = '';
        this.getBottomToolbar().changePage(1);
    },

    /**
     * Custom store loader
     * @private
     */
    _loadStore: function _loadStore() {
        this.store = new Ext.data.JsonStore({
            url: this.config.url,
            baseParams: this.config.baseParams || { action: this.config.action || 'getList' },
            fields: this.config.fields,
            root: 'results',
            totalProperty: 'total',
            remoteSort: this.config.remoteSort || false,
            storeId: this.config.storeId || Ext.id(),
            autoDestroy: true,
            listeners: {
                load: function (store, rows, data) {
                    store.sortInfo = {
                        field: data.params['sort'] || 'id',
                        direction: data.params['dir'] || 'ASC'
                    };
                    Ext.getCmp('modx-content').doLayout();
                }
            }
        });
    },

    /**
     * Helper, returns context menu for row in grid
     * @private
     */
    _getMenu: function _getMenu(actions, grid, selected) {
        var menu = [];
        var cls, icon, title, action = '';

        var has_delete = false;
        for (var i in actions) {
            if (!actions.hasOwnProperty(i)) {
                continue;
            }

            var a = actions[i];
            if (!a['menu']) {
                if (a == '-') {
                    menu.push('-');
                }
                continue;
            } else if (menu.length > 0 && !has_delete && (/^remove/i.test(a['action']) || /^delete/i.test(a['action']))) {
                menu.push('-');
                has_delete = true;
            }

            if (selected.length > 1) {
                if (!a['multiple']) {
                    continue;
                } else if (typeof(a['multiple']) == 'string') {
                    a['title'] = a['multiple'];
                }
            }

            icon = a['icon'] ? a['icon'] : '';
            if (typeof(a['cls']) == 'object') {
                if (typeof(a['cls']['menu']) != 'undefined') {
                    icon += ' ' + a['cls']['menu'];
                }
            } else {
                cls = a['cls'] ? a['cls'] : '';
            }
            title = a['title'] ? a['title'] : a['title'];
            action = a['action'] ? grid[a['action']] : '';

            menu.push({
                handler: action,
                text: String.format(
                    '<span class="{0}"><i class="x-menu-item-icon {1}"></i>{2}</span>',
                    cls, icon, title
                ),
                scope: grid
            });
        }

        return menu;
    }
});

Ext.reg('vc-grid-default', VideoCast.grid.Default);

VideoCast.grid.RowExpander = Ext.extend(Ext.grid.RowExpander, {

    getBodyContent: function(record, index) {

        if (!this.enableCaching) {
            return this.tpl.apply(record.json);
        }
        var content = this.bodyContent[record.id];

        if (!content) {
            content = this.tpl.apply(record.json);
            this.bodyContent[record.id] = content;
        }

        return content;
    }

});
