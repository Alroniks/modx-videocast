<?php

/**
 * Class VideoCastVideosCreateProcessor
 */
class VideoCastVideosCreateProcessor extends modObjectCreateProcessor
{
    public $classKey = 'vcVideo';
    public $objectType = 'vc_videos';
    public $languageTopics = ['videocast:default'];

    /**
     * VideoCastVideosCreateProcessor constructor.
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

return VideoCastVideosCreateProcessor::class;
