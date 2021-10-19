<?php

namespace NitroPack;

class Integration {
    private static $instance = NULL;
    private static $purgeAllPending = false;
    private static $purgeUrlPending = [];
    private static $isInitialized = false;
    private static $isInitializedStage = [];
    private static $modules = [
        "NitroPack/Integration/Hosting/Cloudways",
        "NitroPack/Integration/Hosting/Flywheel",
        "NitroPack/Integration/Hosting/WPEngine",
        "NitroPack/Integration/Hosting/SiteGround",
        "NitroPack/Integration/Hosting/GoDaddyWPaaS",
        "NitroPack/Integration/Hosting/Kinsta",
        "NitroPack/Integration/Hosting/Pagely",
        "NitroPack/Integration/Server/LiteSpeed",
        "NitroPack/Integration/Server/Fastly",
        "NitroPack/Integration/Server/Cloudflare",
        "NitroPack/Integration/Plugin/NginxHelper",
        "NitroPack/Integration/Plugin/Cloudflare",
        "NitroPack/Integration/Plugin/ShortPixel",
        "NitroPack/Integration/Plugin/WPCacheHelper",
        "NitroPack/Integration/Plugin/CookieNotice",
        "NitroPack/Integration/Plugin/BeaverBuilder"
    ];
    private static $loadedModules = [];
    private static $stage = "very_early";
    private $siteConfig = [];
    private $purgeUrls = [];
    private $fullPurge = false;

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new Integration();
        }
        return self::$instance;
    }

    public function __construct() {
        $this->siteConfig = nitropack_get_site_config();
    }

    public function getHosting() {
        return $this->siteConfig && !empty($this->siteConfig["hosting"]) ? $this->siteConfig["hosting"] : "unknown";
    }

    public function init() {
        if (self::$isInitialized) return true;

        add_action( 'nitropack_integration_purge_url', [$this, "logUrlPurge"] );
        add_action( 'nitropack_integration_purge_all', [$this, "logFullPurge"] );
        add_action( 'shutdown', [$this, 'executeIntegrationPurges'], -999 );

        $this->initModules(); // very_early init

        $action = $this->getSetupAction();
        if (did_action($action)) {
            $this->initModules();
        } else {
            add_action($action, [$this, 'initModules']);
        }

        self::$isInitialized = true;
    }

    public function logUrlPurge($url) {
        $this->purgeUrls[] = $url;
    }

    public function logFullPurge() {
        $this->fullPurge = true;
    }

    public function initModules() {
        if (!empty(self::$isInitializedStage[self::$stage])) return true;

        foreach (self::$modules as $moduleName) {
            $module = $this->loadModule($moduleName);
            if ($module && $module->init(self::$stage)) {
                // Modules which need to be initialized only once return NULL so they don't end up in this array
                // This array holds only modules which need to have their init method called for each stage
                self::$loadedModules[$moduleName] = $module;
            }
        }

        self::$isInitializedStage[self::$stage] = true;

        if (self::$stage == "very_early") {
            self::$stage = "early";
        } else if (self::$stage == "early") {
            if ($this->siteConfig && empty($this->siteConfig["isLateIntegrationInitRequired"])) {
                do_action(NITROPACK_INTEGRATIONS_ACTION);
            }

            // This is needed in order to load non-cache-related integrations like the one with ShortPixel and WooCommerce Geo Location.
            if (did_action('plugins_loaded')) {
                $this->lateInitModules();
            } else {
                add_action('plugins_loaded', [$this, 'lateInitModules']);
            }
        } else {
            if ($this->siteConfig && !empty($this->siteConfig["isLateIntegrationInitRequired"])) {
                do_action(NITROPACK_INTEGRATIONS_ACTION);
            }
        }
    }

    public function lateInitModules() {
        self::$stage = "late";
        $this->initModules();
    }

    public function executeIntegrationPurges() {
        if ($this->fullPurge) {
            do_action("nitropack_execute_purge_all");
        } else {
            foreach (array_unique($this->purgeUrls) as $url) {
                do_action("nitropack_execute_purge_url", $url);
            }
        }
    }

    private function loadModule($name) {
        if (isset(self::$loadedModules[$name])) return self::$loadedModules[$name];

        $class = str_replace("/", "\\", $name);
        if ($class::STAGE == self::$stage) {
            $module = new $class();
            return $module;
        } else {
            return NULL;
        }
    }

    private function getSetupAction() {
        if ($this->siteConfig && !empty($this->siteConfig["isLateIntegrationInitRequired"])) {
            return "plugins_loaded";
        }

        return "muplugins_loaded";
    }
}
