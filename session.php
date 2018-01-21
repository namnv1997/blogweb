<?php

class session
{

    protected $sessionID;

    public function __construct()
    {
        if (!isset($_SESSION)) {
            $this->init_sesstion();
        }
    }

    public function init_sesstion()
    {
        session_start();
    }

    public function set_session_id()
    {
        $this->sessionID = session_id();
    }

    public function get_sesstion_id()
    {
        return $this->sessionID;
    }

    public function set_session_data($session_name, $data){
        $_SESSION[$session_name] = $data;
    }

    public function get_session_data($session_name){
        return $_SESSION[$session_name];
    }

    public function session_exist($session_name)
    {
        return isset($_SESSION[$session_name]);
    }

    public function destroy(){
        session_destroy();
    }


}