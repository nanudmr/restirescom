<?php

namespace NitroPack\Integration\Hosting;

class Flywheel extends Hosting {
    const STAGE = "early";

    public static function detect() {
        return defined("FLYWHEEL_PLUGIN_DIR");
    }

    public function init($stage) {
        if ($this->getHosting() == "flywheel") {
            add_action('nitropack_execute_purge_url', [$this, 'purgeUrl']);
            add_action('nitropack_execute_purge_all', [$this, 'purgeAll']);
        }
    }

    public function purgeUrl($url) {
        try {
            $purger = new \NitroPack\SDK\Integrations\Varnish(array("127.0.0.1"), "PURGE");
            $purger->purge($url);
        } catch (\Exception $e) {
            // Breeze exception
        }
    }

    public function purgeAll() {
        try {
            if (function_exists("get_home_url")) {
                $home = get_home_url();
            } else {
                $siteConfig = nitropack_get_site_config();
                $home = "/";
                if ($siteConfig && !empty($siteConfig["home_url"])) {
                    $home = $siteConfig["home_url"];
                }
            }
            $purger = new \NitroPack\SDK\Integrations\Varnish(array("127.0.0.1"), "PURGE");
            $purger->purge($home);
        } catch (\Exception $e) {
            // Exception
        }
    }
}
