<?php

namespace Common;

class Authentication
{
    private $adminLoginTable;
    private $usernameColumn;
    public $passwordColumn;

    public function __construct(DatabaseTable $adminLoginTable, $usernameColumn, $passwordColumn)
    {
        session_start();
        $this->adminLoginTable = $adminLoginTable;
        $this->usernameColumn = $usernameColumn;
        $this->passwordColumn = $passwordColumn;
    }
    public function logAdmin($username, $password)
    {
        session_regenerate_id();
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
    }
    public function logout(){
        session_destroy();
        $actual_link = 'http://'.$_SERVER['HTTP_HOST'];
        header('location: '. $actual_link);
    }
    public function isLogged(){
        if (!isset($_SESSION['username'])){
            return false;
        }
        if(count($this->adminLoginTable->findById($_SESSION['username'])) === 0) {
            return false;
        }
        if ($_SESSION['password'] !== ($this->adminLoginTable->findById($_SESSION['username']))[0][$this->passwordColumn]){
            return false;
        }
        return true;
    }
}