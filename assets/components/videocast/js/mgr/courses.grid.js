VideoCast.grid.Courses = function (config) {
    config = config || {};

    Ext.applyIf(config, {
        id: 'vc-grid-courses'
    });

    VideoCast.grid.Courses.superclass.constructor.call(this, config);
};

Ext.extend(VideoCast.grid.Courses, VideoCast.grid.Default, {
    windows: {}

});
Ext.reg('vc-grid-courses', VideoCast.grid.Courses);
