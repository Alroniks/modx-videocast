<?php

/**
 * Class VideoCastCollectionsGetProcessor
 */
class VideoCastCollectionsGetProcessor extends modObjectGetProcessor
{
    public $classKey = 'vcCollection';
    public $languageTopics = ['videocast:default'];

    /**
     * @return array|string
     */
    public function cleanup() {
        $data = $this->object->toArray();
        $data['publishedon'] = strtotime($data['publishedon']);

        return $this->success('', $data);
    }
}

return VideoCastCollectionsGetProcessor::class;
