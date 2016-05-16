<?php

class VideoCastCollectionsUpdateProcessor extends modObjectCreateProcessor
{
    public $classKey = 'vcCollection';
    public $languageTopics = ['videocast:default'];
    //public $permission = 'msorder_save';

    /**
     * @return bool
     */
    public function initialize()
    {
//        if (!$this->modx->hasPermission($this->permission)) {
//            return $this->modx->lexicon('access_denied');
//        }

        return parent::initialize();
    }



}

return VideoCastCollectionsUpdateProcessor::class;
