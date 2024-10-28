<?php

class DB_OLD {

    protected $db;
    public $affected_rows;

    public function __construct()
    {
        // connect to db
        $db = new mysqli(DB_HOST_OLD, DB_USERNAME_OLD, DB_PASSWORD_OLD, DB_DATABASE_OLD, DB_PORT_OLD);
        
        // check connection
        if ($db->connect_errno) {
            echo "Failed to connect to DB_OLD: " . $db->connect_error;
            exit();
        }

        echo "Successfully connect to DB_OLD" . "\n";
        
        $this->db = $db;
    }

    public function query($q)
    {
        $res = $this->db->query($q);

        if (!$res) {
            throw new Exception($this->db->error . ", Query: " . $q, $this->db->errno);
        }

        $this->affected_rows = $this->db->affected_rows;

        return $res;
    }

    public function fetch_object($res)
    {
        return $res->fetch_object();
    }

    public function real_escape_string($string)
    {
        return $this->db->real_escape_string($string);
    }
    
}