<?php


namespace app\controllers\frontend;


use app\models\Category;
use app\models\Post;

class Frontend
{
    public function createContentPage()
    {

        $content_area = "";
        $content_area .= '<div id="content_area" class="col-md-9">';

        $post = new Post();
        $resultSet = $post->getPostLastest();

        foreach ($resultSet as $row) {
            $content_area .= '<div class="div-post row" >
                    <div class="col-md-4">
                    <img src="' . $row['image_post'] . '" class="imgPost"/>
                    </div>
                    <div class="col-md-8">
                    <p class="title-post"> ' . $row['title'] . ' </p>
                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                    <span class="span-time">' . $row['create_date'] . '</span>
                    <input type="hidden" id="id_post" name="id_post">
                    <p class="text-summary"> ' . $row['summary'] . '</p>                 
                    <button type="button" class="btn btn-info btn-read-more margin-top8"  data-id="' . $row['id'] . '">Read More</button>
                    </div>
                    </div>';
        }
        $content_area .= '</div>';
        return $content_area;


    }

    public function createSidebar()
    {
        $category = new Category();
        $sidebar = '<div id="sidebar" class="col-md-3">
            <h3><b>Popular Category</h3><hr>';
        $resultCategory = $category->getCategoryMost();
        $number = 1;
        foreach ($resultCategory as $row) {

            $resultPopular = $category->getCategoryById($row['category_id']);

            foreach ($resultPopular as $row) {
                $sidebar .= '<p><a class="padding10" href="http://localhost/CoffeWebsite/views/frontend/category-info.php?category_id=' . $row['id'] . '" >' . $number++ . ". " . $row['name'] . '</a></p>';
            }
        }

        $sidebar .= '</div>';
        return $sidebar;
    }

    public function destroySession()
    {
        $this->session->destroy();
    }
}