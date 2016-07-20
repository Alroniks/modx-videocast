<?php

$configPath = __DIR__ . '/../../../';
$configName = 'config.core.php';

$config = file_exists($configPath . $configName)
    ? $configPath . 'config.core.php'
    : $configPath . '../../config.core.php';

require_once $config;
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$corePath = $modx->getOption('videocast.core_path', null, $modx->getOption('core_path') . 'components/videocast/');
require_once $corePath . 'model/videocast/videocast.class.php';
$modx->videocast = new VideoCast($modx);
$modx->lexicon->load('videocast:default', 'videocast:videos');

/* handle request */
$path = $modx->getOption('processorsPath', $modx->videocast->config, $corePath . 'processors/');
$modx->request->handleRequest([
    'processors_path' => $path,
    'location' => ''
]);
