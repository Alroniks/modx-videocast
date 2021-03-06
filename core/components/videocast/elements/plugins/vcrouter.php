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

$collections = $modx->getObject('modResource', ['id' => $modx->getOption('videocast_resource_collections', null, '')]);
$videos = $modx->getObject('modResource', ['id' => $modx->getOption('videocast_resource_videos', null, '')]);

if (!$collections) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Entry point resource for collections not found. See system settings.');

    return false;
}

if (!$videos) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Entry point resource for videos not found. See system settings.');

    return false;
}

switch ($chunks[0]) {
    case $collections->get('alias'):

        if (!$collectionsSection = $modx->findResource($chunks[0])) {
            return false;
        }

        $collectionAlias = str_replace('.html', '', $chunks[1]);

        if ($chunks[1] != $collectionAlias || (isset($chunks[2]) && $chunks[2] == '')) {
            $modx->sendRedirect($chunks[0] . '/' . $collectionAlias);
        }

        if (!$collection = $modx->getObject('vcCollection', ['alias' => $collectionAlias, 'hidden' => 0])) {
            $modx->sendForward($this->getOption('error_page'), $this->getOption('error_page_header', null, 'HTTP/1.0 404 Not Found'));
        }

        $duration = 0;
        $videos = 0;

        /** @var vcVideo $video */
        foreach ($collection->getMany('Videos') as $video) {
            if (!$video->get('hidden')) {
                $videos++;
                $duration += $video->get('duration');
            }
        }

        $collection->set('duration', $duration);
        $collection->set('videos', $videos);

        $modx->setPlaceholders($collection, 'collection.');
        $modx->sendForward($collectionsSection);

        break;

    case $videos->get('alias'):

        if (!$videosSection = $modx->findResource($chunks[0])) {
            return false;
        }

        $videoAlias = str_replace('.html', '', $chunks[1]);

        if ($chunks[1] != $videoAlias || (isset($chunks[2]) && $chunks[2] == '')) {
            $modx->sendRedirect($chunks[0] . '/' . $videoAlias);
        }

        if (!$video = $modx->getObject('vcVideo', ['alias' => $videoAlias, 'hidden' => 0])) {
            $modx->sendForward($this->getOption('error_page'), $this->getOption('error_page_header', null, 'HTTP/1.0 404 Not Found'));
        }

        if ($collection = $video->getOne('Collection')) {
            $modx->setPlaceholders($collection, 'video.collection.');
        }

        $modx->setPlaceholders($video, 'video.');
        $modx->sendForward($videosSection);

        break;
}
