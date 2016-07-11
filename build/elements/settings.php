<?php

$list = [
    'media_source_cover' => [
        'xtype' => 'modx-combo-source',
        'value' => 0
    ],
    'resource_collections' => [
        'xtype' => 'vc-combo-resources',
        'value' => 0
    ],
    'resource_videos' => [
        'xtype' => 'vc-combo-resources',
        'value' => 0
    ],
    'resource_courses' => [
        'xtype' => 'vc-combo-resources',
        'value' => 0
    ],
    'video_source_client_identifier' => [
        'xtype' => 'textfield',
        'value' => ''
    ],
    'video_source_client_secret' => [
        'xtype' => 'textfield',
        'value' => ''
    ],
    'video_source_access_token' => [
        'xtype' => 'textfield',
        'value' => ''
    ]
];

$settings = [];
foreach ($list as $k => $v) {
    $setting = $this->modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge([
        'key' => Builder::PKG_NAME . '_' . $k,
        'namespace' => Builder::PKG_NAME,
        'editedon' => null,
    ], $v), '', true, true);

    $settings[] = $setting;
}

return $settings;
