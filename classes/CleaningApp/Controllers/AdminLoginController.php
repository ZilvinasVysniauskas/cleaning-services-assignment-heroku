<?php

namespace CleaningApp\Controllers;

use Common\Authentication;
use Common\DatabaseTable;

class AdminLoginController
{
    private $adminLogDetailsTable;
    private $authentication;

    public function __construct(DatabaseTable $adminLogDetailsTable, Authentication $authentication)
    {
        $this->adminLogDetailsTable = $adminLogDetailsTable;
        $this->authentication = $authentication;
    }

    public function loginPage(){
        return [
            'title' => 'admin',
            'templates' => [
                'output' => ['template' => 'adminLogin.html.php']
            ]
        ];
    }
    public function logout(){
        $this->authentication->logout();
    }

    public function checkAdminLogDetails(){
        $adminName = htmlentities($_POST['adminName'], ENT_QUOTES, 'UTF-8');
        $adminPassword = htmlentities($_POST['adminPassword'], ENT_QUOTES, 'UTF-8');
        $adminLogDetails = $this->adminLogDetailsTable->findById($adminName);
        if (count($adminLogDetails) > 0){
            if (password_verify($adminPassword, $adminLogDetails[0]['admin_password'])){
                $this->authentication->logAdmin($adminName, $adminLogDetails[0]['admin_password']);
            }
        }
        $rootLink = "http://" . $_SERVER['HTTP_HOST'];
        header('location: ' . $rootLink );
    }
    public function changeLoginInformation(){
        $oldPassword = $_POST['adminOldPassword'];
        $newPassword = $_POST['adminNewPassword'];
        $newPasswordRepeat = $_POST['adminNewPasswordRepeat'];
        $message = [];
        if (!password_verify($oldPassword, $this->adminLogDetailsTable->
            findById($_SESSION['username'])[0][$this->authentication->passwordColumn])){
            $message[] = 'wrong password';
            return $this->changeLoginInformationDisplay($message);
        }
        if ($newPassword !== $newPasswordRepeat){
            $message[] = 'Passwords does not match';
            return $this->changeLoginInformationDisplay($message);
        }
        $data = ['set' => [$this->authentication->passwordColumn =>
        password_hash($newPassword, PASSWORD_DEFAULT)]];
        $this->adminLogDetailsTable->updateValuesInDb($data);
        $this->authentication->logAdmin($_SESSION['username'],
            $this->adminLogDetailsTable->findById($_SESSION['username'])[0]
            [$this->authentication->passwordColumn]);
        $message[] = 'password changed successfully';
        return $this->changeLoginInformationDisplay($message);
    }

    public function changeLoginInformationDisplay($messages = null){
        return [
            'title' => 'admin change password',
            'templates' => [
                'adminLogged' => ['template' => 'adminLogged.html.php'],
                'output' => ['template' => 'changeLoginInformationDisplay.html.php',
                    'variables' => ['messages' => $messages]]
            ]
        ];
    }

}