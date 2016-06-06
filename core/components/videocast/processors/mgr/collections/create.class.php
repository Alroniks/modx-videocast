<?php

class VideoCastCollectionsCreateProcessor extends modObjectCreateProcessor
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

return VideoCastCollectionsCreateProcessor::class;
