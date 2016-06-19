<?php

$list = [
    'cover_source_default' => [
        'xtype' => 'modx-combo-source',
        'value' => 0
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
