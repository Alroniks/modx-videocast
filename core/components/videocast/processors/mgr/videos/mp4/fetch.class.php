<?php

require_once __DIR__ . '/../../../../vendor/autoload.php';

/**
 * Class VideoCastVideosMP4FetchProcessor
 */
class VideoCastVideosMP4FetchProcessor extends modProcessor
{
    private $client;

    public $languageTopics = ['videocast:default', 'videocast:videos'];

    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return $this->languageTopics;
    }

    /**
     * Run the processor and return the result. Override this in your derivative class to provide custom functionality.
     * Used here for pre-2.2-style processors.
     *
     * @return mixed
     */
    public function process()
    {
        $video = $this->getProperty('video');

        if (!$video) {
            return $this->failure($this->modx->lexicon('vc_videos_error_fetch_invalid_video_id'), null);
        }

        // load library for reading tags

//        $data = [
//            'title' => $playground['name'],
//            'description' => $playground['description'],
//            'alias' => array_pop(explode('/', $playground['link'])),
//            'duration' => $playground['duration'],
//            'cover' => array_pop($playground['pictures']['sizes'])['link'],
//            'plays' => $playground['stats']['plays']
//        ];

        $data = [
            'duration' => 1000
        ];

        return $this->success('', $data);
    }
}

return VideoCastVideosMP4FetchProcessor::class;
