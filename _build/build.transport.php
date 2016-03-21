<?php

set_time_limit(0);

list($microseconds, $seconds) = explode(' ', microtime());
$start = $seconds + $microseconds;

require_once 'build.config.php';

//if (file_exists('build.model.php')) {
//    require_once 'build.model.php';
//}

//$root = dirname(dirname(__FILE__)) . '/';
$root = __DIR__;
$sources = [
    'build' => $root . '_build/',
    'resolvers' => $root . '_build/resolvers/',
    'chunks' => $root . 'core/components/' . PKG_NAME_LOWER . '/elements/chunks/',
    'templates' => $root . 'core/components/' . PKG_NAME_LOWER . '/elements/templates/',
    'docs' => $root . 'core/components/' . PKG_NAME_LOWER . '/docs/',
    'source_assets' => $root . 'assets/components/' . PKG_NAME_LOWER,
    'source_core' => $root . 'core/components/' . PKG_NAME_LOWER,
];
unset($root);

require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
//require_once $sources['build'] . '/includes/functions.php';

$modx = new modX();
$modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');
$modx->getService('error', 'error.modError');
$modx->loadClass('transport.modPackageBuilder', '', false, true);

$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER, PKG_VERSION, PKG_RELEASE);
$builder->registerNamespace(PKG_NAME_LOWER, false, true, PKG_NAMESPACE_PATH);

// ============= MENU
$menus = include __DIR__ . 'data/transport.menu.php';
$attributes = [
    xPDOTransport::PRESERVE_KEYS => true,
    //xPDOTransport::UPDATE_OBJECT => BUILD_MENU_UPDATE,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::UNIQUE_KEY => 'text',
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => [
        'Action' => [
            xPDOTransport::PRESERVE_KEYS => false,
            //xPDOTransport::UPDATE_OBJECT => BUILD_ACTION_UPDATE,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => ['namespace', 'controller']
        ]
    ]
];
if (is_array($menus)) {
    foreach ($menus as $menu) {
        $vehicle = $builder->createVehicle($menu,$attributes);
        $builder->putVehicle($vehicle);
        /* @var modMenu $menu */
        $modx->log(modX::LOG_LEVEL_INFO, 'Packaged in menu "' . $menu->get('text') . '".');
    }
} else {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not package in menu.');
}

//$category = $modx->newObject('modCategory');
//$category->set('category', PKG_NAME);
//$attr = [
//    xPDOTransport::UNIQUE_KEY => 'category',
//    xPDOTransport::PRESERVE_KEYS => false,
//    xPDOTransport::UPDATE_OBJECT => true,
//    xPDOTransport::RELATED_OBJECTS => true
//];

//if (defined('BUILD_TEMPLATE_UPDATE')) {
//    $attr[xPDOTransport::RELATED_OBJECT_ATTRIBUTES]['Templates'] = [
//        xPDOTransport::PRESERVE_KEYS => false,
//        xPDOTransport::UPDATE_OBJECT => true,
//        xPDOTransport::UNIQUE_KEY => 'templatename'
//    ];
//
//    $templates = include $sources['data'] . 'transport.templates.php';
//
//    if (!is_array($templates)) {
//        $modx->log(modX::LOG_LEVEL_ERROR, 'Cannot build templates');
//    } else {
//        $category->addMany($templates);
//        $modx->log(modX::LOG_LEVEL_INFO, 'Packaged in ' . count($templates) . ' templates.');
//    }
//}

//if (defined('BUILD_CHUNK_UPDATE')) {
//    $attr[xPDOTransport::RELATED_OBJECT_ATTRIBUTES]['Chunks'] = [
//        xPDOTransport::PRESERVE_KEYS => false,
//        xPDOTransport::UPDATE_OBJECT => true,
//        xPDOTransport::UNIQUE_KEY => 'name'
//    ];
//
//    $chunks = include $sources['data'] . 'transport.chunks.php';
//
//    if (!is_array($templates)) {
//        $modx->log(modX::LOG_LEVEL_ERROR, 'Cannot build chunks');
//    } else {
//        $category->addMany($chunks);
//        $modx->log(modX::LOG_LEVEL_INFO, 'Packaged in ' . count($chunks) . ' chunks.');
//    }
//}

// load category with inner elements
//$vehicle = $builder->createVehicle($category, $attr);

/* load system settings */
//if (defined('BUILD_SETTING_UPDATE')) {
//
//    $settings = include $sources['data'] . 'transport.settings.php';
//
//    if (!is_array($settings)) {
//        $modx->log(modX::LOG_LEVEL_ERROR, 'Cannot build settings');
//    } else {
//        foreach ($settings as $setting) {
//            $builder->putVehicle($builder->createVehicle($setting, [
//                xPDOTransport::UNIQUE_KEY => 'key',
//                xPDOTransport::PRESERVE_KEYS => true,
//                xPDOTransport::UPDATE_OBJECT => BUILD_SETTING_UPDATE
//            ]));
//        }
//        $modx->log(modX::LOG_LEVEL_INFO, 'Packaged in ' . count($settings) . ' system settings.');
//    }
//}

$vehicle->resolve('file', [
    'source' => $sources['source_assets'],
    'target' => "return MODX_ASSETS_PATH . 'components/';"
]);
$vehicle->resolve('file', [
    'source' => $sources['source_core'],
    'target' => "return MODX_CORE_PATH . 'components/';"
]);

flush();

$builder->putVehicle($vehicle);
$builder->setPackageAttributes([
    'changelog' => file_get_contents($sources['docs'] . 'changelog.txt'),
    'license' => file_get_contents($sources['docs'] . 'license.txt'),
    'readme' => file_get_contents($sources['docs'] . 'readme.txt'),
    'requires', [
        'php' => '>=5.6',
        'modx' => '>=2.4',
        'pdoTools' => '~2.3'
    ]
]);

$builder->pack();

include_once 'setup.transport.php';
