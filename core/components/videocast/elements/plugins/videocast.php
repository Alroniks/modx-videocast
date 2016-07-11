<?php

switch ($modx->event->name) {
    case 'OnManagerPageBeforeRender':

        if ($_GET['a'] != 'system/settings') {
            return;
        }

        $modx->controller->addJavascript(MODX_ASSETS_URL . 'components/videocast/js/mgr/videocast.js');
        $modx->controller->addJavascript(MODX_ASSETS_URL . 'components/videocast/js/mgr/resources.combo.js');

        break;
}
