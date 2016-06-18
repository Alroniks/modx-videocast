<?php

class VideoCastCollectionsCreateProcessor extends modObjectCreateProcessor
{
    public $classKey = 'vcCollection';
    public $languageTopics = ['videocast:default'];

    public function __construct(modX $modx, array $properties)
    {
        parent::__construct($modx, $properties);

        $this->setCheckbox('hidden');
    }
}

return VideoCastCollectionsCreateProcessor::class;
