<?php
/**
 * Created by PhpStorm.
 * User: n
 * Date: 22/01/2018
 * Time: 02:08
 */

namespace app\models;


use app\core\model\AppModel;

class User extends AppModel
{
    protected $table = 'User';


    public function __construct()
    {
        parent::__construct($this->table);
    }

    public function getInfoUserById($id){
        $stmt6 = $this->db->prepare('SELECT display_name,image_profile from user WHERE id=' . $id . ' ');
        $stmt6->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt6->execute();
        $user = $stmt6->fetch();
        return $user;
    }

    public function checkUser(){
        $username = '\'' . $_POST['check_user'] . '\'';
        $stmt = $this->db->prepare('SELECT * FROM frontend WHERE username = '.$username.' ');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute();
        $resultSet = $stmt->fetch();
        return $resultSet;
    }

    public function add()
    {
        $password = $_POST['password'];
        $hash_pass = md5($password);
        $stmt2 = $this->db->prepare('INSERT INTO frontend(username, password, display_name) values (:frontend, :pass, :frontend)');
        $stmt2->bindParam(':frontend', $_POST['username'], \PDO::PARAM_STR);
        $stmt2->bindParam(':pass', $hash_pass, \PDO::PARAM_STR);
        $stmt2->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt2->execute();
    }

    public function login(){
        $user = $_POST['username'];
        $password = $_POST['password'];
        $pass_hash = md5($password);
        $base = new Database();
        $db = $base->connect();
        $stmt = $db->prepare('SELECT * FROM `frontend` WHERE username = "' . $user . '" AND password = "' . $pass_hash . '" ');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute();
        $res = array();
        $resultLogin = $stmt->fetch();
        return $resultLogin;
    }

    public function edit()
    {
        // TODO: Implement edit() method.
    }

    public function createFirstInformation()
    {
        // TODO: Implement createFirstInformation() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}