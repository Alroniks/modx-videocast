<?php

/**
 * Class VideoCastChannelsGetListProcessor
 */
class VideoCastChannelsGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'vcChannel';
    public $languageTopics = ['default', 'videocast:default'];
    public $defaultSortField = 'id';
    public $defaultSortDirection = 'ASC';
    public $permission = 'vc_channels_list';

    /** @var VideoCast */
    protected $vc;

    /**
     * @return bool
     */
    public function initialize()
    {
        $this->vc = $this->modx->getService('VideoCast');

//        if (!$this->modx->hasPermission($this->permission)) {
//            return $this->modx->lexicon('access_denied');
//        }

        return parent::initialize();
    }

}

return VideoCastChannelsGetListProcessor::class;
