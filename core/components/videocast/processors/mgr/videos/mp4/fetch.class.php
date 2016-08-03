<?php

/**
 * Class VideoCastVideosMP4FetchProcessor
 */
class VideoCastVideosMP4FetchProcessor extends modProcessor
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

        $fileInfo = [];
        if ($remote = fopen($video, 'rb')) {
            $localTempFileName = tempnam('/tmp', 'mp4fetch');
            if ($local = fopen($localTempFileName, 'wb')) {
                while ($buffer = fread($remote, 8192)) {
                    fwrite($local, $buffer);
                }
                fclose($local);

                $fileInfo = shell_exec(escapeshellcmd(
                    'ffprobe -v quiet -print_format json -show_format ' . escapeshellarg($localTempFileName)
                ));

                unlink($localTempFileName);
            }
            fclose($remote);
        }

        $data = [];

        $fileInfo = json_decode($fileInfo, true);

        if (isset($fileInfo['format']['duration'])) {
            $data['duration'] = round($fileInfo['format']['duration']);
        }

        if (isset($fileInfo['format']['size'])) {
            $data['size'] = round($fileInfo['format']['size']);
        }

        if (isset($fileInfo['format']['tags']['title'])) {
            $data['title'] = trim($fileInfo['format']['tags']['title']);
        }

        if (isset($fileInfo['format']['tags']['description'])) {
            $data['description'] = trim($fileInfo['format']['tags']['description']);
        }

        return $this->success('', $data);
    }
}

return VideoCastVideosMP4FetchProcessor::class;
