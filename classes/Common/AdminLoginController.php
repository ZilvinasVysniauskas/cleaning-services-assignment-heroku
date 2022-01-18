<?php

namespace Ninja;

class AdminLoginController
{
    private $adminLogDetailsTable;

    public function __construct(\Ninja\DatabaseTable $usersTable, $usernameColumn, $passwordColumn)
    {
        session_start();
        $this->usersTable = $usersTable;
        $this->usernameColumn = $usernameColumn;
        $this->passwordColumn = $passwordColumn;
    }
    public function logAdmin($username, $password, $tableId)
    {
        session_regenerate_id();
        $_SESSION['admin'] = 'yes';
    }
    public function logout(){
        session_destroy();
        $link = 'http://'.$_SERVER['HTTP_HOST'];
        header('location: '. $link);
    }
    public function isAdmin(){
        if (!isset($_SESSION['admin'])){
             return false;
        }
        if(count($this->usersTable->findById($_SESSION['username'])) === 0) {
            return false;
        }
        if ($_SESSION['password'] !== ($this->usersTable->findById($_SESSION['username'])[0][$this->passwordColumn])){
            return false;
        }
        return true;
    }
}