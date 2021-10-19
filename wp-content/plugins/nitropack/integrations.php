<?php

spl_autoload_register(function($class) {
    $filename = str_replace("\\", "/", $class) . ".php";
    $filename = str_replace("NitroPack/", "", $filename);
    $filepath = NITROPACK_CLASSES_DIR . ltrim($filename, "/");
    if (file_exists($filepath)) {
        require_once $filepath;
    }
});

if (\NitroPack\Integration\Hosting\WPEngine::detect()) {
    define("NITROPACK_USE_MICROTIMEOUT", 20000);
}

$integration = NitroPack\Integration::getInstance();
$integration->init();
