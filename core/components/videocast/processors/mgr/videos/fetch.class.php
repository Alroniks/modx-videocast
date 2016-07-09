<?php

/**
 * Class VideoCastVideosFetchProcessor
 */
class VideoCastVideosFetchProcessor extends modProcessor
{

    /**
     * Run the processor and return the result. Override this in your derivative class to provide custom functionality.
     * Used here for pre-2.2-style processors.
     *
     * @return mixed
     */
    public function process()
    {
        echo 'ddd';

        // сходить в vimeo, получить все данные
    }
}

return VideoCastVideosFetchProcessor::class;
