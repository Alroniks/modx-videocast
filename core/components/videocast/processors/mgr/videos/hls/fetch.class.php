<?php

/**
 * Class VideoCastVideosHLSFetchProcessor
 */
class VideoCastVideosHLSFetchProcessor extends modProcessor
{
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

        // read playlist and collect duration
        //

        $data = [];

        return $this->success('', $data);
    }
}

return VideoCastVideosHLSFetchProcessor::class;
