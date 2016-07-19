<?php

/**
 * Class VideoCastVideosGetListProcessor
 */
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

    /**
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object)
    {
        $row = parent::prepareRow($object);

        $row['preview'] = $this->modx->makeUrl($this->modx->getOption('videocast_resource_videos', null, '')) . '/' . $object->get('alias');

        if ($collection = $object->getOne('Collection')) {
            $row['collection_title'] = $collection->get('title');
        }

        return $row;
    }

}

return VideoCastVideosGetListProcessor::class;
