VideoCast.grid.Collections = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'vc-grid-collections'
    });

    VideoCast.grid.Collections.superclass.constructor.call(this, config);
};

Ext.extend(VideoCast.grid.Collections, VideoCast.grid.Default, {
    windows: {}
    
});
Ext.reg('vc-grid-collections', VideoCast.grid.Collections);
