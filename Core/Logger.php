<?php


namespace Core;

class Logger
{
    static public function log(string $msg)
    {
        $currentTime = date('Y-m-d H:i:s');
        $log =  "{$currentTime} {$msg}" . PHP_EOL;
        
        $currentDate = date('Y-m-d');
        file_put_contents(__DIR__ . "/../logs/{$currentDate}.txt", $log, FILE_APPEND);
    }
}