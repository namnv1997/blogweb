<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/CoffeWebsite/getFunction.php';

$title = 'Sign Up';
$content = '';
$show_same_topic = false;
use  app\controllers\frontend\UserController;
$user = new UserController();

if (isset($_POST['check_user'])) {
    $resultSet = $user->checkUser();
    $result = 1;
    if($resultSet == null){
        $result = 0;
    }
    echo $result;
    exit();

}


if (isset($_POST['username'])) {
   $user->addUser();
    echo 1;


}
$content .= '<form class="content-login">
                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" name="username_create" class="form-control" id="username_create" aria-describedby="emailHelp" placeholder="Username">
                    <span class="error text-danger" eror_user></span>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password_create" class="form-control" id="password_create" placeholder="Password">
                     <span class="error text-danger" id="eror_pass"></span>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" name="cf_password" class="form-control" id="cf_password" placeholder="Confirm Password">
                     <span class="error text-danger" id="eror_cf"></span>
                </div>
                </form>
                <div class="text-center"><button type="submit" class="btn btn-primary" name="sign_up" id="btn-sign-up">Sign Up</button></div> ';
include $_SERVER['DOCUMENT_ROOT'] . '/CoffeWebsite/data/element-layout/Template.php';
?>
<script src="../../js/signup.js"></script>
