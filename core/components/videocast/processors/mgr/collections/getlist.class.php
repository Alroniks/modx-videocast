<?php

class VideoCastCollectionsGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'vcCollection';
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

return VideoCastCollectionsGetListProcessor::class;
