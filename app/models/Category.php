<?php
/**
 * Created by PhpStorm.
 * User: n
 * Date: 21/01/2018
 * Time: 21:21
 */

namespace app\models;


use app\core\model\AppModel;

class Category extends AppModel
{
    protected $tb = 'Category';

    public function __construct()
    {
        parent::__construct($this->tb);
    }

    public function createFirstInformation()
    {
        $stmt = $this->db->prepare('SELECT id, name from category LIMIT 10 OFFSET 0');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute();
        $resultSet = $stmt->fetchAll();
        return $resultSet;
    }

    public function getCountCategory(){
        $stmt2 = $this->db->prepare('SELECT count(id) from category');
        $stmt2->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt2->execute();
        $count = $stmt2->fetchColumn();
        return $count;
    }

    public function getMoreCategory()
    {
        $response = array();
        $page = ($this->request['category_pagination'] - 1) * 10;
        $stmt = $this->db->prepare('SELECT id, name from category LIMIT 10 OFFSET ' . $page . ' ');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute();
        $resultSet = $stmt->fetchAll();

        foreach ($resultSet as $row) {
            array_push($response, array("id" => $row['id'], "name" => $row['name']));
        }

        return $response;
    }

    public function add()
    {
        $name = $this->request['category_name'];
        $stmt = $this->db->prepare('INSERT INTO category(name) values (:name)');
        $stmt->bindParam(':name', $name);
        $stmt->execute();
    }

    public function edit()
    {
        $sql = "UPDATE category SET name = :mName WHERE id = :mID";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':mName', $this->request['category_name_edit'], \PDO::PARAM_STR);
        $stmt->bindParam(':mID', $this->request['category_id_edit'], \PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getName(){
        $array_name = array();
        $stmt = $this->db->prepare('SELECT name from category');
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt->execute();
        $resultSet = $stmt->fetchAll();
        foreach ($resultSet as $row) {
            array_push($array_name, $row['name']);
        }
        array_push($array_name, null);
        return $array_name;
    }

    public function getCategoryMost(){
        $stmt_category = $this->db->prepare('SELECT COUNT(post_id), category_id FROM post_category GROUP BY category_id ORDER BY COUNT(post_id) DESC LIMIT 16');
        $stmt_category->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt_category->execute();
        $resultCategory = $stmt_category->fetchAll();
        return $resultCategory;
    }

    public function getCategoryById($id){
        $stmt_popular = $this->db->prepare('SELECT * FROM category WHERE id = ' . $id . ' ');
        $stmt_popular->setFetchMode(\PDO::FETCH_ASSOC);
        $stmt_popular->execute();
        $resultPopular = $stmt_popular->fetchAll();
        return $resultPopular;
    }

    public function delete()
    {
        $sql = "DELETE FROM category WHERE id = :mID";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':mID', $this->request['category_id_delete'], \PDO::PARAM_INT);
        $stmt->execute();
    }
}