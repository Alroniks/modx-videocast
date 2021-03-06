<?php

require_once __DIR__ . '/../../../../vendor/autoload.php';

/**
 * Class VideoCastVideosVimeoFetchProcessor
 */
class VideoCastVideosVimeoFetchProcessor extends modProcessor
{
    private $client;

    public $languageTopics = ['videocast:default', 'videocast:videos'];

    /**
     * VideoCastVideosFetchProcessor constructor.
     * @param modX $modx
     * @param array $properties
     */
    public function __construct(modX $modx, array $properties)
    {
        parent::__construct($modx, $properties);

        $this->client = new \Vimeo\Vimeo(
            $this->modx->getOption('videocast_vimeo_client_identifier'),
            $this->modx->getOption('videocast_vimeo_client_secret'),
            $this->modx->getOption('videocast_vimeo_access_token')
        );
    }

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
        $video = filter_var($this->getProperty('video'), FILTER_VALIDATE_URL);

        if (!$video) {
            return $this->failure($this->modx->lexicon('vc_videos_error_fetch_invalid_video_id'), null);
        }

        $chunks = explode('/', $video);
        $code = array_pop($chunks);

        $response = $this->client->request('/videos/' . $code);

        if (401 === $response['status']) {
            $this->modx->log(modX::LOG_LEVEL_WARN, 'VideoCast: ' . $response['body']['error']);
            return $this->failure($this->modx->lexicon('vc_videos_error_fetch_access_denied'), null);
        }

        $playground = $response['body'];

        $data = [
            'title' => $playground['name'],
            'description' => $playground['description'],
            'alias' => array_pop(explode('/', $playground['link'])),
            'duration' => $playground['duration'],
            'cover' => array_pop($playground['pictures']['sizes'])['link'],
            'plays' => $playground['stats']['plays']
        ];

        return $this->success('', $data);
    }
}

return VideoCastVideosVimeoFetchProcessor::class;
