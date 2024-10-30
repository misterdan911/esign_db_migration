<?php

class DB_PROMISE_SIBELA extends DB_PG
{

    public $db;
    public $affected_rows;

    public function __construct()
    {
        // connect to db
        $host = DB_HOST;
        $user = DB_USERNAME;
        $password = DB_PASSWORD;
        $dbname = DB_DATABASE_PROMISE_SIPLANG;
        $port = DB_PORT;

        $db = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

        // check connection
        if (!$db) {
            // echo "Failed to connect to DB_PROMISE_SIBELA: " . $db->connect_error . "\n";
            // echo "An error occurred while connecting to the database.";
            die("Failed to connect to DB_PROMISE_SIBELA: " . pg_last_error());
            exit();
        }

        echo "Successfully connect to DB_PROMISE_SIBELA" . "\n";

        $this->db = $db;
    }

    /*
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
    */
}
