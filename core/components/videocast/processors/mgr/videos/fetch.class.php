<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

/**
 * Class VideoCastVideosFetchProcessor
 */
class VideoCastVideosFetchProcessor extends modProcessor
{
    private $client;
    
    public function __construct(modX $modx, array $properties)
    {
        parent::__construct($modx, $properties);

        $identifier = 'ffaff2c7ebfcae06037fe9517256b1cf43d49f7d';
        $secret = 'XAdTCu80/ScY1sdBXK56uwu6IUaPkmwxMLRcIjcXeeKm6G/7qKDeheAHHbcGOi18pS+mAdJo1vicXr/6RAg4OU9nu+Bkmf4qdyFeV9vC0jkYYX25/n5OQjGAIBDnq0K6';

        $token = '22fc42e7cc48d86c3ae4e550b34cfcab';

        $this->client = new \Vimeo\Vimeo($identifier, $secret);
        $this->client->setToken($token);
    }

    /**
     * Run the processor and return the result. Override this in your derivative class to provide custom functionality.
     * Used here for pre-2.2-style processors.
     *
     * @return mixed
     * @TODO: ошибки нужно тоже переводить, так как они показываются клиенту
     */
    public function process()
    {
        $video = intval($this->getProperty('video'));

        if (!$video) {
            return $this->failure('Video code should be valid integer number greater than 0', null);
        }

        $response = $this->client->request('/videos/' . $video);

        if (401 === $response['status']) {
            $this->modx->log(modX::LOG_LEVEL_WARN, 'VideoCast: ' . $response['body']['error']);
            return $this->failure('You don\'t have access to the Vimeo.com. Please, check you credentials in the system settings.', null);
        }

        $playground = $response['body'];

        $data = [
            'title' => $playground['name'],
            'description' => $playground['description'],
            'alias' => array_pop(explode('/', $playground['link'])),
            'duration' => $playground['duration'],
            'cover' => array_pop($playground['pictures']['sizes'])['link']
        ];

        return $this->success('', $data);
    }
}

return VideoCastVideosFetchProcessor::class;
