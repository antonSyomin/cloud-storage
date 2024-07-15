<?php


namespace Core;

class App
{
    public static $locator = [];
    private static $serviceDirectories = ['Services', 'Repositories'];
    private static $dbConnection;

    static public function init()
    {
        foreach (self::$serviceDirectories as $directory) {
            $directoryDescriptor = opendir(__DIR__ . '/../' . $directory);
            while(false !== ($classFile = readdir($directoryDescriptor))) {
                $classNameGroups = explode('.', $classFile);
                $className = $classNameGroups[0];
                if ($classFile == '.' || $classFile == '..') continue;
                $obj = new ($directory . '\\' . substr($classFile, 0, strpos($classFile, '.php')))();
                self::$locator[$className] = $obj;
            };
        }
    }

    public static function getService(string $serviceName): Service | Repository
    {
        if (isset(self::$locator[$serviceName])) {
            return self::$locator[$serviceName];
        } else {
            throw new \Exception("Сервис {$serviceName} не зарегистрирован");
        }
    }

    public static function addDbConnection(\PDO $connection)
    {
        self::$dbConnection = $connection;
    }

    public static function getDbConnection()
    {
        return self::$dbConnection;
    }
}