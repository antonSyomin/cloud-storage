<?php

function universalLoader($path) {
    if (preg_match('/\\\\/', $path)) {
        $path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
    }
    $path = __DIR__ . DIRECTORY_SEPARATOR . $path . ".php";
    if (file_exists($path)) {
        require_once($path);
    }
}

spl_autoload_register('universalLoader');