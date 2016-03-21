<?php

$menus = [];

$list = [
    'videocast' => [
        'text' => 'videocast_menu',
        'description' => 'videocast_menu_desc',
        'parent' => 'components',
        'icon' => '<i class="icon-shopping-cart icon icon-large"></i>',
        'action' => 'videos'
    ]
];

foreach ($list as $k => $v) {
    /* @var modMenu $menu */
    $menu = $modx->newObject('modMenu');
    $menu->fromArray(array_merge([
        'text' => $k,
        'parent' => 'components',
        'namespace' => PKG_NAME_LOWER,
        'icon' => '',
        'menuindex' => 0,
        'params' => '',
        'handler' => '',
    ], $v), '', true, true);

    $menus[] = $menu;
}

return $menus;
