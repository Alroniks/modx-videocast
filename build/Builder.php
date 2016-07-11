<?php

use videocast\builder\Utils;

set_time_limit(0);

require_once __DIR__ . '/includes/Utils.php';

/**
 * Class Builder
 */
class Builder
{
    const PKG_NAME = 'videocast';
    const PKG_NAME_HUMAN = 'VideoCast';
    const PKG_VERSION = '0.0.0';
    const PKG_RELEASE = 'pl';

    const REPO_USER = 'alroniks';
    const REPO_NAME = 'modx-videocast';

    /** @var \modX */
    private $modx;

    /** @var \modPackageBuilder */
    private $builder;

    private $argv = [];

    public function __construct($argv)
    {
        $this->argv = $argv;

        // define basic constants for MODX
        define('MODX_BASE_PATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');

        define('MODX_CORE_PATH',        MODX_BASE_PATH . 'core/');
        define('MODX_MANAGER_PATH',     MODX_BASE_PATH . 'manager/');
        define('MODX_CONNECTORS_PATH',  MODX_BASE_PATH . 'connectors/');
        define('MODX_ASSETS_PATH',      MODX_BASE_PATH . 'assets/');

        define('MODX_BASE_URL',         '/');
        define('MODX_CORE_URL',         MODX_BASE_URL . 'core/');
        define('MODX_MANAGER_URL',      MODX_BASE_URL . 'manager/');
        define('MODX_CONNECTORS_URL',   MODX_BASE_URL . 'connectors/');
        define('MODX_ASSETS_URL',       MODX_BASE_URL . 'assets/');

        $this->initMODX();
        $this->initBuilder();
    }

    /**
     * Load and initialize MODX instance
     */
    private function initMODX()
    {
        require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

        $this->modx = new modX();
        $this->modx->initialize('mgr');
        $this->modx->setLogLevel(modX::LOG_LEVEL_INFO);
        $this->modx->setLogTarget('ECHO');
        $this->modx->getService('error', 'error.modError');
    }

    /**
     * Initialize internal package builder from MODX
     */
    private function initBuilder()
    {
        $this->modx->loadClass('transport.modPackageBuilder', '', false, true);
        $this->builder = new \modPackageBuilder($this->modx);
    }

    /**
     * Register namespace
     */
    private function packNamespace()
    {
        $this->builder->registerNamespace(self::PKG_NAME, false, true, "{core_path}/components/" . self::PKG_NAME . "/");
    }

