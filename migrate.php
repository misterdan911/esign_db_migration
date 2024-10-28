<?php
ini_set("memory_limit", -1);
set_time_limit(0);

require_once('init.php');

$dbEsign = $GLOBALS['db_esign'];
$dbProEsign = $GLOBALS['db_promise_esign'];
$dbProSiplang = $GLOBALS['db_promise_siplang'];
$dbVms = $GLOBALS['db_vms'];

include('src/helper_func.php');

// include('src/migration/penandatangan.php');


// -------------------------------------------------------------
$qTrxOtp = "TRUNCATE TABLE trx_otp RESTART IDENTITY CASCADE";
$dbEsign->query($qTrxOtp);
echo $qTrxOtp . PHP_EOL;

$expired_time = prepareString($dbEsign, date('Y-m-d'));
$qTrxOtp = "INSERT INTO trx_otp (kode_penandatangan, otp, expired_time, udcr) VALUES (NULL, 696969, $expired_time, $expired_time)";
$dbEsign->query($qTrxOtp);
// -------------------------------------------------------------

include('src/migration/siplang.tbl_signature.php');
// include('src/migration/tbl_signature_otp.php');
