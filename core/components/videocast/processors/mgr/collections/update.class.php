<?php

class VideoCastCollectionsUpdateProcessor extends modObjectCreateProcessor
{
    public $classKey = 'vcCollection';
    public $languageTopics = ['videocast:default'];

    /**
     * @return bool
     */
    public function initialize()
    {
        return parent::initialize();
    }

}

return VideoCastCollectionsUpdateProcessor::class;
