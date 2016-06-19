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
    case xPDOTransport::ACTION_UPGRADE:

        $tmp = explode('/', MODX_ASSETS_URL);
        $assets = $tmp[count($tmp) - 2];

        $properties = [
            'name' => 'VC Covers',
            'description' => 'Default media source for covers for video cast items',
            'class_key' => 'sources.modFileMediaSource',
            'properties' => [
                'basePath' => [
                    'name' => 'basePath',
                    'desc' => 'prop_file.basePath_desc',
                    'type' => 'textfield',
                    'lexicon' => 'core:source',
                    'value' => $assets . '/images/covers/',
                ],
                'baseUrl' => [
                    'name' => 'baseUrl',
                    'desc' => 'prop_file.baseUrl_desc',
                    'type' => 'textfield',
                    'lexicon' => 'core:source',
                    'value' => 'assets/images/covers/',
                ]
            ],
            'is_stream' => 1,
        ];
        /** @var $source modMediaSource */
        if (!$source = $modx->getObject('sources.modMediaSource', ['name' => $properties['name']])) {
            $source = $modx->newObject('sources.modMediaSource', $properties);
        } else {
            $default = $source->get('properties');
            foreach ($properties['properties'] as $k => $v) {
                if (!array_key_exists($k, $default)) {
                    $default[$k] = $v;
                }
            }
            $source->set('properties', $default);
        }
        $source->save();

        if ($setting = $modx->getObject('modSystemSetting', ['key' => 'videocast_cover_source_default'])) {
            if (!$setting->get('value')) {
                $setting->set('value', $source->get('id'));
                $setting->save();
            }
        }

        @mkdir(MODX_ASSETS_PATH . 'images/');
        @mkdir(MODX_ASSETS_PATH . 'images/covers/');
        @mkdir(MODX_ASSETS_PATH . 'images/covers/videos/');
        @mkdir(MODX_ASSETS_PATH . 'images/covers/collections/');
        @mkdir(MODX_ASSETS_PATH . 'images/covers/courses/');

        break;
    case xPDOTransport::ACTION_UNINSTALL:
        break;
}

return true;
