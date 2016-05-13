<?php

set_time_limit(0);

require_once 'config.php';

$root = dirname(__DIR__) . '/';
$sources = [
    'build' => $root . '_build/',
    'resolvers' => $root . '_build/resolvers/',
    'validators' => $root . '_build/validators/',
    'source_assets' => $root . 'assets/components/' . PKG_NAME,
    'source_core' => $root . 'core/components/' . PKG_NAME
];
unset($root);

require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
require_once __DIR__ . '/includes/Utils.php';

$modx = new modX();
$modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');
$modx->getService('error', 'error.modError');
$modx->loadClass('transport.modPackageBuilder', '', false, true);

// generate and load model
require_once 'model.php';

$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME, PKG_VERSION, PKG_RELEASE);
$builder->registerNamespace(PKG_NAME, false, true, PKG_NAMESPACE_PATH);

$category = $modx->newObject('modCategory');
$category->set('category', PKG_NAME);

// load templates
// load chunks

// load category with inner elements
$vehicle = $builder->createVehicle($category, [
    xPDOTransport::UNIQUE_KEY => 'category',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => []
]);

// load menus
$menus = include_once __DIR__ . '/elements/menus.php';
if (!is_array($menus)) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Cannot build menus');
} else {
    foreach ($menus as $menu) {
        $builder->putVehicle($builder->createVehicle($menu, [
            xPDOTransport::PRESERVE_KEYS => true,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'text',
            xPDOTransport::RELATED_OBJECTS => true,
            xPDOTransport::RELATED_OBJECT_ATTRIBUTES => [
                'Action' => [
                    xPDOTransport::PRESERVE_KEYS => false,
                    xPDOTransport::UPDATE_OBJECT => true,
                    xPDOTransport::UNIQUE_KEY => ['namespace', 'controller']
                ]
            ]
        ]));
        $modx->log(modX::LOG_LEVEL_INFO, 'Packaged in ' . count($menus) . ' menus.');
    }
}

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
    'changelog' =>  file_get_contents(__DIR__ . '/../docs/changelog.txt'),
    'license' =>    file_get_contents(__DIR__ . '/../docs/license.txt'),
    'readme' =>     file_get_contents(__DIR__ . '/../docs/readme.txt'),
    'requires', [
        'php' => '>=5.6',
        'modx' => '>=2.4',
        'pdoTools' => '~2.3'
    ]
]);

$builder->pack();

include_once 'setup.php';
