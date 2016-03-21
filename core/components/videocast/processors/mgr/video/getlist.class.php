<?php

class vcVideoGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'vcVideo';
    public $languageTopics = ['default', 'videocast:manager'];
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'ASC';
    //public $permission = 'vcvideo_list';

    /** @var videoCast */
    protected $vc;

    /**
     * @return bool
     */
    public function initialize()
    {
//        $this->vc = $this->modx->getService('videoCast');

//        if (!$this->modx->hasPermission($this->permission)) {
//            return $this->modx->lexicon('access_denied');
//        }

        return parent::initialize();
    }



}

return "vcVideoGetListProcessor";
