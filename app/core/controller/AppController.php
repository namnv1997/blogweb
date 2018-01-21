<?php
namespace app\core\controller;
use data\base\Database;

class AppController
{
    protected $db;
    protected $request;
    protected $session;

    public function __construct()
    {
        $base = new Database();
        $this->db = $base->connect();
        $this->request = $_REQUEST;
        $this->session = new \session();
    }

}