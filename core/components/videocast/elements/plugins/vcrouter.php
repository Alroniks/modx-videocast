<?php

if ($modx->event->name != 'OnPageNotFound') {
    return false;
}

$alias = $modx->context->getOption('request_param_alias', 'q');

if (!isset($_REQUEST[$alias])) {
    return false;
}

$request = $_REQUEST[$alias];

$chunks = explode('/', $request);

// get system settings

// если страница категории и она есть в системных настройках, то пытаемся найти страницу в категории


switch ($chunks[0]) {

    case 'collections':

        if (!$collectionsSection = $modx->findResource($chunks[0])) {
            return false;
        }

        $collectionAlias = str_replace('.html', '', $chunks[1]);

        if ($chunks[1] != $collectionAlias || (isset($chunks[2]) && $chunks[2] == '')) {
            $modx->sendRedirect($chunks[0] . '/' . $collectionAlias);
        }

        if (!$collection = $modx->getObject('vcCollection', ['alias' => $collectionAlias])) {
            $modx->sendErrorPage();
        }

        $modx->setPlaceholders($collection, 'collection.');
        $modx->sendForward($collectionsSection);

        break;

    case 'videos':

        if (!$videosSection = $modx->findResource($chunks[0])) {
            return false;
        }

        $videoAlias = str_replace('.html', '', $chunks[1]);

        if ($chunks[1] != $videoAlias || (isset($chunks[2]) && $chunks[2] == '')) {
            $modx->sendRedirect($chunks[0] . '/' . $videoAlias);
        }

        if (!$video = $modx->getObject('vcVideo', ['alias' => $videoAlias])) {
            $modx->sendErrorPage();
        }

        if ($collection = $video->getOne('Collection')) {
            $modx->setPlaceholders($collection, 'video.collection.');
        }

        $modx->setPlaceholders($video, 'video.');
        $modx->sendForward($videosSection);

        break;
}
