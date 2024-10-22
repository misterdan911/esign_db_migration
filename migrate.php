<?php
ini_set("memory_limit", -1);
set_time_limit(0);

require_once('init.php');

$dbEsign = $GLOBALS['db_esign'];
$dbProEsign = $GLOBALS['db_promise_esign'];
$dbProSiplang = $GLOBALS['db_promise_siplang'];

include('src/helper_func.php');

// include('src/migration/pengajuan.php');
include('src/migration/tbl_signature_siplang.php');
// include('src/migration/tbl_signature_otp.php');
