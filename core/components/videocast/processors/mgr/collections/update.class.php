<?php

/**
 * Class VideoCastCollectionsUpdateProcessor
 */
class VideoCastCollectionsUpdateProcessor extends modObjectUpdateProcessor
{
    public $classKey = 'vcCollection';
    public $objectType = 'vc_collections';
    public $languageTopics = ['videocast:default'];

    /**
     * VideoCastCollectionsUpdateProcessor constructor.
     * @param modX $modx
     * @param array $properties
     */
    public function __construct(modX $modx, array $properties)
    {
        parent::__construct($modx, $properties);

        $this->setCheckbox('hidden');
    }
}

return VideoCastCollectionsUpdateProcessor::class;
