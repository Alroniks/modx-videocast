<?php

include_once __DIR__ . '/../model/videocast/videocast.class.php';

class VideoCastLibraryManagerController extends modExtraManagerController
{
    /** @var VideoCast */
    protected $vc;

    /**
     * Initialize function
     */
    public function initialize()
    {
        $this->vc = new VideoCast($this->modx);

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
        return [
            'videocast:default',
            'videocast:channels',
            'videocast:collections',
            'videocast:videos'
        ];
    }

    /**
     * @return bool
     * @todo: implements permissions rules
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
        $this->addCss($this->vc->config['url.assets.css'] . 'mgr/theme.css');

        // component
        $this->addJavascript($this->vc->config['url.assets.js'] . 'mgr/videocast.js');

        // default elements
        $this->addJavascript($this->vc->config['url.assets.js'] . 'mgr/default.grid.js');
        $this->addJavascript($this->vc->config['url.assets.js'] . 'mgr/default.window.js');

        // combos
        $this->addJavascript($this->vc->config['url.assets.js'] . 'mgr/combo/collections.combo.js');
        $this->addJavascript($this->vc->config['url.assets.js'] . 'mgr/combo/videos.combo.js');

        // windows
        $this->addJavascript($this->vc->config['url.assets.js'] . 'mgr/window/collections.window.js');
        $this->addJavascript($this->vc->config['url.assets.js'] . 'mgr/window/videos.window.js');

        // grids
        $this->addJavascript($this->vc->config['url.assets.js'] . 'mgr/grid/channels.grid.js');
        $this->addJavascript($this->vc->config['url.assets.js'] . 'mgr/grid/collections.grid.js');
        $this->addJavascript($this->vc->config['url.assets.js'] . 'mgr/grid/videos.grid.js');

        // panel
        $this->addJavascript($this->vc->config['url.assets.js'] . 'mgr/library.panel.js');

        $this->addHtml(str_replace('		', '','
        <script>
            VideoCast.config = ' . $this->modx->toJSON($this->vc->config) . ';                
            Ext.onReady(function() {
                MODx.add({ xtype: "vc-panel-library" });
            });
        </script>
        '));
    }
}
