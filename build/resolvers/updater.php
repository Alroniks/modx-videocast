<?php

require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx = new modX();
$modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');
$modx->getService('error', 'error.modError');

$modelPath = $modx->getOption('videocast.core_path', null,
        $modx->getOption('core_path') . 'components/videocast/') . 'model/';

switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        break;
    case xPDOTransport::ACTION_UPGRADE:

        // tbd

        break;
    case xPDOTransport::ACTION_UNINSTALL:
        break;
}

return true;
