<?php

/**
 * Class videocast
 *
 * @package videocast
 */
class VideoCast
{
    /** @var modX */
    public $modx;

    /** @var VideoCast */
    public $videocast;

    /** @var array */
    public $config = [];

    /**
     * VideoCast constructor.
     * @param modX $modx
     * @param array $config
     */
    public function __construct(modX &$modx, array $config = [])
    {
        $this->modx =& $modx;

        $corePath = $this->modx->getOption('videocast.core_path', $config, $this->modx->getOption('core_path') . 'components/videocast/');
        $assetsPath = $this->modx->getOption('videocast.assets_path', $config, $this->modx->getOption('assets_path') . 'components/videocast/');

        $assetsUrl = $this->modx->getOption('videocast.assets_url', $config, $this->modx->getOption('assets_url') . 'components/videocast/');

        $this->config = array_merge([
            'assets_path' => $assetsPath,
            'js_path' => $assetsPath . 'js/',
            'core_path' => $corePath,
            'model_path' => $corePath . 'model/',

            'assets_url' => $assetsUrl,
            'css_url' => $assetsUrl . 'css/',
            'js_url' => $assetsUrl . 'js/',
            'templates_path' => $corePath . 'elements/templates/'

        ], $config);

        $this->modx->addPackage('videocast', $this->config['model_path']);
        $this->modx->lexicon->load('videocast:default');
    }

}
