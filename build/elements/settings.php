<?php

$list = [

    // main
    'media_source_cover' => [
        'xtype' => 'modx-combo-source',
        'area' => 'vc_main',
        'value' => 0
    ],
    'resource_channels' => [
        'xtype' => 'vc-combo-resources',
        'area' => 'vc_main',
        'value' => 0
    ],
    'resource_collections' => [
        'xtype' => 'vc-combo-resources',
        'area' => 'vc_main',
        'value' => 0
    ],
    'resource_videos' => [
        'xtype' => 'vc-combo-resources',
        'area' => 'vc_main',
        'value' => 0
    ],
    'plugins' => [
        'xtype' => 'textfield',
        'area' => 'vc_main',
        'value' => ''
    ],

    // vimeo
    'video_vimeo_client_identifier' => [
        'xtype' => 'textfield',
        'area' => 'vc_vimeo',
        'value' => ''
    ],
    'video_vimeo_client_secret' => [
        'xtype' => 'textfield',
        'area' => 'vc_vimeo',
        'value' => ''
    ],
    'video_vimeo_access_token' => [
        'xtype' => 'textfield',
        'area' => 'vc_vimeo',
        'value' => ''
    ]
];

$settings = [];
foreach ($list as $k => $v) {
    /** @var modSystemSetting $setting */
    $setting = $this->modx->newObject('modSystemSetting');
    $setting->fromArray(array_merge([
        'key' => Builder::PKG_NAME . '_' . $k,
        'namespace' => Builder::PKG_NAME,
        'editedon' => null,
    ], $v), '', true, true);

    $settings[] = $setting;
}

return $settings;
