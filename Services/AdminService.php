<?php


namespace Services;

use \Core\App;
use Core\Service;

class AdminService implements Service
{
    public function allUsers(): array|bool
    {   
        return $this->isAdmin() ? App::getService('AdminRepository')->all() : false;
    }

    public function getUserById(int $id): array|bool
    {
        return $this->isAdmin() ? App::getService('AdminRepository')->find($id) : false;
    }

    public function deleteUser(int $id): array|bool
    {
        return $this->isAdmin() ? App::getService('AdminRepository')->delete($id) : false;
    }

    public function updateForm(int $id): bool|array
    {
        return $this->isAdmin() ? App::getService('AdminRepository')->find($id) : false;
    }

    public function updateUser(array $data): bool|array
    {
        return $this->isAdmin() ? App::getService('AdminRepository')->update($data['id'], $data) : false;
    }

    public function isAdmin(): bool
    {
        if (isset($_COOKIE['logged'])) {
            $userInfo = App::getService('AdminRepository')->find($_COOKIE['logged']);
            return $userInfo['role'] == 'admin';
        }
        return false;
    }
}