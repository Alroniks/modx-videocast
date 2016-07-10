<?php

class VideoCastCollectionsGetListProcessor extends modObjectGetListProcessor
{
    public $classKey = 'vcCollection';
    public $languageTopics = ['default', 'videocast:default'];
    public $defaultSortField = 'rank';
    public $defaultSortDirection = 'ASC';

    /** @var VideoCast */
    protected $vc;

    /**
     * @param xPDOQuery $c
     * @return xPDOQuery
     */
    public function prepareQueryBeforeCount(xPDOQuery $c)
    {
        if ($this->getProperty('combo')) {
            $c->select(['id', 'title']);
        } else {
            $c->select([
                'vcCollection.*',
                'duration' => 'SUM(vcVideo.duration)',
                'videos' => 'COUNT(vcVideo.id)'
            ]);
            $c->leftJoin('vcVideo', 'vcVideo', ['vcVideo.collection = `vcCollection`.`id`']);
            $c->groupby('vcCollection.id');
        }

        return $c;
    }

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

        // @TODO to system settings?
        $row['preview'] = $this->modx->makeUrl(22) . '/' . $object->get('alias');
        
        return $row;
    }
}

return VideoCastCollectionsGetListProcessor::class;
