<?php

namespace Controllers;

use \Core\App;
use \Core\Controller;
use \Core\Response;
use \Core\View;

class Admin extends Controller
{
    public $view;

    public function __construct()
    {
        $this->view = new View(__CLASS__);
    }

    function list(): Response
    {   
        $result = App::getService('AdminService')->allUsers();
        
        if ($result) {
            $pageContent = $this->view->render('AllUsersTemplate.php', 'Список пользователей', $result);
        } else {
            $pageContent = $this->view->render('AutorizationErrorTemplate.php', 'Ошибка авторизации');
        }
        return new Response($pageContent);
    }

    function get(array $data): Response 
    {
        $result = App::getService('AdminService')->getUserById($data['id']);
        if ($result) {
            $pageContent = $this->view->render('GetUserTemplate.php', 'Список пользователей', $result);
        } else {
            $pageContent = $this->view->render('AutorizationErrorTemplate.php', 'Ошибка авторизации');
        }
        return new Response($pageContent);
    }

    function delete($data)
    {
        $result = App::getService('AdminService')->deleteUser($data['id']);
        if ($result) {
            $pageContent = $this->view->render('DeleteUserSuccessTemplate.php', 'Удаление пользователя');
        }
         else {
            $pageContent = $this->view->render('AutorizationErrorTemplate.php', 'Ошибка авторизации');
        }
        return new Response($pageContent);
    }

    function updateForm(array $data): Response
    {
        $result = App::getService('AdminService')->updateForm($data['id']);
        if ($result === false){
            $pageContent = $this->view->render('AutorizationErrorTemplate.php', 'Ошибка авторизации');
        } elseif(empty($result)) {
            $pageContent = $this->view->render('UserIdErrorTemplate.php', 'Обновление пользователя');
        } else {
            $pageContent = $this->view->render('UpdateFormTemplate.php', 'Обновление пользователя', $result);
        }
        return new Response($pageContent);
    }

    function update(array $data): Response
    {   
        $result = App::getService('AdminService')->updateUser($data);
        var_dump($result);
        if ($result){
            $pageContent = $this->view->render('UpdateSuccessTemplate.php', 'Обновление пользователя');
        } else {
            $pageContent = $this->view->render('AutorizationErrorTemplate.php', 'Ошибка авторизации');
        }
        return new Response($pageContent);
    }
}