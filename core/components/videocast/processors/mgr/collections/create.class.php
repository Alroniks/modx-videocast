<?php

/**
 * Class VideoCastCollectionsCreateProcessor
 */
class VideoCastCollectionsCreateProcessor extends modObjectCreateProcessor
{
    public $classKey = 'vcCollection';
    public $objectType = 'vc_collections';
    public $languageTopics = ['videocast:default'];

    /**
     * VideoCastCollectionsCreateProcessor constructor.
     * @param modX $modx
     * @param array $properties
     */
    public function __construct(modX $modx, array $properties)
    {
        parent::__construct($modx, $properties);

        $this->setCheckbox('hidden');
    }
}

return VideoCastCollectionsCreateProcessor::class;
