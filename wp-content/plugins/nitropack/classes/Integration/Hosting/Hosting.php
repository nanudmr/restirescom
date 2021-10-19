<?php

namespace NitroPack\Integration\Hosting;

class Hosting {
    protected function getHosting() {
        $siteConfig = nitropack_get_site_config();
        if ($siteConfig && !empty($siteConfig["hosting"])) {
            $hosting = $siteConfig["hosting"];
        } else {
            $hosting = nitropack_detect_hosting();
        }

        return $hosting;
    }
}
