<?php


namespace Core;

class Db
{
    private static ?Db $_instance;
    private ?\PDO $pdo_connection;
    private string $dsn;
    private string $user;
    private string $password;

    private function __clone()
    {
        
    } 

    public static function get(): Db
    {
        self::$_instance ??= new self();
        return self::$_instance;
    }

    public function setSettings(array $settings): mixed
    {
        try {
            $this->dsn = $settings['dsn'];
            $this->user = $settings['user'];
            $this->password = $settings['password'];
            $this->pdo_connection = new \PDO($this->dsn, $this->user, $this->password);
            return $this->pdo_connection;
        } catch (\Exception $e) {
            var_dump($e);
            return null;
        }
    }

    function getConnection(): \PDO
    {
        return $this->pdo_connection;
    }

    function getDSN(): string 
    {
        return $this->dsn;
    }

    function getUser(): string 
    {
        return $this->user;
    }

    function getPassword(): string 
    {
        return $this->password;
    }
}