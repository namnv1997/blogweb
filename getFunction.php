<?php

include_once 'Autoload.php';
if (isset($_GET['fnc'])) {
    $get_fnc = $_GET['fnc'];
    $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $pieces = explode("/", $actual_link);
    $name_current = explode("?", $pieces[sizeof($pieces) - 1]);
    $name = explode('.', $name_current[0]);
    $object = 'app\controllers\admin' . '\\' . $name[0];// cat chu Controller va viet hoa chu dau tien
    $obj = new $object;

    if (method_exists($obj, $get_fnc)) {
        $obj->$get_fnc();
    } else {
        print_r("not available");
    }
}
?>