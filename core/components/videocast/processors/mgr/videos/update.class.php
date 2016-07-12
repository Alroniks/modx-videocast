<?php

/**
 * Class VideoCastVideosUpdateProcessor
 */
class VideoCastVideosUpdateProcessor extends modObjectUpdateProcessor
{
    public $classKey = 'vcVideo';
    public $objectType = 'vc_videos';
    public $languageTopics = ['videocast:default'];

    /**
     * VideoCastVideosUpdateProcessor constructor.
     * @param modX $modx
     * @param array $properties
     */
    public function __construct(modX $modx, array $properties)
    {
        parent::__construct($modx, $properties);

        $this->setCheckbox('hidden');
        $this->setCheckbox('free');
    }
}

return VideoCastVideosUpdateProcessor::class;
