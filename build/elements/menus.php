<?php
/**
 * Copyright (c) 2016 Alroniks Experts LLC
 *
 * @author: Ivan Klimchuk <ivan@klimchuk.com>
 * @package: videocast
 */

$list = [
    'videocast' => [
        'text' => 'vc_menu',
        'description' => 'vc_menu_desc',
        'parent' => 'topnav',
        'menuindex' => 0,
        'icon' => '<i class="icon-television icon icon-large"></i>',
        'action' => 'library'
    ]
];

$menus = [];
foreach ($list as $name => $data) {
    /* @var modMenu $menu */
    $menu = $this->modx->newObject('modMenu');
    $menu->fromArray(array_merge([
        'parent' => 'components',
        'namespace' => Builder::PKG_NAME,
        'menuindex' => 0
    ], $data), '', true, true);

    $menus[] = $menu;
}

return $menus;
