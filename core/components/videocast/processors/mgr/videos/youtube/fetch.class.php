<?php

/**
 * Class VideoCastVideosYouTubeFetchProcessor
 */
class VideoCastVideosYouTubeFetchProcessor extends modProcessor
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
        $video = filter_var($this->getProperty('video'), FILTER_VALIDATE_URL);

        if (!$video) {
            return $this->failure($this->modx->lexicon('vc_videos_error_fetch_invalid_video_id'), null);
        }

        $data = [];

        $key = $this->modx->getOption('videocast_youtube_api_key');
        $parsed = parse_url($video);
        $code = str_replace('v=', '', $parsed['query'] ?? '');

        if (!$code) {
            return $this->success('', $data);
        }

        $url = "https://www.googleapis.com/youtube/v3/videos?id={$code}&part=snippet,contentDetails,statistics&key={$key}";
        $response = json_decode(file_get_contents($url), true);

        $item = current($response['items']);

        if (!$item) {
            return $this->success('', $data);
        }

        if (isset($item['id'])) {
            $data['alias'] = $item['id'];
        }

        if (isset($item['snippet']['title'])) {
            $data['title'] = $item['snippet']['title'];
        }

        if (isset($item['snippet']['description'])) {
            $data['description'] = $item['snippet']['description'];
        }

        if (isset($item['snippet']['thumbnails']['maxres'])) {
            $data['cover'] = $item['snippet']['thumbnails']['maxres']['url'];
        }

        if (isset($item['contentDetails']['duration'])) {
            $interval = new DateInterval($item['contentDetails']['duration']);
            $date = (new DateTime('now'))->add($interval);
            $duration = $date->getTimestamp() - (new DateTime())->getTimestamp();
            $data['duration'] = $duration;
        }

        if (isset($item['statistics']['viewCount'])) {
            $data['plays'] = $item['statistics']['viewCount'];
        }

        return $this->success('', $data);
    }
}

return VideoCastVideosYouTubeFetchProcessor::class;
