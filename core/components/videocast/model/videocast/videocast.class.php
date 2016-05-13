<?php

/**
 * Class VideoCast
 */
class VideoCast
{
    /** @var modX */
    public $modx;

    public $config = [];

    /**
     * VideoCast constructor.
     * @param modX $modx
     * @param array $config
     */
    public function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;

        $corePath = $this->modx->getOption('videocast.core_path', $config,
            $this->modx->getOption('core_path') . 'components/videocast/');
        $assetsPath = $this->modx->getOption('videocast.assets_path', $config,
            $this->modx->getOption('assets_path') . 'components/videocast/');
        $assetsUrl = $this->modx->getOption('videocast.assets_url', $config,
            $this->modx->getOption('assets_url') . 'components/videocast/');

        $connectorUrl = $assetsUrl . 'connector.php';

        $this->config = array_merge([
            'path.core' => $corePath,
            'path.core.model' => $corePath . 'model/',
            'path.assets' => $assetsPath,
            'path.assets.js' => $assetsPath . 'js/',
            'url.assets' => $assetsUrl,
            'url.assets.css' => $assetsUrl . 'css/',
            'url.assets.js' => $assetsUrl . 'js/',
            'url.assets.connector' => $connectorUrl
        ], $config);

        $this->modx->addPackage('videocast', $this->config['path.core.model']);
        $this->modx->lexicon->load('videocast:default');
    }
}
