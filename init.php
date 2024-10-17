<?php
date_default_timezone_set("Asia/Jakarta");
// header('Access-Control-Allow-Origin: *');
// header('Access-Control-Allow-Methods: GET, POST');
// header("Access-Control-Allow-Headers: X-Requested-With");
// header("Content-Type: application/json");

define('BASE_PATH', getcwd());

// require_once(BASE_PATH . '/vendor/autoload.php');

require_once(BASE_PATH . '/config.php');
require_once(BASE_PATH . '/src/Log.php');
require_once(BASE_PATH . '/src/DB_OLD_PG.php');
require_once(BASE_PATH . '/src/DB_NEW.php');
// require_once(BASE_PATH . '/src/Request.php');
require_once(BASE_PATH . '/src/Encoding.php');

$GLOBALS['db_old'] = new DB_OLD();
$GLOBALS['db_new'] = new DB_NEW();

