<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/CoffeWebsite/getFunction.php';
use app\controllers\admin\PostController;
use app\controllers\admin\CategoryController;
use app\controllers\admin\CommentController;

$category = new CategoryController();
$post = new PostController();
$comment = new CommentController();

include 'views/admin/admin.html';
?>