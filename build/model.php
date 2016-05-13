<?php

use videocast\builder\Utils;

/** @var xPDOManager $manager */
$manager = $modx->getManager();
/** @var xPDOGenerator $generator */
$generator = $manager->getGenerator();

Utils::removeDirectory(__DIR__ . '/../core/components/videocast/model/videocast/mysql');

$generator->parseSchema(
    __DIR__ . '/../core/components/videocast/model/schema/videocast.mysql.schema.xml',
    __DIR__ . '/../core/components/videocast/model/'
);

$modx->log(modX::LOG_LEVEL_INFO, 'Models generated');
