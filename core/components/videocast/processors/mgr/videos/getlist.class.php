<?php

class VideoCastVideosGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'vcVideo';
    public $languageTopics = ['default', 'videocast:default'];
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'ASC';

    /** @var VideoCast */
    protected $vc;

    /**
     * @return bool
     */
    public function initialize()
    {
        $this->vc = $this->modx->getService('VideoCast');

        return parent::initialize();
    }

}

return VideoCastVideosGetListProcessor::class;
