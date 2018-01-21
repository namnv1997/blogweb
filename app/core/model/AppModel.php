<?php
namespace app\core\model;

use data\base\Database;

abstract class AppModel
{
    protected $table = '';
    protected $db;
    protected $request;

    public function __construct($tb)
    {
        $base = new Database();
        $this->db = $base->connect();
        $this->request = $_REQUEST;
        $this->table = $tb;

    }

    public abstract function add();

    public abstract function edit();

    public abstract function createFirstInformation();


    public abstract function delete();



}
