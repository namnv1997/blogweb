<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/CoffeWebsite/getFunction.php';
use app\controllers\frontend\CategoryInfo;
$info = new CategoryInfo();
$show_same_topic = false;
$title = "Category Information";

$content_page = $info->createContentPage();
$sidebar = $info->createSidebar();
$content = $content_page . $sidebar;


include $_SERVER['DOCUMENT_ROOT'] . '/CoffeWebsite/data/element-layout/Template.php';
?>
<script src="../../js/category-info.js"></script>
