<?php

include_once __DIR__ . '/../model/videocast/videocast.class.php';

class VideoCastDefaultManagerController extends modExtraManagerController
{
    /** @var VideoCast */
    protected $videocast;

    public function initialize()
    {
        $this->videocast = new VideoCast($this->modx);

        $this->addJavascript($this->videocast->config['js_url'] . 'mgr/videocast.js');
        $this->addHtml(str_replace('		', '','
        <script>
            VideoCast.config = ' . $this->modx->toJSON($this->videocast->config) . ';
            VideoCast.config.connector_url = "' . $this->videocast->config['connector_url'] . '";
        </script>
        '));

        parent::initialize();
    }

    /**
     * @return null|string
     */
    public function getPageTitle()
    {
        return $this->modx->lexicon('vc_title');
    }

    /**
     * @return array
     */
    public function getLanguageTopics()
    {
        return ['videocast:default'];
    }

    /**
     * @return bool
     */
    public function checkPermissions()
    {
        return true;
    }

    /**
     * Loads custom styles and scripts
     */
    public function loadCustomCssJs()
    {
        parent::loadCustomCssJs();

        $this->addJavascript($this->videocast->config['js_url'] . 'mgr/videos.grid.js');
        $this->addJavascript($this->videocast->config['js_url'] . 'mgr/videos.panel.js');
        $this->addJavascript($this->videocast->config['js_url'] . 'mgr/videos.page.js');

        $this->modx->invokeEvent('vcOnManagerCustomCssJs', ['controller' => &$this, 'page' => 'videos']);
    }

}

