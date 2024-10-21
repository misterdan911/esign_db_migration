<?php

class DB_PG
{

    public $db;
    public $affected_rows;

    public function __construct()
    {
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
