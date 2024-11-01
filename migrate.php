<?php
ini_set("memory_limit", -1);
set_time_limit(0);

require_once('init.php');

$dbEsign = $GLOBALS['db_esign'];
$dbProEsign = $GLOBALS['db_promise_esign'];
$dbProSiplang = $GLOBALS['db_promise_siplang'];
$dbProSibela = $GLOBALS['db_promise_sibela'];
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
// // include('src/migration/sibela.tbl_signature.php');

// include('src/migration/log_pengajuan.php');
// include('src/migration/log_pegawai.php');
// include('src/migration/log_penyedia.php');
// include('src/migration/log_history_pin.php');

