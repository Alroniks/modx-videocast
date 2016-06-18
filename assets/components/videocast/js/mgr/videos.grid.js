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
        cls: 'main-wrapper video grid'
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
            id: 'id',
            header: 'id',
            dataIndex: 'id'
        }];
    },
    
    getTopBar: function getTopBar() {
        var topBar = VideoCast.grid.Videos.superclass.getTopBar.call(this);
        
        topBar.unshift({
            text: '<i class="icon icon-large icon-vimeo"></i>&nbsp;&nbsp;&nbsp; New video',
            handler: this.addVideo,
            scope: this
        });
        
        return topBar;
    },
    
    addVideo: function addVideo() {
        MODx.load({
            xtype: 'vc-window-video',
            action: 'mgr/videos/create'
        }).show();
    }

});
Ext.reg('vc-grid-videos', VideoCast.grid.Videos);
