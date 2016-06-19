<?php

class VideoCastVideosUpdateProcessor extends modObjectUpdateProcessor
{
    public $classKey = 'vcVideo';
    public $languageTopics = ['videocast:default'];

    public function __construct(modX $modx, array $properties)
    {
        parent::__construct($modx, $properties);

        $this->setCheckbox('hidden');
        $this->setCheckbox('free');
    }
}

return VideoCastVideosUpdateProcessor::class;
