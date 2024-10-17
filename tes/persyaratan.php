<?php
ini_set("memory_limit", -1);
set_time_limit(0);

require_once('../init.php');

$dbOld = $GLOBALS['db_old'];
$dbNew = $GLOBALS['db_new'];

$sSelect = "select * from ref_kategori_item";