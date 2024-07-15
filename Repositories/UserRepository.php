<?php


namespace Repositories;

use Core\Repository;
use Core\Logger;

class UserRepository extends Repository
{
    static protected $tableName = 'user';

    static public function create(array $data): bool
    {
        try
        {   
            $query = self::$connection->prepare(
                "INSERT INTO " .
                self::$tableName . " WHERE (id, email, password, role, age, sex) 
                values(null, :email, :password, :role, :age, :sex)");
            $query->execute($data);
            return true;
        } catch(\PDOException $e) {
            Logger::log("Не удалось создать запись в таблице " . self::$tableName);
            Logger::log($e->getMessage());
            return false;
        } 
    }

    static public function update(int $id, array $data): bool
    {
        try
        {
            $currentData = self::find($id);
            $newData = [];
            foreach ($currentData as $key => $value) {
                if (key_exists($key, $data) && $data[$key]) {
                    $newData[$key] = $data[$key];
                } else {
                    $newData[$key] = $currentData[$key];
                }
            }
            
            $query = self::$connection->prepare(
                "UPDATE " . self::$tableName . " SET
                id = :id,
                email = :email, 
                password = :password, 
                role = :role, 
                age = :age, 
                sex = :sex
                WHERE id = :id");

            foreach($currentData as $key => $value) {
                $query->bindValue($key, $newData[$key]);
            }
            $query->execute($newData);
            return true;
        } catch(\PDOException $e) {
            Logger::log("Не удалось обновить запись в таблице " . self::$tableName);
            Logger::log($e->getMessage());
            return false;
        }
    }
}