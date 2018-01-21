<?php
require_once 'admin/database.php';
require_once 'session.php';
require_once 'getFunction.php';

$title = 'profile';
$profile = new profile();
$show_same_topic = false;
$content = $profile->createContent();


class Profile
{
    protected $db;
    protected $request;
    public $session;

    public function __construct()
    {
        $base = new Database();
        $this->db = $base->connect();
        $this->request = $_REQUEST;
        $this->session = new session();
    }

    public function updateProfile()
    {
        $imgProfile = "profile/" . $this->request['name_img'];
        $sql = "UPDATE frontend SET display_name = :display,
                            gender = :gender,
                            email = :email,
                            phone_number = :phone,
                            description = :description,
                            image_profile = :img
                            WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':display', $this->request['display_name'], PDO::PARAM_STR);
        $stmt->bindParam(':gender', $this->request['gender'], PDO::PARAM_STR);
        $stmt->bindParam(':email', $this->request['email'], PDO::PARAM_STR);
        $stmt->bindParam(':phone', $this->request['phone_number'], PDO::PARAM_INT);
        $stmt->bindParam(':description', $this->request['description'], PDO::PARAM_STR);
        $stmt->bindParam(':img', $imgProfile, PDO::PARAM_STR);
        $stmt->bindParam(':id', $this->session->get_session_data('id'), PDO::PARAM_INT);
        $stmt->execute();
        $this->session->set_session_data('name', $this->request['display_name']);
        echo "done";
    }

    public function createContent()
    {

        $content = "";
        $stmt2 = $this->db->prepare('SELECT * from frontend WHERE id=' . $this->request['user_id'] . ' ');
        $stmt2->setFetchMode(PDO::FETCH_ASSOC);
        $stmt2->execute();
        $user_current = $stmt2->fetch();

        $content .= '<div class="container bottom50">
                <div class="row">
                    <div class="col-md-3" id="menu_profile">
                            <div class="text-center">
                                <script src="../../js/gallery.js"></script>
                                <div id="img_preview">
                                <img src="' . $user_current['image_profile'] . '" data-name="'.$user_current['image_profile'].'" id="img-profile" type="image" class="img-profile" >
                                </div>
                                <input type="file" id="my_file" name="fileUp" class="hidden" accept="image/*">
                            </div>
                            <div >
                                <ul class="ul-menu">
                                    <li class="menu-active" id="edit_profile" data-id="' . $user_current['id'] . '">
                                        <span class="glyphicon glyphicon-edit margin-right10" aria-hidden="true"></span>Edit profile
                                    </li>
                                    <li id="comment_manage" data-id="' . $user_current['id'] . '">
                                        <span class="glyphicon glyphicon-comment margin-right10" aria-hidden="true"></span>Comment manage 
                                    </li>
                                    <div class="border-right-1px"></div>
                                </ul>
                            </div>
                    </div>
                    
                    <div class="col-md-9 margin-top30" id="content-profile"  >
                        <form>
                            <div class="form-group bottom10">
                                <label for="exampleFormControlInput1">Display name</label>
                                <input type="text" class="form-control" id="display_name" value="' . $user_current['display_name'] . '">
                            </div>
                            <div class="form-check form-check-inline bottom10">
                                <form  id="check">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="1" value="male" checked>
                                <label class="form-check-label margin-right20" for="inlineRadio1">Male</label>
 
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="2" value="female">
                                </form>
                                <label class="form-check-label" for="inlineRadio2">Female</label>
                            </div>
                            
                             <div class="form-group bottom10">
                                <label for="exampleFormControlInput1">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="enter your email" value="' . $user_current['email'] . '">
                            </div>
                            
                             <div class="form-group bottom10">
                                <label for="exampleFormControlInput1">Phone number</label>
                                <input type="text" class="form-control" id="phone_number" placeholder="enter phone number" value="' . $user_current['phone_number'] . '">
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1" >Description</label>
                                <textarea class="form-control" id="description" rows="3" >' . $user_current['description'] . '</textarea>
                            </div>
                        </form>
                        <button class="btn btn-primary pull-right wid70px" id="btn-save" > Save </button>
                    </div>
                </div>
            </div>';
        return $content;
    }

    public function createContentProfile()
    {
        $response = array();
        $stmt = $this->db->prepare('SELECT * from frontend WHERE id= ' . $this->request['user_id'] . ' ');
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $resultSet = $stmt->fetchAll();
        foreach ($resultSet as $row) {
            array_push($response, array("id" => $row['id'], "display_name" => $row['display_name'], "email" => $row['email'], "gender" => $row['gender'],
                "phone_number" => $row['phone_number'], "description" => $row['description'], "image_profile" => $row['image_profile']));
        }
        echo json_encode($response);
        exit();
    }

    public function uploadFile()
    {
        if (move_uploaded_file($_FILES['upload_file']['tmp_name'], "./profile/" . $_FILES['upload_file']['name'])) {
            echo $_FILES['upload_file']['name'] . " OK";
        } else {
            echo $_FILES['upload_file']['name'] . " KO";
        }
        exit;
    }

    public function createCommentManage()
    {
        $response = array();
        $key_like = '\'' . '%' . $this->request['keywords'] . '%' . '\'';
        $date_start = '\'' . $this->request['date_start'] .  '\'';
        $date_end = '\'' . $this->request['date_end'] .  '\'';
        if (empty($this->request['keywords'])) {
            $stmt = $this->db->prepare('SELECT  * from comment WHERE create_date BETWEEN ' . $date_start . ' AND ' . $date_end . '
            AND status=' . $this->request['status'] . ' AND user_id=' . $this->request['user_id'] . ' ');
            if (empty($this->request['date_start']) && empty($this->request['date_end'])) {
                $stmt = $this->db->prepare('SELECT  * from comment WHERE status=' . $this->request['status'] . ' AND user_id=' . $this->request['user_id'] . ' ');
            }
        } else {
            if (empty($this->request['date_start']) && empty($this->request['date_end'])) {
                $stmt = $this->db->prepare('SELECT  * from comment WHERE status=' . $this->request['status'] . ' AND comment LIKE ' . $key_like . '  AND user_id=' . $this->request['user_id'] . ' ');
            } else {
                $stmt = $this->db->prepare('SELECT  * from comment WHERE create_date BETWEEN ' . $date_start . ' AND ' . $date_end . '
                        AND status=' . $this->request['status'] . ' AND comment LIKE ' . $key_like . ' AND user_id=' . $this->request['user_id'] . ' ');
            }
        }
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $resultSet = $stmt->fetchAll();
        foreach ($resultSet as $row) {
            $post_title = '';
            $stmt2 = $this->db->prepare('SELECT title from post WHERE id= ' . $row['post_id'] . ' ');
            $stmt2->setFetchMode(PDO::FETCH_ASSOC);
            $stmt2->execute();
            $resultTitle = $stmt2->fetch();
            $post_title .= $resultTitle['title'];
            array_push($response, array("comment" => $row['comment'], "status" => $row['status'], "post_title" => $post_title));
        }
        echo json_encode($response);
        exit();
    }
}

include 'Template.php';
?>

<script src="../../js/profile.js">
</script>

