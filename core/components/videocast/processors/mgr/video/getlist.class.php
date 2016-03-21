<?php

class VideoCastVideoGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'vcVideo';
    public $languageTopics = ['default', 'videocast:manager'];
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'ASC';
    //public $permission = 'vcvideo_list';

    /** @var VideoCast */
    protected $videocast;

    /**
     * @return bool
     */
    public function initialize()
    {
        $this->videocast = $this->modx->getService('VideoCast');

//        if (!$this->modx->hasPermission($this->permission)) {
//            return $this->modx->lexicon('access_denied');
//        }

        return parent::initialize();
    }

}

return "VideoCastVideoGetListProcessor";
