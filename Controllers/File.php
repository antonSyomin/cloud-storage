<?php

namespace Controllers;

use \Core\App;
use \Core\Response;
use \Core\View;

class File
{
    private $view; 

    public function __construct()
    {
        $this->view = new View(__CLASS__);
    }

    public function listFiles(): Response
    {
        $result = App::getService('FileService')->allFiles();
        return new Response($result);
    }

    public function getFile(array $data): Response
    {
        $result = App::getService('FileService')->getFileById($data);
        return new Response($result);
    }

    public function addFileForm(): Response
    {
        if (App::getService('FileService')->isAutorised()) {
            $pageContent = $this->view->render('AddFileTemplate.php', 'Сохранение файла', ['userId' => $_COOKIE['logged']]);
        } else {
            $pageContent = $this->view->render('AutorizationErrorTemplate.php', 'Ошибка авторизации');
        }   
        return new Response($pageContent);
    }

    public function addFile(array $data): Response
    {
        $result = App::getService('FileService')->addFile($data);
        if ($result) {
            $pageContent = $this->view->render('AddFileSuccessTemplate.php', 'Сохранение файла');
        } else {
            $pageContent = $this->view->render('AddFileFailureTemplate.php', 'Сохранение файла');
        } 
        return new Response($pageContent);
    }

    public function renameFileForm(array $data): Response
    {   
        $result = App::getService('FileService')->getFileData($data['id']);
        if ($result) {
            $pageContent = $this->view->render('RenameFileFormTemplate.php', 'Переименование файла', $data);
        } elseif($result === []) {
            $pageContent = $this->view->render('FindFileErrorTemplate.php', 'Переименование файла', $data);
        } else {
            $pageContent = $this->view->render('AutorizationErrorTemplate.php', 'Ошибка авторизации', $data);
        }
        return new Response($pageContent);
    }

    public function renameFile(array $data): Response
    {
        $result = App::getService('FileService')->renameFile($data);
        if ($result) {
            $pageContent = $this->view->render('RenameFileSuccessTemplate.php', 'Переименование файла');
        } else {
            $pageContent = $this->view->render('RenameFileFailureTemplate.php', 'Переименование файла');
        }
        return new Response($pageContent);
    }

    public function removeFile(array $data): Response
    {
        $result = App::getService('FileService')->removeFile($data['id']);
        if ($result) {
            $pageContent = $this->view->render('RemoveSuccessTemplate.php', 'Удаление файла');
        } elseif($result === []) {
            $pageContent = $this->view->render('FindFileErrorTemplate.php', 'Удаление файла');
        } else {
            $pageContent = $this->view->render('AutorizationErrorTemplate.php', 'Ошибка авторизации');
        }
        return new Response($pageContent);
    }

    public function addDirForm(): Response 
    {   
        if (App::getService('FileService')->isAutorised()) {
            $pageContent = $this->view->render('AddDirTemplate.php', 'Добавление папки', ['userId' => $_COOKIE['logged']]);
        } else {
            $pageContent = $this->view->render('AutorizationErrorTemplate.php', 'Ошибка авторизации');
        }
        return new Response($pageContent);
    }

    public function addDir(array $data): Response
    {
        $result = App::getService('FileService')->addDir($data);
        if ($result) {
            $pageContent = $this->view->render('AddFileSuccessTemplate.php', 'Добавление папки');
        } else {
            $pageContent = $this->view->render('AutorizationErrorTemplate.php', 'Ошибка авторизации');
        }
        
        return new Response($pageContent);
    }

    public function renameDirForm(array $data): Response
    {   
        $result = App::getService('FileService')->getDirRenameForm($data);
        if ($result) {
            $pageContent = $this->view->render('RenameDirFormTemplate.php', 'Переименование папки', $data);
        } elseif ($result === false) {
            $pageContent = $this->view->render('AutorizationErrorTemplate.php', 'Ошибка авторизации', $data);
        } else {
            $pageContent = $this->view->render('FindFileErrorTemplate.php', 'Переименование папки', $data);
        }

        return new Response($pageContent);
    }

    public function renameDir(array $data): Response
    {
        $result = App::getService('FileService')->renameDir($data);
        $response = new Response();
        if ($result) {
            $pageContent = $this->view->render('RenameFileSuccessTemplate.php', 'Переименование папки');
            $response->setData($pageContent);
        }
        return $response;
    }

    public function getDirInfo(array $data): Response
    {
        $result = App::getService('FileService')->getDirById($data);
        return new Response($result);
    }

    public function removeDir(array $data): Response
    {
        $result = App::getService('FileService')->removeDir($data);
        if ($result) {
            $pageContent = $this->view->render('RemoveSuccessTemplate.php', 'Удаление папки');
        } elseif($result === false) {
            $pageContent = $this->view->render('AutorizationErrorTemplate.php', 'Ошибка авторизации', $data);
        } else {
            $pageContent = $this->view->render('FindFileErrorTemplate.php', 'Удаление папки', $data);
        }

        return new Response($pageContent);
    }

    public function shareList(array $data): Response
    {
        $result = App::getService('FileService')->getReadersList($data);
        return new Response($result);
    }

    public function shareAdd(array $data): Response
    {
        $result = App::getService('FileService')->addReader($data);
        return new Response($result);
    }

    public function shareDelete(array $data): Response
    {
        $result = App::getService('FileService')->deleteReader($data);
        return new Response($result);
    }
}