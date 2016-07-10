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

    public function prepareRow(xPDOObject $object)
    {
        $row = parent::prepareRow($object);

        // @TODO to system settings root link?
        $row['preview'] = $this->modx->makeUrl(21) . '/' . $object->get('alias');

        return $row;
    }

}

return VideoCastVideosGetListProcessor::class;
