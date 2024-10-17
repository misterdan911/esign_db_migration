<?php

class DB_NEW
{

    public $db;
    public $affected_rows;

    public function __construct()
    {
        // connect to db
        // $db = pg_connect(DB_HOST_NEW, DB_USERNAME_NEW, DB_PASSWORD_NEW, DB_DATABASE_NEW, DB_PORT_NEW);
        $host = DB_HOST_NEW;
        $user = DB_USERNAME_NEW;
        $password = DB_PASSWORD_NEW;
        $dbname = DB_DATABASE_NEW;
        $port = DB_PORT_NEW;

        $db = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

        // check connection
        if (!$db) {
            // echo "Failed to connect to DB_NEW: " . $db->connect_error . "\n";
            // echo "An error occurred while connecting to the database.";
            die("Failed to connect to DB_NEW: " . pg_last_error());
            exit();
        }

        echo "Successfully connect to DB_NEW" . "\n";

        $this->db = $db;
    }

    public function query($q)
    {
        $res = pg_query($this->db, $q);

        if (!$res) {
            throw new Exception(pg_last_error($this->db) . ", Query: " . $q);
        }

        return $res;
    }

    public function fetch_object($res)
    {
        return pg_fetch_object($res);
    }


    public function escape_string($string)
    {
        if (empty($string)) return null;
        return pg_escape_string($this->db, $string);
    }
}
