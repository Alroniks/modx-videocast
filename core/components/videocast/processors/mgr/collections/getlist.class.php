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

    public function prepareRow(xPDOObject $object)
    {
        $array = parent::prepareRow($object);

        $array['videos'] = rand(5, 20); // items
        $array['duration'] = rand(999, 10000); // seconds

        return $array;
    }

}

return VideoCastCollectionsGetListProcessor::class;
