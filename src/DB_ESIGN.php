<?php

require_once 'DB_PG.php';

class DB_ESIGN extends DB_PG
{
    public $db;
    public $affected_rows;

    public function __construct()
    {
        // connect to db
        $host = DB_HOST;
        $user = DB_USERNAME;
        $password = DB_PASSWORD;
        $dbname = DB_DATABASE_ESIGN;
        $port = DB_PORT;

        $db = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

        // check connection
        if (!$db) {
            die("Failed to connect to DB_ESIGN: " . pg_last_error());
            exit();
        }

        echo "Successfully connect to DB_ESIGN" . "\n";

        $this->db = $db;
    }

}
