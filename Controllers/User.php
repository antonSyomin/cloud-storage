<?php


namespace Controllers;

use \Core\App;
use \Core\Response;
use \Core\View;

class User
{    
    public $view;

    public function __construct()
    {
        $this->view = new View(__CLASS__);
    }

    public function list(): Response
    {   
        $result = App::getService('UserService')->allUsers();
        return new Response($result);
    }

    public function get(array $data): Response
    {           
        $result = App::getService('UserService')->getUserById($data['id']);
        return new Response($result);
    }

    public function updateForm(): Response
    {
        $result = App::getService('UserService')->getUserData();
        if (isset($result['id'])){
            $pageContent = $this->view->render('UpdateFormTemplate.php', 'Обновление данных', $result);
        } else {
            $pageContent = $this->view->render('AutorizationErrorTemplate.php', 'Ошибка авторизации');
        }
        return new Response($pageContent);
    }

    public function update(array $data): Response
    {   
        $result = App::getService('UserService')->updateUser($data);
        if ($result) {
            $result = $this->view->render('UpdateSuccessTemplate.php', 'Обновление данных');
        }
        return new Response($result);
    }

    public function loginForm(): Response
    {
        $pageContent = $this->view->render('LoginFormTemplate.php', 'Вход в систему');
        return new Response($pageContent);
    }

    public function login(array $data): Response
    {
        $result = App::getService('UserService')->login($data['email'], $data['password']);
        $response = new Response();

        if ($result) {
            $response->setHeader('Location: http://www.cloud-storage.local/main');
        } else {
            $pageContent = $this->view->render('AutorizationFailureTemplate.php', 'Ошибка входа в систему');
            $response->setData($pageContent);
        }
        return $response;
    }

    public function logout(): Response
    {   
        App::getService('UserService')->logout();
        $response = new Response();
        $response->setHeader("Location: http://www.cloud-storage.local/main");
        return $response;
    }

    public function resetPasswordRequestForm(): Response
    {
        $result = App::getService('UserService')->getUserData();
        if ($result){
            $pageContent = $this->view->render('ResetPasswordRequestFormTemplate.php', 'Обновление пароля', $result);
        } else {
            $pageContent = $this->view->render('AutorizationErrorTemplate.php', 'Ошибка авторизации');
        }
        return new Response($pageContent);
    }

    public function resetPasswordLink(array $data): Response
    {   
        $result = App::getService('UserService')->sendResetPasswordLink($data['email']);
        if ($result) {
            $result = $this->view->render('SentLinkTemplate.php', 'Обновление пароля');
        }
        
        return new Response($result);
    }

    public function resetPasswordForm(array $data): Response
    {   
        $pageContent = $this->view->render('ResetPasswordFormTemplate.php', 'Обновление пароля', $data);
        return new Response($pageContent);
    }

    public function resetPasswordFormHandler($data): Response
    {   
        $result = App::getService('UserService')->resetPassword($data['id'], $data['old_pass'], $data['new_pass']);
        if ($result) {
            $pageContent = $this->view->render('ResetPasswordSuccessTemplate.php', 'Обновление пароля', $data);
        } else {
            $pageContent = $this->view->render('ResetPasswordFailureTemplate.php', 'Обновление пароля');
        }
        
        return new Response($pageContent);
    }

    // public function search(array $data)
    // {
    //     $result = App::getService('UserService')->getUserByEmail($data['email']);
    //     return new Response($result);
    // }
}