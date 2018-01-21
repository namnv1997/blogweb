<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/CoffeWebsite/getFunction.php';
use app\controllers\frontend\Details;
$details = new Details();

$title = 'Blog';
$show_same_topic = true;
$content = $details->createContent();;
$slide = $details->createSlide();
$comment_area = $details->createComment();
$scroll_top = '<button type="button" id="scroll-top" class="btn btn-primary active scroll-top display-none">To Top</button>';



include $_SERVER['DOCUMENT_ROOT'] . '/CoffeWebsite/data/element-layout/Template.php';

?>
<script>
    $(document).ready(function (e) {
        $(document).on('click', '#btn-log-out', function () {
            $.ajax({
                url: "index.php",
                type: "post",
                dataType: "text",
                data: {
                    destroy: 1
                },
                success: function (result) {
                    window.location.href = '../../index.php';
                },

            });

        });

        $(document).on('click', '#btn-comment', function () {
            var cmt = $('#comment_content').val();
            var post_id = '<?php echo $_GET['id_post'] ?>';
            var user_id = '<?php echo $session->get_session_data('id') ?>';

            $.ajax({
                url: "admin/commentController.php?fnc=sendComment",
                type: "post",
                dataType: "json",
                data: {
                    comment: cmt,
                    post_id: post_id,
                    user_id: user_id
                },
                success: function (result) {
                    $.alert({
                        title: 'Done!',
                        content: 'Your comment is confirming.',
                    });
                    $('#comment_content').val('');
                },

            });
        });


    });

</script>
<script type="text/javascript" src="../../js/details.js">
</script>



