<?php
namespace app\controllers\admin;
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . 'CoffeWebsite/getFunction.php';

use app\core\controller\AppController;
use app\models\Post;


class PostController extends AppController
{


    public function getMorePost()
    {
        $response = array();
        $post = new Post();
        $resultSet = $post->getMorePost(3, $this->request['offset']);
        foreach ($resultSet as $row) {
            array_push($response, array("id" => $row['id'], "title" => $row['title'], "content" => $row['content'], "date" => $row['create_date'],
                "image" => $row['image_post'], "summary" => $row['summary']));
        }
        echo json_encode($response);
    }

    public function firstDisplayInfoPost()
    {
        $post = new Post();
        $resultSet = $post->getMorePost(5, 0);
        echo '<div id="post_display">';
        foreach ($resultSet as $row) {
            echo '<div class="row-table">';
            echo '<div class="column-table text-right" style="width: 40px;" >' . $row['id'] . '</div>';
            echo '<div class="column-table padding10" style="width:200px;" >' . $row['title'] . '</div>';
            echo '<div class="column-table padding10 text-summary" style="width:550px;">' . $row['summary'] . '</div>';
            if ($row['status'] == 1) {
                echo '<div class="column-table text-center" style="width: 80px;">Enabled</div>';
            } else {
                echo '<div class="column-table text-center" style="width: 80px;">Disabled</div>';
            }
            echo '<div class="column-table text-center" style="width: 200px;" data-id="' . $row['id'] . '" >';
            echo '<button type="button" class="btn btn-primary btnUD edit-post"  data-backdrop="static" data-keyboard="false" data-toggle="modal" data-target=".edit-post-modal"> &nbsp Edit &nbsp </button>';
            echo '<button class="btn btn-danger btnUD delete-post" data-toggle="modal" data-target=".delete-post-modal">Delete</button>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';

        $count = $post->countPost();
        $number_of_pagination = ceil($count / 5);
        echo '<ul class="pagination post-previous">';
        echo '<li class="page-item previous-li-post" style="display: none" ><a class="page-link">Previous</a></li>';
        echo '</ul>';
        echo '<ul class="pagination pagination-post">';
        for ($i = 1; $i <= $number_of_pagination; $i++) {
            if ($i == 1) {
                echo '<li><a class="active-me-post"  id="post-' . $i . '" data-page="' . $i . '" data-max-page="' . $number_of_pagination . '">' . $i . '</a></li>';
            } else {
                echo '<li><a data-page="' . $i . '" id="post-' . $i . '" data-max-page="' . $number_of_pagination . '">' . $i . '</a></li>';
            }
        }
        echo '</ul>';
        echo '<ul class="pagination post-next">';
        echo '<li class="page-item next-li-post" ><a class="page-link" style="margin-left: 1px" >Next</a></li>';
        echo '</ul>';

    }

    public function getInfoPost()
    {
        $post = new Post();
        $response = $post->getInfoPost();

        echo json_encode($response);
        exit();
    }

    public function getTitlePost()
    {
        $post = new Post();
        $response = $post->getTitle($this->request['id_request']);
        echo json_encode($response);
        exit();
    }

    public function addCategoryCheck($selected = array())
    {
        $post = new Post();
        $resultSet = $post->getCategoryCheck();
        echo ' <select id="myselect"  name="basic[]" multiple="multiple" class="3col active">';
        foreach ($resultSet as $row) {
            if (in_array($row['id'], $selected)) {
                echo '<option value="' . $row['id'] . '" selected>' . $row['name'] . '</option>';
            } else {
                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
            }
        }
        echo '</select>';
    }

    public function addPost()
    {
        $post = new Post();
        $post_lastest_id = $post->add();
        $post->attachPostCategory($post_lastest_id, $this->request['id_category_post']);

        header("Location: http://localhost/CoffeWebsite/admin.php#post");
    }

    public function editPost()
    {
        $post = new Post();
        $post->edit($this->request);

        header("Location: http://localhost/CoffeWebsite/admin.php#post");
    }

    public function deletePost()
    {
       $post = new Post();
       $post->delete();

        header("Location: http://localhost/CoffeWebsite/admin.php#post");
    }

    public function changePaginationPost()
    {
        $post = new Post();
        $response = array();
        $page = ($this->request['post_pagination'] - 1) * 5;

        $resultSet = $post->getMorePost(5, $page);
        $response = $post->getCategoryByPostId($resultSet);

        echo json_encode($response);
        exit();
    }

    public function uploadFiles()
    {
        if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/' . 'CoffeWebsite/data/post_images/' . $_FILES['upload_file']['name'])) {
            echo $_FILES['upload_file']['name'] . " OK";
        } else {
            echo $_FILES['upload_file']['name'] . " KO";
        }
        exit;

    }

}

?>



