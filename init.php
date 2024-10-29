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
require_once(BASE_PATH . '/src/DB_ESIGN.php');
require_once(BASE_PATH . '/src/DB_PROMISE_ESIGN.php');
require_once(BASE_PATH . '/src/DB_PROMISE_SIPLANG.php');
require_once(BASE_PATH . '/src/DB_PROMISE_SIBELA.php');
require_once(BASE_PATH . '/src/DB_VMS.php');
require_once(BASE_PATH . '/src/Encoding.php');

$GLOBALS['db_esign'] = new DB_ESIGN();
$GLOBALS['db_promise_esign'] = new DB_PROMISE_ESIGN();
$GLOBALS['db_promise_siplang'] = new DB_PROMISE_SIPLANG();
$GLOBALS['db_promise_sibela'] = new DB_PROMISE_SIBELA();
$GLOBALS['db_vms'] = new DB_VMS();

