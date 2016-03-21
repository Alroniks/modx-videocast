var VideoCast = function(config) {
    config = config || {};

    VideoCast.superclass.constructor.call(this, config);
};
Ext.extend(VideoCast, Ext.Component, { page: {}, window: {}, grid: {}, tree: {}, panel: {}, combo: {}, config: {}, view: {}, keymap: {}, plugin: {} });
Ext.reg('videocast', VideoCast);

VideoCast = new VideoCast();

// videocast.PanelSpacer = {
//     html: "<br />",
//     border: false,
//     cls: 'videocast-panel-spacer'
// };
