<?php
/**
 * Copyright (c) 2016 Alroniks Experts LLC
 *
 * @author: Ivan Klimchuk <ivan@klimchuk.com>
 * @package: videocast
 */

$list = [
    'videocast' => [
        'text' => 'videocast_menu',
        'description' => 'videocast_menu_desc',
        'parent' => 'topnav',
        'icon' => '<i class="icon-shopping-cart icon icon-large"></i>',
        'action' => 'default'
    ]
];

$menus = [];
foreach ($list as $name => $data) {
    /* @var modMenu $menu */
    $menu = $modx->newObject('modMenu');
    $menu->fromArray(array_merge([
        'text' => $name,
        'parent' => 'components',
        'namespace' => PKG_NAME,
        'menuindex' => 0
    ], $data), '', true, true);

    $menus[] = $menu;
}

return $menus;
