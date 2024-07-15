<?php


require_once 'config.php';
require_once __DIR__ . "/routes.php";
require_once __DIR__ . '/vendor/autoload.php';
spl_autoload_register();

$dbConection = Core\Db::get()->setSettings(DB_SETTINGS);

Core\App::addDbConnection($dbConection);
Core\App::init();

$request = new Core\Request($_SERVER['REDIRECT_URL'], $_SERVER['REQUEST_METHOD'], $_REQUEST);
$response = Core\Router::processRequest($request);

$response->render();


