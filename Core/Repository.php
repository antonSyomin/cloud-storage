<?php


namespace Core;

use \Core\App;

abstract class Repository 
{
    static protected $connection;
    static protected $tableName;

    public function __construct()
    {   
        self::$connection = App::getDbConnection();
    }

    public static function all(): array|bool
    {
        try
        {
            $query = self::$connection->prepare("SELECT * FROM " . static::$tableName);  
            $query->execute();
            $allEntites = $query->fetchAll(\PDO::FETCH_ASSOC);
            return $allEntites;
        } catch(\PDOException $e) {
            Logger::log($e->getMessage() . "\n");
            Logger::log("Не удалось получить записи из таблицы " . static::$tableName . "\n");
            return false;
        }
    }
 
    public static function find(int $id): array|bool
     {  
        try
        {  
            $query = self::$connection->prepare("SELECT * FROM " . static::$tableName . " WHERE id = :id");
            $query->bindValue('id', $id);
            $query->execute();
            $user = $query->fetch(\PDO::FETCH_ASSOC);
            if ($user) {
                return $user;
            } else {
                return [];
            }
        } catch(\PDOException $e) {
            Logger::log($e->getMessage() . "\n");
            Logger::log("Не удалось получить запись из таблицы " . static::$tableName . "\n");
            return false;
        }
     }

    public static function findBy(string $key, mixed $value)
    {
        try {
            $query = self::$connection->prepare("SELECT * FROM " . static::$tableName . " WHERE {$key} = :value");
            $query->bindValue('value', $value);
            $query->execute();
            $result = $query->fetch(\PDO::FETCH_ASSOC);
            return $result;
        } catch (\PDOException $e) {
            Logger::log($e->getMessage());
            Logger::log("Не удалось получить запись из таблицы " . static::$tableName . "\n");
            return false;
        }
    }
    
    public static function delete(int $id): bool
    {
        try {
            $deleteUser = self::$connection->prepare("DELETE FROM " . static::$tableName . " WHERE id = :id");
            $deleteUser->execute(['id' => $id]);
            return true;
        } catch (\Exception $e) {
            Logger::log($e->getMessage());
            Logger::log("Не получилось удалить запись\n");
            return false;
        }
    }

    public static abstract function create(array $data): bool;

    public static abstract function update(int $id, array $data): bool;
}