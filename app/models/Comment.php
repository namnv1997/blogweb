<?php
/**
 * Created by PhpStorm.
 * User: n
 * Date: 15/01/2018
 * Time: 16:46
 */

namespace app\models;


use app\core\model\AppModel;

class Comment extends AppModel
{
    public $table = 'Comment';

    public function __construct()
    {
        parent::__construct($this->table);
    }

    public function add()
    {
        $post_id = $this->request['post_id'];
        $user_id = $this->request['user_id'];
        $comment = $this->request['comment'];

        $stmt = $this->db->prepare('INSERT INTO comment(user_id, post_id, comment) values (:user_id, :post_id, :comment)');
        $stmt->bindParam(':post_id', $post_id, \PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
        $stmt->bindParam(':comment', $comment, \PDO::PARAM_STR);
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute();
    }

    public function confirm(){
        $sql = "UPDATE comment SET status = :stt WHERE cmt_id = :mID";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':stt', $this->request['status'], \PDO::PARAM_STR);
        $stmt->bindParam(':mID', $this->request['cmt_id'], \PDO::PARAM_INT);
        $stmt->execute();
    }

    public function changePagination(){
        $response = array();
        $page = ($this->request['comment_pagination'] - 1) * 5;
        $stmt = $this->db->prepare('SELECT * from comment LIMIT 5 OFFSET ' . $page . ' ');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute();
        $resultSet = $stmt->fetchAll();
        foreach ($resultSet as $row) {
            array_push($response, array("cmt_id" => $row['cmt_id'], "post_id" => $row['post_id'], "user_id" => $row['user_id'], "comment" => $row['comment'], "status" => $row['status']));
        }
        return $response;
    }

    public function getFirstInfo(){
        $stmt = $this->db->prepare('SELECT * from comment LIMIT 5 OFFSET 0');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute();
        $resultSet = $stmt->fetchAll();

        return $resultSet;
    }

    public function getCount(){
        $stmt2 = $this->db->prepare('SELECT count(comment) from comment');
        $stmt2->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt2->execute();
        $count = $stmt2->fetchColumn();
        return $count;
    }

    public function getCommentById($id){
        $stmt5 = $this->db->prepare('SELECT * from comment WHERE post_id=' . $id . ' AND status=1');
        $stmt5->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt5->execute();
        $cmtResult = $stmt5->fetchAll();
        return $cmtResult;
    }

    public function edit()
    {
        // TODO: Implement edit() method.
    }

    public function createFirstInformation()
    {
        // TODO: Implement createFirstInformation() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}