<?php

class VideoCastVideosCreateProcessor extends modObjectCreateProcessor
{
    public $classKey = 'vcVideo';
    public $languageTopics = ['videocast:default'];

//    public function __construct(modX $modx, array $properties)
//    {
//        parent::__construct($modx, $properties);
//    }
}

return VideoCastVideosCreateProcessor::class;
