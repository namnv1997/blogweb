<div id="content" class="container">
    <?php
        if ($show_same_topic){
            echo $scroll_top;
        }
        echo $content;
        if ($show_same_topic){
            echo $comment_area;
        }
     ?>
</div>