<?php


namespace Controllers;

use \Core\App;
use \Core\Response;
use \Core\View;

class General extends \Core\Controller
{
    public $view;

    public function __construct()
    {
        $this->view = new View(__CLASS__);
    }

    function main(): Response
    {   
        $data = App::getService('GeneralService')->main();
        $pageContent = $this->view->render('MainTemplate.php', 'Главная', $data);
        return new Response($pageContent);
    }
}