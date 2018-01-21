<?php
namespace app\models;

use app\core\model\AppModel;

class Post extends AppModel
{

    protected $table = 'Post';


    public function __construct()
    {
        parent::__construct($this->table);
    }

	public function getPostById($id){
        $stmt = $this->db->prepare('SELECT id, title, content, status,image_post, create_date from post WHERE id=' . $id . ' ');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute();
        $result = $stmt->fetchAll();
    }

	public function getMorePost($limit, $offset) {
		$stmt = $this->db->prepare("SELECT * from post WHERE status = 1 ORDER BY create_date DESC LIMIT {$limit} offset {$offset} ");
		$stmt->setFetchMode(\PDO::FETCH_ASSOC);
		$stmt->execute();
		return $stmt->fetchAll();
    }

    public function getCategoryByPostId($resultSet){
        $response = array();
        foreach ($resultSet as $row) {
            $stmt_check = $this->db->prepare('SELECT category_id from post_category WHERE post_id= ' . $row['id'] . ' ');
            $stmt_check->setFetchMode(\PDO::FETCH_ASSOC);
            $stmt_check->execute();
            $resultCheck = $stmt_check->fetchAll();
            $checkAvailable = array();
            foreach ($resultCheck as $check) {
                array_push($checkAvailable, $check['category_id']);
            }
            $comma_separated = implode(",", $checkAvailable);
            array_push($response, array("id" => $row['id'], "title" => $row['title'], "summary" => $row['summary'], "status" => $row['status'], "list" => $comma_separated));
        }
        return $response;
    }
	
	public function countPost() {
		$stmt2 = $this->db->prepare('SELECT count(id) from post');
		$stmt2->setFetchMode(\PDO::FETCH_ASSOC);
		$stmt2->execute();
		return $stmt2->fetchColumn();
    }

    public function delete()
    {
        $sql = "DELETE FROM post WHERE id = :mID";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':mID', $this->request['post_id_delete'], \PDO::PARAM_INT);
        $stmt->execute();


