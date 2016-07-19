<?php
/**
 * Copyright (c) 2016 Alroniks Experts LLC
 *
 * @author: Ivan Klimchuk <ivan@klimchuk.com>
 * @package: videocast
 */

use videocast\builder\Utils;

$list = [
    'videocast' => [
        'disabled' => false,
        'description' => 'Plugin that adds javascript helpers to MODX Manager panel (custom fields in system settings)',
        'events' => [
            'OnManagerPageBeforeRender' => []
        ]
    ],
    'vcrouter' => [
        'disabled' => false,
        'description' => 'Routing plugin for root pages for videos, collections and channels',
        'events' => [
            'OnPageNotFound' => []
        ]
    ]
];

$plugins = [];
foreach ($list as $name => &$data) {

    // fetch plugins events list
    $events = $data['events'] ?? [];
    unset($data['events']);

    foreach ($events as $key => &$event) {
        $properties = $event;
        /* @var $event modPluginEvent */
        $event = $this->modx->newObject('modPluginEvent');
        $event->fromArray(array_merge([
            'event' => $key,
            'priority' => 0,
            'propertyset' => 0,
        ], $properties), '', true, true);
    }
    $events = array_values($events);

    /* @var modPlugin $plugin */
    $plugin = $this->modx->newObject('modPlugin');
    $plugin->fromArray(array_merge([
        'name' => $name,
        'plugincode' => Utils::getContent(__DIR__ . '/../../core/components/' . Builder::PKG_NAME . '/elements/plugins/' . $name . '.php'),
        'static' => true,
        'source' => 1,
        'static_file' => 'core/components/' . Builder::PKG_NAME . '/elements/plugins/' . $name . '.php',
    ], $data), '', true, true);

    $plugin->addMany($events);

    $plugins[] = $plugin;
}

return $plugins;
