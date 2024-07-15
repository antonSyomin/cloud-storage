<?php


namespace Services;

require_once __DIR__ . "/../config.php";

use Core\Service;
use Repositories\UserRepository;

class GeneralService implements Service
{
    private $repository;

    function __construct()
    {   
        $db = \Core\Db::get();
        $db->setSettings(DB_SETTINGS); 
        $this->repository = new UserRepository($db);
    }

    function main()
    {
        $email = key_exists('logged', $_COOKIE) ? 
        $this->repository->find($_COOKIE['logged'])['email'] : [];
        
        return [
            "email" => $email
        ];
    }
}