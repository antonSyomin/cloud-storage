<?php


namespace Repositories;

use Core\Repository;
use Core\Logger;

class DirectoryRepository extends Repository
{
    static protected $tableName = 'directory';

    static public function create(array $data): bool
    {
        try
        {   
            $query = self::$connection->prepare(
                "INSERT INTO " .
                static::$tableName . " (id, title, files, owner) 
                VALUES (null, :title, :files, :owner)");
            $query->execute($data);
            return true;
        } catch(\PDOException $e) {
            Logger::log($e->getMessage() . "\n"); 
            Logger::log("Не удалось создать запись в таблице " . static::$tableName);
            return false;
        } catch(\Exception $e) {
            Logger::log($e->getMessage() . "\n"); 
            Logger::log("Неопознанная ошибка при попытке создать запись в таблице " . static::$tableName); 
            return false;     
        }
    }

    static public function update(int $int, array $data): bool
    {
        try
        {
            $currentData = self::find($data['id']);
            $newData = [];
            foreach ($currentData as $key => $value) {
                if (key_exists($key, $data)) {
                    $newData[$key] = $data[$key];
                } else {
                    $newData[$key] = $currentData[$key];
                }
            }
 
            $query = self::$connection->prepare(
                "UPDATE directory SET
                id = :id,
                title = :title, 
                files = :files, 
                owner = :owner
                WHERE id = :id");

            foreach($currentData as $key => $value) {
                $query->bindValue($key, $newData[$key]);
            }
            $query->execute($newData);
            return true;
        } catch(\PDOException $e) {
            Logger::log($e->getMessage() . "\n"); 
            Logger::log("Не удалось обновить запись в таблице directory");
            return false;
        }
    }

    static public function delete(int $id): bool
    {
        try {
            $deleteUser = self::$connection->prepare("DELETE FROM " . static::$tableName . " WHERE id = :id");
            $deleteUser->execute(['id' => $id]);
            return true;
        } catch (\Exception $e) {
            Logger::log($e->getMessage() . "\n"); 
            Logger::log("Не получилось удалить запись");
            return false;
        }
    }
}