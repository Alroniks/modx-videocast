var VideoCast = function (config) {
    config = config || {};

    VideoCast.superclass.constructor.call(this, config);
};
Ext.extend(VideoCast, Ext.Component, {
    page: {},
    window: {},
    grid: {},
    tree: {},
    panel: {},
    combo: {},
    config: {},
    view: {},
    keymap: {},
    plugin: {}
});
Ext.reg('videocast', VideoCast);

VideoCast = new VideoCast();

Ext.util.Format.declension = function (number, forms) {
    var n = parseInt(number, 10);
    var plural = (n % 10 == 1 && n % 100 != 11 ? 0 : n % 10 >= 2 && n % 10 <= 4 && (n % 100 < 10 || n % 100 >= 20) ? 1 : 2);
    plural = (n == 0) ? 0 : plural + 1;
    if (forms.length > plural) {
        return forms[plural].replace("$", n);
    }

    return "";
};
