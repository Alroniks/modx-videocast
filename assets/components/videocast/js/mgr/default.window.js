VideoCast.window.Default = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        title: '',
        url: VideoCast.config['url.assets.connector'],
        cls: config['cls'] || 'modx-window vc-window ',
        layout: 'anchor',
        width: 600,
        autoHeight: true,
        allowDrop: false,
        record: {},
        baseParams: {},
        fields: this.getFields(config),
        keys: this.getKeys(config),
        buttons: this.getButtons(config),
        listeners: this.getListeners(config),
    });

    VideoCast.window.Default.superclass.constructor.call(this, config);

    this.on('show', function () {
        this.renderPreview(this.record.cover);
    });

    this.on('hide', function () {
        var self = this;
        window.setTimeout(function () {
            self.close();
        }, 200);
    });
};

Ext.extend(VideoCast.window.Default, MODx.Window, {

    getFields: function (config) {
        return [];
    },

    getButtons: function (config) {
        return [{
            text: config.cancelBtnText || _('cancel'),
            scope: this,
            handler: function () {
                config.closeAction !== 'close'
                    ? this.hide()
                    : this.close();
            }
        }, {
            text: config.saveBtnText || _('save'),
            cls: 'primary-button',
            scope: this,
            handler: this.submit
        }];
    },

    getKeys: function (config) {
        return [{
            key: Ext.EventObject.ENTER,
            shift: true,
            fn: function () {
                this.submit();
            }, scope: this
        }];
    },

    getListeners: function () {
        return {};
    },

    renderPreview: function renderPreview(cover) {
        if (!cover) {
            return;
        }

        var rule = new RegExp(/^http(s?):\/\/.+/);
        var preview = rule.test(cover)
            ? cover
            : MODx.config.site_url + cover;

        document.getElementById('cover-preview').setAttribute('src', preview);
    }

});

Ext.reg('vc-window-default', VideoCast.window.Default);


