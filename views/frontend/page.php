<?php

use app\controllers\frontend\Frontend;

$index = new Frontend();

$title = "Home";
$show_same_topic = false;

if (isset($_POST['destroy'])) {
    $index->destroySession();
    echo 1;
}
$content_page = $index->createContentPage();
$sidebar = $index->createSidebar();
$content = $content_page . $sidebar;


include $_SERVER['DOCUMENT_ROOT'] . '/CoffeWebsite/data/element-layout/Template.php';
?>
<script src="js/index.js"></script>




