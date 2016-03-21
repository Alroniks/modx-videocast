<?php

include_once dirname(__DIR__) . '/model/videocast/videocast.class.php';

class videocastVideosManagerController extends modExtraManagerController
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

    public function getPageTitle()
    {
        return $this->modx->lexicon('videocast_title');
    }
    
    public function getLanguageTopics()
    {
        return ['videocast:default'];
    }

    public function checkPermissions()
    {
        return true;
    }

    public function loadCustomCssJs()
    {
        parent::loadCustomCssJs();

        //$this->addJavascript($this->videocast->config['js_url'] . 'mgr/videos.grid.js');
        $this->addJavascript($this->videocast->config['js_url'] . 'mgr/videos.panel.js');
        $this->addJavascript($this->videocast->config['js_url'] . 'mgr/videos.page.js');

        $this->addHtml('<script type="text/javascript">
			Ext.onReady(function() {
				MODx.load({ xtype: "videocast-page-videos" });
				//MODx.add("videocast-page-videos");
				
				console.log("time for load");
				
				
			});
		</script>');

        $this->modx->invokeEvent('vcOnManagerCustomCssJs', ['controller' => &$this, 'page' => 'videos']);
    }

    public function getTemplateFile()
    {
        return $this->videocast->config['templates_path'] . 'mgr/videos.tpl';
    }
}
