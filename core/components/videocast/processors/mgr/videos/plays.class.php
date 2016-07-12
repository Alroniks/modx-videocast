<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

/**
 * Class VideoCastVideosPlaysProcessor
 */
class VideoCastVideosPlaysProcessor extends modProcessor
{
    private $client;

    public $languageTopics = ['videocast:default'];

    /**
     * VideoCastVideosPlaysProcessor constructor.
     * @param modX $modx
     * @param array $properties
     */
    public function __construct(modX $modx, array $properties)
    {
        parent::__construct($modx, $properties);

        $this->client = new \Vimeo\Vimeo(
            $this->modx->getOption('videocast_video_source_client_identifier'),
            $this->modx->getOption('videocast_video_source_client_secret'),
            $this->modx->getOption('videocast_video_source_access_token')
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
        $source = intval($this->getProperty('source'));
        $video = intval($this->getProperty('video'));

        if (!$source) {
            return $this->failure($this->modx->lexicon('vc_videos_error_fetch_invalid_video_id'), null);
        }

        if (!$video = $this->modx->getObject('vcVideo', ['id' => $video])) {
            $this->modx->log(modX::LOG_LEVEL_WARN, 'VideoCast: ' . 'video object not found');
        }

        $response = $this->client->request('/videos/' . $source);

        if (401 === $response['status']) {
            $this->modx->log(modX::LOG_LEVEL_WARN, 'VideoCast: ' . $response['body']['error']);
            return $this->failure($this->modx->lexicon('vc_videos_error_fetch_access_denied'), null);
        }

        $plays = isset($response['body']['stats']['plays']) ? $response['body']['stats']['plays'] : 0;

        if ($video) {
            $video->set('plays', $plays);
            $video->save();
        }

        return $this->success('', $plays);
    }
}

return VideoCastVideosPlaysProcessor::class;
