<?php

class VideoCastCollectionsGetProcessor extends modObjectGetProcessor
{
    public $classKey = 'vcCollection';
    public $languageTopics = ['videocast:default'];
}

return VideoCastCollectionsGetProcessor::class;
