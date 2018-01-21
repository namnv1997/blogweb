<?php
/**
 * Created by PhpStorm.
 * User: n
 * Date: 22/01/2018
 * Time: 02:15
 */

namespace app\controllers\frontend;


use app\models\User;

class UserController
{
    public function checkUser(){
        $user = new User();
        return $user->checkUser();
    }

    public function addUser(){
        $user = new User();
        $user->add();
    }

    public function login(){
        $user = new User();
        $user->login();
    }
}