        $sql2 = "DELETE FROM post_category WHERE post_id = :mID";
        $stmt2 = $this->db->prepare($sql2);
        $stmt2->bindParam(':mID', $this->request['post_id_delete'], \PDO::PARAM_INT);
        $stmt2->execute();

    }

    public function getTitle($id_request){
        $response = array();
        $stmt = $this->db->prepare('SELECT title from post WHERE id != ' . $id_request . ' ');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute();
        $resultSet = $stmt->fetchAll();
        foreach ($resultSet as $row) {
            array_push($response, array("title" => $row['title']));
        }
        return $response;
    }

    public function getInfoPost(){
        $response = array();
        $stmt = $this->db->prepare('SELECT id,title,content,status,image_post,summary from post WHERE id =' . $this->request['post_id'] . ' ');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute();
        $resultSet = $stmt->fetchAll();
        $list = array();
        $stmt2 = $this->db->prepare('SELECT id, name from category');
        $stmt2->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt2->execute();
        $resultList = $stmt2->fetchAll();
        foreach ($resultList as $row) {
            array_push($list, array("id" => $row['id'], "name" => $row['name']));
        }
        foreach ($resultSet as $row) {
            $stmt_check = $this->db->prepare('SELECT category_id from post_category WHERE post_id= ' . $row['id'] . ' ');
            $stmt_check->setFetchMode(\PDO::FETCH_ASSOC);
            $stmt_check->execute();
            $resultCheck = $stmt_check->fetchAll();
            $checkAvailable = array();
            foreach ($resultCheck as $check) {
                array_push($checkAvailable, $check['category_id']);
            }
            array_push($response, array("id" => $row['id'], "title" => $row['title'], "summary" => $row['summary'], "content" => $row['content'], "status" => $row['status'], "list_active" => $checkAvailable, "list" => $list, "image" => $row['image_post']));
        }
        return $response;
    }

    public function add()
    {
        $picProfile = "data/post_images/" . $this->request['name_image'];
        $stmt = $this->db->prepare('INSERT INTO post(title, content, status, image_post, summary) values (:title, :content, :status, :image, :summary)');
        $stmt->bindParam(':title', $this->request['title_post'], \PDO::PARAM_STR);
        $stmt->bindParam(':content', $this->request['content_post'], \PDO::PARAM_STR);
        $stmt->bindParam(':status', $this->request['status_post'], \PDO::PARAM_INT);
        $stmt->bindParam(':summary', $this->request['summary_post'], \PDO::PARAM_INT);
        $stmt->bindParam(':image', $picProfile);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function edit()
    {
        $picEdit = "data/post_images/" . $this->request['name_image_edit'];

        $sql = "UPDATE post SET title   = :title, 
                            content = :content,
                            status  = :status,
                            image_post = :image,
                            summary = :summary
                            WHERE id = :mID";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':title', $this->request['edit_title_post'], \PDO::PARAM_STR);
        $stmt->bindParam(':content', $this->request['edit_content_post'], \PDO::PARAM_STR);
        $stmt->bindParam(':status', $this->request['edit_status_post'], \PDO::PARAM_INT);
        $stmt->bindParam(':summary',$this->request['summary_edit_post'], \PDO::PARAM_STR);
        $stmt->bindParam(':mID', $this->request['edit_id_post'], \PDO::PARAM_INT);
        $stmt->bindParam(':image', $picEdit);

        $stmt->execute();


        $sql2 = "DELETE FROM post_category WHERE post_id = :mID";
        $stmt2 = $this->db->prepare($sql2);
        $stmt2->bindParam(':mID', $request['edit_id_post'], \PDO::PARAM_INT);
        $stmt2->execute();


        $stmt3 = $this->db->prepare('INSERT INTO post_category(category_id, post_id) values (:cateid, :postid)');
        $stmt3->bindParam(':postid', $request['edit_id_post'], \PDO::PARAM_INT);

        $str_category = $this->request['edit_id_category_post'];
        $list_category = explode(",", $str_category);
        foreach ($list_category as $value) {
            $stmt3->bindParam(':cateid', $value, \PDO::PARAM_INT);
            $stmt3->execute();
        }
    }

    public function createFirstInformation()
    {
        // TODO: Implement createFirstInformation() method.
    }

    public function getPostLastest(){
        $stmt = $this->db->prepare('SELECT id, title, content, status,image_post, create_date, summary from post WHERE status = 1 ORDER BY create_date DESC LIMIT 3');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute();
        $resultSet = $stmt->fetchAll();
        return $resultSet;
    }

    public function getCategoryCheck(){
        $stmt = $this->db->prepare('SELECT id, name from category');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute();
        $resultSet = $stmt->fetchAll();
        return $resultSet;
    }

    public function attachPostCategory($post_id, $str_category)
    {
        $stmt2 = $this->db->prepare('INSERT INTO post_category(category_id, post_id) values (:cateid, :postid)');
        $stmt2->bindParam(':postid', $post_id, \PDO::PARAM_INT);

        $list_category = explode(",", $str_category);
        foreach ($list_category as $value) {
            $stmt2->bindParam(':cateid', $value, \PDO::PARAM_INT);
            $stmt2->execute();
        }
    }

    public function getAllPostAboutCategory(){
        $stmt = $this->db->prepare('SELECT * FROM post WHERE id IN (SELECT post_id FROM post_category WHERE category_id = ' . $this->request['category_id'] . ')');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute();
        $resultSet = $stmt->fetchAll();
        return $resultSet;
    }

    public function getCategoryByPost(){
        $stmt2 = $this->db->prepare('SELECT category_id from post_category WHERE post_id=' . $this->request['id_post'] . ' ');
        $stmt2->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt2->execute();
        $resultIdCategory = $stmt2->fetchAll();
        return $resultIdCategory;
    }

    public function getPostSame(){
        $stmt4 = $this->db->prepare('SELECT * FROM post WHERE id IN (SELECT post_id FROM post_category WHERE category_id 
                                      IN (SELECT category_id FROM post_category WHERE post_id = ' . $this->request['id_post'] . ')) AND id != ' . $this->request['id_post'] . ' ORDER BY create_date DESC LIMIT 6');
        $stmt4->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt4->execute();
        $resultPost = $stmt4->fetchAll();
        return $resultPost;
    }
}