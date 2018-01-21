<?php
/**
 * Created by PhpStorm.
 * User: n
 * Date: 22/01/2018
 * Time: 01:48
 */

namespace app\controllers\frontend;


use app\models\Category;
use app\models\Comment;
use app\models\Post;
use app\models\User;

class Details
{

    public function createContent()
    {
        $content = "";
        $post = new Post();
        $category = new Category();
        $result = $post->getPostById($_REQUEST['id_post']);

        $resultIdCategory = $post->getCategoryByPost();
        $content .= '<div>
            <h3 class="text-center"><b>' . $result[0]['title'] . '</b></h3>
            <div class="text-center">
             <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
             <span class="color808080">' . $result[0]['create_date'] . '</span> <br></div>';

        $content .= '<div class="text-center margin10">';
        $content .= '<span class="glyphicon glyphicon-tags margin-right10"></span>';
        foreach ($resultIdCategory as $row) {
            $resultCategory = $category->getCategoryById($row['category_id']);
            foreach ($resultCategory as $row_name) {
                $content .= '<span class="border-category"><a href="http://localhost/CoffeWebsite/category-info.php?category_id=' . $row_name['id'] . '">'
                    . $row_name['name'] . ' </a></span>';
            }
        }
        $content .= '</div>';

        $content .= '<div class="text-center">
            <img src="' . $result[0]['image_post'] . '">
            </div>
            <div class="content-detail">' . $result[0]['content'] . '</div></div>';
        return $content;
    }

    public function createSlide()
    {
        $post = new Post();
        $slide_component = "";
        $resultPost = $post->getPostSame();
        foreach ($resultPost as $post_same) {
            if ($post_same == $resultPost[0]) {
                $slide_component .= '<div class="item active"">
                        <div class="col-xs-12 col-sm-6 col-md-2">
                        <a href="http://localhost/CoffeWebsite/details.php?id_post=' . $post_same['id'] . '"><img src="' . $post_same['image_post'] . '" class="img-responsive center-block img150"></a>
                        <h5 class="text-center">' . $post_same['title'] . '</h5>
                        </div>
                        </div>';
            } else {
                $slide_component .= '<div class="item">
                        <div class="col-xs-12 col-sm-6 col-md-2">
                        <a href="http://localhost/CoffeWebsite/details.php?id_post=' . $post_same['id'] . '"><img src="' . $post_same['image_post'] . '" class="img-responsive center-block img150"></a>
                        <h5 class="text-center">' . $post_same['title'] . '</h5>
                        </div>
                        </div>';
            }
        }

        return $slide_component;

    }

    public function createComment()
    {
        $comment = new Comment();
        $users = new User();
        $cmtResult = $comment->getCommentById($_REQUEST['id_post']);
        $comment_area = "";
        if (isset($_SESSION['id'])) {
            $comment_area .= "<hr><h3 class='text-primary margin-left5'><b>Comment Readers</b></h3>";
            foreach ($cmtResult as $cmt) {
                $user = $users ->getInfoUserById($cmt['user_id']);
                $comment_area .= "<div class='main_comment' >
                    <div class='comment_item'>
                       <img src='" . $user['image_profile'] . "' class='img64'>
                       <span class='margin-left4px'> <b>" . $user['display_name'] . "</b> </span> <span class='span-time'> 3 hours ago</span>
                       <p class='margin-left5'>" . $cmt['comment'] . "</p>
                    </div>
                </div>";
            }
            $comment_area .= "<div class='text-center'><div class='form-group margin-bot-15pt' >
                        <label for='comment_content' class='display-block text-left margin-left10per'>Comment</label>
                        <textarea  class='wid80' id='comment_content' rows='5' maxlength='999' placeholder='Comment less than 999 characters'></textarea>
                      </div>
                    <button class='btn btn-primary btn-send-cmt pull-right margin-right10per' id='btn-comment' > Send </button></div>";

            return $comment_area;
        }

    }

}