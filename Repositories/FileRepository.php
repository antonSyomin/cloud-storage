<?php


namespace Repositories;

use Core\Repository;
use Core\Logger;

class FileRepository extends Repository
{
    protected static $tableName = 'file';

    public static function update(int $id, array $data): bool
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
                "UPDATE " . static::$tableName . " SET
                id = :id,
                title = :title, 
                directory = :directory, 
                readers = :readers,
                owner = :owner, 
                changed = :changed, 
                size = :size
                WHERE id = :id");

            foreach($currentData as $key => $value) {
                $query->bindValue($key, $newData[$key]);
            }
            $query->execute($newData);
            return true;
        } catch(\PDOException $e) {
            Logger::log("Не удалось обновить запись в таблице " . static::$tableName);
            Logger::log($e->getMessage() . "\n");
            return false;
        }
    }

    public static function create(array $data): bool
    {
        try
        {   
            $query = self::$connection->prepare(
                "INSERT INTO " .
                static::$tableName . " (id, title, directory, owner, readers, changed, size) 
                VALUES (null, :title, :directory, :owner, :readers, :changed, :size)");
            $query->execute($data);
            return true;
        } catch(\PDOException $e) {
            Logger::log("Не удалось создать запись в таблице " . static::$tableName);
            Logger::log($e->getMessage() . "\n");
            return false;
        } catch(\Exception $e) {
            Logger::log("Неопознанная ошибка при попытке создать запись в таблице " . static::$tableName); 
            Logger::log($e->getMessage() . "\n");    
            return false;  
        }
    }
}