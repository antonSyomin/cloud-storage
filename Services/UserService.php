<?php

namespace Services;

use \Core\App;
use \Core\Logger;
use \Core\Service;

class UserService implements Service
{
    public function allUsers(): array|bool
    {
        return App::getService('UserRepository')->all();    
    }

    public function getUserById(int $id): array|bool
    {
        return App::getService('UserRepository')->find($id);
    }

    public function updateUser(array $data)
    {
        $result = App::getService('UserRepository')->findBy('email', $data['email']);
        $result['id'] = $_COOKIE['logged'];   
        return App::getService('UserRepository')->update($result['id'], $data);
    }

    public function login(string $email, string $password): bool|null
    {   
        $result = App::getService('UserRepository')->findBy('email', $email);

        if (!empty($result)) {
            if ($password == $result['password']) {
                setcookie('logged', $result['id'],  time() + 3600 * 24);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function logout(): void
    {
        setcookie('logged', 'no', time() - 3600 * 24, "/");
    }

    public function sendResetPasswordLink($email): bool
    {
        try {
            $this->sendEmail($email);
            return true;
        } catch(\Exception $e) {
            Logger::log($e->getMessage());
            return false;
        }
    }

    private function sendEmail(string $email): void
    {
        $mail = new \PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl';

        $mail->CharSet = "utf-8";
        $mail->Port = 465;

        $mail->Host = 'smtp.yandex.ru';
        $mail->Username = 'semin95crpt';
        $mail->Password = 'EkzzaA75s_';
        $mail->Subject = "Сменя пароля от учетной записи cloud-storage";

        $mail->setFrom('semin95crpt@yandex.ru', 'cloud-storage.local', 0);
        $mail->addAddress($email);
        $mail->msgHTML("<H1>Ссылка для изменения пароля</H1><p><a href='http://www.cloud-storage.local/reset_password/form?id=" . $_COOKIE['logged'] . "'>http://www.cloud-storage.local/reset_password/form</a></p>");

        $mail->send();
    }

    public function resetPassword(int $id, string $oldPassword, string $newPassword): bool
    {
        $userInfo = App::getService('UserRepository')->find($id);
        if ($userInfo['password'] !== $oldPassword) {
            return false;
        } else {
            App::getService('UserRepository')->update($id, ['password' => $newPassword, 'id' => $id]);
            return true;
        } 
    }

    public function getUserData(): array|bool
    {
        return isset($_COOKIE['logged']) ? $this->getUserById($_COOKIE['logged']) : false;
    }
}