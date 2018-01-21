<?php
namespace app\controllers\admin;
require_once $_SERVER['DOCUMENT_ROOT'] . '/' . 'CoffeWebsite/getFunction.php';
ob_start();

use app\core\controller\AppController;
use app\models\Category;

class CategoryController extends AppController
{
    public function firstInfoCategory()
    {
        $category = new Category();
        $resultSet = $category->createFirstInformation();
        echo '<div id="category_display">';
        foreach ($resultSet as $row) {
            echo '<div class="row-table" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '">';
            echo '<div class="column-table " style="min-width: 30px;">' . $row['id'] . '</div>';
            echo '<div class="column-table minw250">' . $row['name'] . '</div>';
            echo '<button type="button" class="btn btn-primary btnUD edit-category" data-toggle="modal" data-target=".edit-category-modal">&nbsp Edit &nbsp </button>';
            echo '<button class="btn btn-danger btnUD delete-category" data-toggle="modal" data-target=".delete-category-modal">Delete</button>';
            echo '</div>';
        }
        echo '</div>';

        $count = $category->getCountCategory();
        $number_of_pagination = ceil($count / 10);

        echo '<ul class="pagination category-previous">';
        echo '<li class="page-item previous" style="display: none" ><a class="page-link">Previous</a></li>';
        echo '</ul>';
        echo '<ul class="pagination pagination-category">';
        for ($i = 1; $i <= $number_of_pagination; $i++) {
            if ($i == 1) {
                echo '<li><a class="active-me" id="pagi-1" data-max-page="' . $number_of_pagination . '"  data-page="' . $i . '">' . $i . '</a></li>';
            } else {
                echo '<li><a data-page=" ' . $i . '" id="pagi-' . $i . '" data-max-page=" ' . $number_of_pagination . '" >' . $i . '</a></li>';
            }
        }
        echo '</ul>';
        echo '<ul class="pagination category-next">';
        echo '<li class="page-item next" ><a class="page-link" >Next</a></li>';
        echo '</ul>';

    }

    public function changePaginationCategory()
    {

        $category = new Category();
        $response = $category->getMoreCategory();
        echo json_encode($response);
        exit();
    }

    public function getNameCategory()
    {
        $category = new Category();
        $array_name = $category->getName();

        echo implode(",", $array_name);
    }

    public function addCategory()
    {
        $category = new Category();
        $category->add();

        header("Location: http://localhost/CoffeWebsite/admin.php#category");
    }

    public function editCategory()
    {
        $category = new Category();
        $category->edit();
        header("Location: http://localhost/CoffeWebsite/admin.php#category");
    }

    public function deleteCategory()
    {

        $category = new Category();
        $category->delete();
        header("Location: http://localhost/CoffeWebsite/admin.php#category");
    }
}

ob_end_flush();
?>