    /**
     * Packs elements (template, chunks, snippets etc) into category
     * @param modCategory $category
     * @param string $type
     */
    private function packCategoryElements(&$category, $type)
    {
        $elements = include_once __DIR__ . "/elements/{$type}.php";
        if (!is_array($elements)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, "Cannot build $type");
        } else {
            $category->addMany($elements);
            $count = count($elements);
            $this->modx->log(modX::LOG_LEVEL_INFO, "Packaged in $count $type.");
        }
    }

    /**
     * Packs category with internal elements into vehicle
     * @return modTransportVehicle
     */
    private function packCategory()
    {
        /** @var modCategory $category */
        $category = $this->modx->newObject('modCategory');
        $category->set('category', self::PKG_NAME);

        $this->packCategoryElements($category, 'plugins');

        $this->builder->putVehicle($this->builder->createVehicle($category, [
            xPDOTransport::UNIQUE_KEY => 'category',
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::RELATED_OBJECTS => true,
            xPDOTransport::RELATED_OBJECT_ATTRIBUTES => [
                'Plugins' => [
                    xPDOTransport::PRESERVE_KEYS => true,
                    xPDOTransport::UPDATE_OBJECT => true,
                    xPDOTransport::UNIQUE_KEY => 'name'
                ],
                'PluginEvents' => [
                    xPDOTransport::PRESERVE_KEYS => true,
                    xPDOTransport::UPDATE_OBJECT => true,
                    xPDOTransport::UNIQUE_KEY => ['pluginid','event'],
                ]
            ]
        ]));
    }

    /**
     * Packs metadata for package
     */
    private function packMeta()
    {
        $transport = $this->modx->fromJSON(file_get_contents(__DIR__ . '/../transport.json'));
        unset($transport['support']['db']);

        $this->builder->setPackageAttributes([
            'changelog' =>  file_get_contents(__DIR__ . '/../meta/changelog.txt'),
            'license'   =>  file_get_contents(__DIR__ . '/../meta/license.txt'),
            'readme'    =>  file_get_contents(__DIR__ . '/../meta/readme.txt'),
            'requires'  =>  $transport['support']
        ]);
    }

    /**
     * Packs internal resources (pages)
     */
    private function packResources()
    {
        $resources = include_once __DIR__ . '/elements/resources.php';
        if (!is_array($resources)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, 'Cannot build resources');
        } else {
            foreach ($resources as $resource) {
                $this->builder->putVehicle($this->builder->createVehicle($resource, [
                    xPDOTransport::UNIQUE_KEY => 'id',
                    xPDOTransport::PRESERVE_KEYS => true,
                    xPDOTransport::UPDATE_OBJECT => true
                ]));
            }
            $this->modx->log(modX::LOG_LEVEL_INFO, 'Packaged in ' . count($resources) . ' resources.');
        }
    }

    /**
     * Packs internal system settings
     */
    private function packSettings()
    {
        $settings = include_once __DIR__ . '/elements/settings.php';
        if (!is_array($settings)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, 'Cannot build settings');
        } else {
            foreach ($settings as $setting) {
                $this->builder->putVehicle($this->builder->createVehicle($setting, [
                    xPDOTransport::UNIQUE_KEY => 'key',
                    xPDOTransport::PRESERVE_KEYS => true,
                    xPDOTransport::UPDATE_OBJECT => true
                ]));
            }
            $this->modx->log(modX::LOG_LEVEL_INFO, 'Packaged in ' . count($settings) . ' system settings.');
        }
    }

    /**
     * Packs top menus for package
     */
    private function packMenus()
    {
        $menus = include_once __DIR__ . '/elements/menus.php';
        if (!is_array($menus)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, 'Cannot build menus');
        } else {
            foreach ($menus as $menu) {
                $this->builder->putVehicle($this->builder->createVehicle($menu, [
                    xPDOTransport::PRESERVE_KEYS => true,
                    xPDOTransport::UPDATE_OBJECT => true,
                    xPDOTransport::UNIQUE_KEY => 'text',
                    xPDOTransport::RELATED_OBJECTS => true,
                    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => [
                        'Action' => [
                            xPDOTransport::PRESERVE_KEYS => false,
                            xPDOTransport::UPDATE_OBJECT => true,
                            xPDOTransport::UNIQUE_KEY => ['namespace', 'controller']
                        ]
                    ]
                ]));
                $this->modx->log(modX::LOG_LEVEL_INFO, 'Packaged in ' . count($menus) . ' menus.');
            }
        }
    }

    /**
     * Packs internal models from schema file
     */
    private function packModels()
    {
        /** @var xPDOManager $manager */
        $manager = $this->modx->getManager();
        /** @var xPDOGenerator $generator */
        $generator = $manager->getGenerator();

        Utils::removeDirectory(__DIR__ . '/../core/components/videocast/model/videocast/mysql');

        $generator->parseSchema(
            __DIR__ . '/../core/components/videocast/model/schema/videocast.mysql.schema.xml',
            __DIR__ . '/../core/components/videocast/model/'
        );

        $this->modx->log(modX::LOG_LEVEL_INFO, 'Models generated');
    }

    /**
     * Packs files into package
     */
    private function packFiles()
    {
        // load core
        $this->builder->putVehicle($this->builder->createVehicle('xPDOFileVehicle', [
            'vehicle_class' => 'xPDOFileVehicle',
            'object' => [
                'source' => __DIR__ . '/../core/components/' . self::PKG_NAME,
                'target' => "return MODX_CORE_PATH . 'components/';"
            ]
        ]));

        // load assets
        $this->builder->putVehicle($this->builder->createVehicle('xPDOFileVehicle', [
            'vehicle_class' => 'xPDOFileVehicle',
            'object' => [
                'source' => __DIR__ . '/../assets/components/' . self::PKG_NAME,
                'target' => "return MODX_ASSETS_PATH . 'components/';"
            ]
        ]));
    }

    /**
     * Packs custom php scripts that will be run after package installation
     */
    private function packResolvers()
    {
        $this->builder->putVehicle($this->builder->createVehicle('xPDOScriptVehicle', [
            'vehicle_class' => 'xPDOScriptVehicle',
            'object' => ['source' => __DIR__ . '/resolvers/tables.php']
        ]));

        $this->builder->putVehicle($this->builder->createVehicle('xPDOScriptVehicle', [
            'vehicle_class' => 'xPDOScriptVehicle',
            'object' => ['source' => __DIR__ . '/resolvers/sources.php']
        ]));

        $this->builder->putVehicle($this->builder->createVehicle('xPDOScriptVehicle', [
            'vehicle_class' => 'xPDOScriptVehicle',
            'object' => ['source' => __DIR__ . '/resolvers/updater.php']
        ]));
    }

    /**
     * Installs current version of package
     */
    protected function install()
    {
        $this->modx->runProcessor('workspace/packages/scanLocal');
        $answer = $this->modx->runProcessor('workspace/packages/install',
            ['signature' => join('-', [self::PKG_NAME, self::PKG_VERSION, self::PKG_RELEASE])]
        );

        if ($answer) {
            $response = $answer->getResponse();
            echo $response['message'] . PHP_EOL;
        }

        $this->modx->getCacheManager()->refresh();
        $this->modx->reloadConfig();
    }

    /**
     * Builds package
     * @param $version
     */
    protected function build($version = self::PKG_VERSION)
    {
        $this->builder->createPackage(self::PKG_NAME, $version, self::PKG_RELEASE);

        $this->packNamespace();
        $this->packCategory();
        //$this->packResources();
        $this->packSettings();
        $this->packMenus();
        $this->packModels();
        $this->packFiles();
        $this->packResolvers();
        $this->packMeta();

        $this->builder->pack();
    }

    private function request($url, $payload = [], $headers = [], $binary = false)
    {
        $baseUrl = 'https://api.github.com';
        $secret = trim(file_get_contents('secret.gh'));

        $url = str_replace([':owner', ':repo'], [self::REPO_USER, self::REPO_NAME], $url);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => strpos($url, 'http') !== false ? $url : $baseUrl . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => 'Alroniks Package Builder',
            CURLOPT_HEADER => false,
            CURLOPT_USERPWD => join(':', [self::REPO_USER, $secret])
        ]);

        // if $payload not empty, it means that it is post request
        if ($payload) {
            curl_setopt_array($ch, [
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => $payload,
                CURLOPT_HTTPHEADER => $headers
            ]);
            if ($binary) {
                curl_setopt_array($ch, [
                    CURLOPT_BINARYTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false
                ]);
            }
        }

        $result = curl_exec($ch);
        curl_close($ch);

        return $this->modx->fromJSON($result);
    }

    /**
     * @param $v - Release version
     * @param $m - Release notes
     */
    protected function publish($v, $m)
    {
        // get latest release
        $release = $this->request('/repos/:owner/:repo/releases/latest');

        // set up new version
        $realVersionNumber = $v-1;
        $version = $release['tag_name'];
        $version = explode('.', $version);
        $version[$realVersionNumber]++;
        for ($i = $realVersionNumber + 1; $i < 3; $i++) {
            $version[$i] = 0;
        }
        $version = implode('.', $version);

        $tags = [];
        foreach (explode(PHP_EOL, shell_exec('git ls-remote --tags')) as $tag) {
            if (!strlen($tag)) {
                continue;
            }

            $tagInfo = explode('refs/tags/', $tag);
            $tags[trim($tagInfo[1])] = trim($tagInfo[0]);
        }

        if (array_key_exists($release['tag_name'], $tags)) {
            $file = __DIR__ . '/../meta/changelog.txt';

            $hash = $tags[$release['tag_name']];
            $cmd = "git log $hash..HEAD --pretty=format:'%h %s'";
            $entries = shell_exec($cmd);

            $package = self::PKG_NAME_HUMAN;
            $date = (new DateTime)->format('M d, Y');

            $info = ["$package $version-pl ($date)", '====================================', '', "    $m", '', $entries, '', ''];

            $changeLog = file_get_contents($file);
            $changeLog = join(PHP_EOL, $info) . $changeLog;
            file_put_contents($file, $changeLog);

            $msg = escapeshellarg($m);
            shell_exec("git commit -am $msg");
            shell_exec("git push origin master");
        }

        // send new release
        $release = $this->request(
            '/repos/:owner/:repo/releases',
            $this->modx->toJSON(['tag_name' => $version, 'body' => $m]),
            ['Content-Type: application/json'],
            true
        );

        if (isset($release['tag_name']) && $release['tag_name'] === $version) {
            // build and upload release asset
            $this->build($version);

            $packageName = join('-', [self::PKG_NAME, $version, self::PKG_RELEASE]);
            $packageNameZip = join('.', [$packageName, 'transport', 'zip']);
            $packagePath = __DIR__ . '/../../../core/packages/' . $packageNameZip;

            $asset = $this->request(
                str_replace('{?name,label}', "?name=$packageNameZip", $release['upload_url']),
                file_get_contents($packagePath),
                ['Content-Type: application/zip']
            );

            if (isset($asset['name']) && $asset['name'] === $packageNameZip) {
                // remove uploaded package files
                unlink($packagePath);
                Utils::removeDirectory(__DIR__ . '/../../../core/packages/' . $packageName);
            }
        }
    }

    public function __invoke()
    {
        $package = self::PKG_NAME_HUMAN;
        $help = "
            \e[32mRelease Builder \e[0mfor package \e[34m{$package}
            
            \e[92mScript allows to build and install package locally with version 0.0.0-pl and also push releases to github
             
            \e[33mOptions: 
            \e[32m-h, --help          \e[0mDisplay this help message.
            
            \e[33mUsage:
              \e[0mphp Builder.php [command] [options]
              
            \e[33mAvailable commands:
              \e[32mbuild                           \t\t\e[0mBuilds current version of code to local package
              \e[32mpublish \e[36mdescription   \e[0mBuilds new version of package and releases it to github
                                            \t\t\e[0m<description> – Release notes \e[35m[required] \e[0m(\e[33mNote: \e[0muse quotes for description message)
              
            \e[33mOptions:  
              \e[32m-1            \t\t\e[0mMajor version will be increased
              \e[32m-2            \t\t\e[0mMinor version will be increased
              \e[32m-3            \t\t\e[0mPatch version will be increased [default]\n\n";
        $help = str_replace('            ', '', $help);

        if (isset($this->argv[1]) && ($this->argv[1] === '--help' || $this->argv[1] === '-h')) {
            echo $help;

            return;
        }

        if (isset($this->argv[1])) {
            // build package
            if ($this->argv[1] === 'build') {
                $this->build();
                $this->install();

                return;
            }

            // release package
            if ($this->argv[1] === 'publish') {
                // check if all committed
                $answer = shell_exec('git status');
                if (strpos($answer, 'Changes not staged for commit') !== false) {
                    echo "\033[31mError: Changes aren't recorded into repository. You should commit and push all changes before publishing.\033[0m\n";

                    return;
                }

                if (count($this->argv) < 3) {
                    echo "\033[31mError: Description of release are missed. Use '--help' option to get details\033[0m\n";

                    return;
                }

                $v = str_replace('-', '', $this->argv[3] ?? '3');
                if (!in_array($v, [1, 2, 3])) {
                    echo "\033[31mError: Passed invalid version parameter. Use '--help' option to get details\033[0m\n";

                    return;
                }

                $this->publish($v, $this->argv[2]);

                return;
            }
        }

        echo $help;

        return;
    }
}

// run builder
call_user_func(new Builder($argv));
