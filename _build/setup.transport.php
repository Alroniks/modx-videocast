<?php

define('MODX_API_MODE', true);

require_once '../../../index.php';

$modx->initialize('mgr');

$modx->setLogLevel(modX::LOG_LEVEL_ERROR);
$modx->setLogTarget();

$modx->runProcessor('workspace/packages/scanLocal');

$answer = $modx->runProcessor('workspace/packages/install',
    ['signature' => join('-', [PKG_NAME_LOWER, PKG_VERSION, PKG_RELEASE])]
);

if ($answer) {
    $response = $answer->getResponse();
    echo $response['message'] . PHP_EOL;
}

$modx->getCacheManager()->refresh();
$modx->reloadConfig();
