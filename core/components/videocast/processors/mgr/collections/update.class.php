<?php

class VideoCastCollectionsUpdateProcessor extends modObjectUpdateProcessor
{
    public $classKey = 'vcCollection';
    public $languageTopics = ['videocast:default'];

    public function __construct(modX $modx, array $properties)
    {
        parent::__construct($modx, $properties);

        $this->setCheckbox('hidden');
    }
}

return VideoCastCollectionsUpdateProcessor::class;
