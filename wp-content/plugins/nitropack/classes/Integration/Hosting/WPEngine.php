<?php

namespace NitroPack\Integration\Hosting;

class WPEngine extends Hosting {
    const STAGE = "early";

    public static function detect() {
        return !!getenv('IS_WPE');
    }

    public function init($stage) {
        if ($this->getHosting() == "wpengine") {
            add_action('nitropack_execute_purge_url', [$this, 'purgeUrl']);
            add_action('nitropack_execute_purge_all', [$this, 'purgeAll']);
        }
    }

    public function purgeUrl($url) {
        try {
            $handler = function($paths) use($url) {
                $wpe_path = parse_url($url, PHP_URL_PATH);
                $wpe_query = parse_url($url, PHP_URL_QUERY);
                $varnish_path = $wpe_path;
                if (!empty($wpe_query)) {
                    $varnish_path .= '?' . $wpe_query;
                }
                if ($url && count($paths) == 1 && $paths[0] == ".*") {
                    return array($varnish_path);
                }
                return $paths;
            };
            add_filter( 'wpe_purge_varnish_cache_paths', $handler );
            if (class_exists("\WpeCommon")) { // We need to have this check for clients that switch hosts
                \WpeCommon::purge_varnish_cache();
            }
            remove_filter( 'wpe_purge_varnish_cache_paths', $handler );
        } catch (\Exception $e) {
            // WPE exception
        }
    }

    public function purgeAll() {
        try {
            if (class_exists("\WpeCommon")) { // We need to have this check for clients that switch hosts
                \WpeCommon::purge_varnish_cache();
            }
        } catch (\Exception $e) {
            // WPE exception
        }
    }
}
