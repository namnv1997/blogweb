<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/CoffeWebsite/getFunction.php';

use app\models\User;
$user = new User();

$status_response = false;
if (isset($_POST['login_query'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
        $status_response = false;
    } else {
        $resultLogin = $user->login();
        if ($resultLogin) {
            $status_response = true;
            $sesssion -> set_session_data('name',$resultLogin['display_name']);
            $sesssion -> set_session_data('id',$resultLogin['id']);
        }
    }
    echo $status_response;
}



$content = '';
$show_same_topic = false;

$content .= '<form class="content-login">
                <div class="form-group div-frontend">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" id="username" class="form-control"
                        aria-describedby="emailHelp" placeholder="Username"">
                        <span class="error text-danger"></span>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" id="password" class="form-control" placeholder="Password" >
                     <span class="error text-danger"></span>
                    
                </div>
                </form>
                <button class="btn btn-primary btn-login" id="btn-login" name="login">Login</button>
               
                <div class="modal fade bd-example-modal-sm" id="modalLogin" aria-modal="true" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" >
                      <div class="modal-dialog modal-sm">
                      <div class="modal-content text-center padding20" >
                      <span class="glyphicon glyphicon-ok color-gryl" aria-hidden="true"></span>
                        <span>Login Successfully</span>
                        <p> Back to Home in 3s...</p>
                      </div>
                      </div>
                </div>';
include $_SERVER['DOCUMENT_ROOT'] . '/CoffeWebsite/data/element-layout/Template.php';
?>
<script src="../../js/login.js">
</script>

