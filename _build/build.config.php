<?php

define('PKG_NAME', 'videocast');
define('PKG_NAME_LOWER', strtolower(PKG_NAME));

define('PKG_VERSION', '0.1.0');
define('PKG_RELEASE', 'pl');
define('PKG_AUTO_INSTALL', true);
define('PKG_NAMESPACE_PATH', '{core_path}/components/' . PKG_NAME_LOWER . '/');

if (isset($_SERVER['MODX_BASE_PATH'])) {
    define('MODX_BASE_PATH', dirname(dirname(dirname(__FILE__))) . '/');
} else {
    define('MODX_BASE_PATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');
}

define('MODX_CORE_PATH', MODX_BASE_PATH . 'core/');
define('MODX_MANAGER_PATH', MODX_BASE_PATH . 'manager/');
define('MODX_CONNECTORS_PATH', MODX_BASE_PATH . 'connectors/');
define('MODX_ASSETS_PATH', MODX_BASE_PATH . 'assets/');

define('MODX_BASE_URL', '/');
define('MODX_CORE_URL', MODX_BASE_URL . 'core/');
define('MODX_MANAGER_URL', MODX_BASE_URL . 'manager/');
define('MODX_CONNECTORS_URL', MODX_BASE_URL . 'connectors/');
define('MODX_ASSETS_URL', MODX_BASE_URL . 'assets/');

//define('BUILD_MENU_UPDATE', false);
//define('BUILD_ACTION_UPDATE', false);
define('BUILD_SETTING_UPDATE', true);
define('BUILD_TEMPLATE_UPDATE', true);
define('BUILD_CHUNK_UPDATE', true);

define('BUILD_SNIPPET_UPDATE', false);
define('BUILD_PLUGIN_UPDATE', false);

define('BUILD_TEMPLATE_STATIC', true);
define('BUILD_CHUNK_STATIC', true);

define('BUILD_SNIPPET_STATIC', false);
define('BUILD_PLUGIN_STATIC', false);


$BUILD_RESOLVERS = [
//    'tables',
    //'chunks',
//    'office'
];
