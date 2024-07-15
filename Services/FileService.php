<?php

namespace Services;

require_once __DIR__ . "/../config.php";

use \Core\Service;
use \Core\App;
use \Repositories\Directory;

class FileService implements Service
{
    private $diskRoot = 'disk/';

    public function allFiles(): array|bool
    {
        return App::getService('FileRepository')->all();    
    }

    public function getFileById(array $data): array|bool
    {
        return App::getService('FileRepository')->find($data['id']);
    }

    private function extPath2System(string $extPath): string
    {   
        return __DIR__ . '/../' . $this->diskRoot . $extPath;
    }

    public function isAutorised(): bool
    {
        return isset($_COOKIE['logged']);
    }

    public function addFile(array $data): bool
    {
        $title = explode('.', $_FILES['upload_file']['name'])[0];
        $ext = explode('.', $_FILES['upload_file']['name'])[1];
        $date = date("Y-m-d H:i:s");
        
        if (file_exists($this->extPath2System($title . '.' . $ext))) {
            $filesCounter = 1;  
            while (file_exists($this->extPath2System($title . '_' . $filesCounter . '.' . $ext))) {
                $filesCounter++;
            }
            $title .= '_' . $filesCounter;
        }

        if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $this->extPath2System($title . '.' . $ext))) {
            return App::getService('FileRepository')->create(
                [
                    'title' => $title . '.' . $ext,
                    'directory' => $this->diskRoot,
                    'owner' => $data['id'],
                    'readers' => json_encode([$data['id']]),
                    'changed' => $date,
                    'size' => $_FILES['upload_file']['size']
                ]
            );
        } else {
            return false;
        }
    }

    public function getFileData(int $id): array|bool
    {
        if (isset($_COOKIE['logged'])) {
            $fileInfo = App::getService('FileRepository')->find($id);
            if (empty($fileInfo)) {
                return false;
            }
            return $_COOKIE['logged'] == $fileInfo['owner'] ? $fileInfo : false;
        }
    }

    public function renameFile(array $data): bool
    {   
        $fileInfo = App::getService('FileRepository')->find($data['id']);
        if (!empty($fileInfo)) {
            App::getService('FileRepository')->update($data['id'], $data);
            rename($this->extPath2System($fileInfo['title']), $this->extPath2System($data['title']));
            return true;
        }
        return false;
    } 
    
    public function removeFile(int $id): array|bool
    {
        $fileInfo = App::getService('FileRepository')->find($id);
        if (!$fileInfo) {
            return [];
        }

        if (isset($_COOKIE['logged']) 
        && $_COOKIE['logged'] == $fileInfo['owner']) {
            App::getService('FileRepository')->delete($id);
            return true;
        } else {
            return false;
        }
    }

    public function getAddDirForm(): array
    {
        if (isset($_COOKIE['logged'])) {
            return [
                'userId' =>  $_COOKIE['logged']
            ];
        } 
        return [];
    }

    public function addDir(array $data): bool
    {   
        $dirTitle = $data['dirTitle'];
        
        if (file_exists($this->extPath2System($dirTitle))) {
            $filesCounter = 1;  
            while (file_exists($this->extPath2System($dirTitle . '_' . $filesCounter))) {
                $filesCounter++;
            }
            $dirTitle .= '_' . $filesCounter;
        }

        $result = App::getService('DirectoryRepository')->create(
            [
                'title' => $dirTitle,
                'files' => json_encode([]),
                'owner' => $data['id']
            ]
        );

        if ($result) {
            mkdir($this->extPath2System($dirTitle));
            return true;
        } else {
            return false;
        }
    }

    public function getDirRenameForm(array $data): array
    {
        $dirInfo = App::getService('DirectoryRepository')->find($data['id']);
        if (empty($dirInfo) || is_null($dirInfo)) {
            return [];
        }

        if (isset($_COOKIE['logged']) 
        && $_COOKIE['logged'] == $dirInfo['owner']) {
            return true;
        } else {
            return false;
        }
    }

    public function renameDir(array $data): bool
    {   
        $dirInfo = App::getService('DirectoryRepository')->find($data['id']);
        if(App::getService('DirectoryRepository')->update($data['id'], $data)) {
            rename($this->extPath2System($dirInfo['title']), $this->extPath2System($data['title']));
            return true;
        } else {
            return false;
        }
    } 

    public function getDirById(array $data): array
    {
        return App::getService('DirectoryRepository')->find($data['id']);
    }

    public function removeDir(array $data): array
    {
        $fileInfo = App::getService('DirectoryRepository')->find($data['id']);

        if (empty($fileInfo) || is_null($fileInfo)) {
            return [];
        }

        if (isset($_COOKIE['logged']) 
        && $_COOKIE['logged'] == $fileInfo['owner']) {
            App::getService('DirectoryRepository')->delete($data['id']);
            rmdir($this->extPath2System($fileInfo['title']));
            return true;
        } else {
            return false;
        }
    }

    public function getReadersList(array $data): array|bool
    {
        $fileInfo = App::getService('FileRepository')->find($data['id']);
        if($fileInfo){
            return ['readers' => json_decode($fileInfo['readers'])];
        }
        return false;
    }

    public function addReader(array $data): array|bool
    {
        $fileInfo = App::getService('FileRepository')->find($data['id']);
        if($fileInfo){
            $readers = json_decode($fileInfo['readers']);
            if(in_array($data['user_id'], $readers)) {
                return true; 
            } else {
                $fileInfo['readers'] = json_encode($readers);
                return App::getService('FileRepository')->update($data['id'], $fileInfo);
            } 
        }
        return false;
    }

    public function deleteReader(array $data): array|bool
    {
        $fileInfo = App::getService('FileRepository')->find($data['id']);
        if($fileInfo){
            $readers = json_decode($fileInfo['readers']);
            if(in_array($data['user_id'], $readers)) {
                $key = array_search($data['user_id'], $readers);
                unset($readers[$key]);
                $fileInfo['readers'] = json_encode($readers);
                return App::getService('FileRepository')->update($data['id'], $fileInfo); 
            } else {
                return false;
            }
        }
        return false;
    }
}