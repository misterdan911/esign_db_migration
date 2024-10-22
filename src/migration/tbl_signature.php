<?php

// Truncate
$qTrxTte = "TRUNCATE TABLE trx_tte RESTART IDENTITY CASCADE";
$dbEsign->query($qTrxTte);
echo $qTrxTte . PHP_EOL;

$qTrxOtp = "TRUNCATE TABLE trx_otp RESTART IDENTITY CASCADE";
$dbEsign->query($qTrxOtp);
echo $qTrxOtp . PHP_EOL;

$expired_time = date('Y-m-d');
$expired_time = prepareString($dbEsign, $expired_time);
$qTrxOtp = "INSERT INTO trx_otp (kode_penandatangan, otp, expired_time, udcr) VALUES (NULL, 696969, $expired_time, $expired_time)";
$dbEsign->query($qTrxOtp);

die('No Error');


$qTblSignature = "SELECT * FROM tbl_signature ORDER BY id_signature ASC";
$resTblSignature = $dbProEsign->query($qTblSignature);

while ($objProSiplang = $dbProSiplang->fetch_object($resTblSignature))
{
    $kode_penandatangan = "???";

    $id_otp = $objProSiplang->id_signature_otp;
    $sOtp = "SELECT * FROM tbl_signature_otp WHERE id_signature_otp = $id_otp";

    $kode_trx_otp = "???";

    $jenis_signature = $objProSiplang->jenis_signature;
    $tte = $objProSiplang->tte;
    $barcode = $objProSiplang->hash_final_barcode;
    $dok = $objProSiplang->hash_final_dok;
    $udcr = $objProSiplang->created_at;

    $qTrxTte = "INSERT INTO trx_tte (kode_penandatangan, kode_otp, jenis_signature, tte, barcode, dok, udcr)
    VALUES (
        kode_penandatangan
        kode_otp
        jenis_signature
        tte
        barcode
        dok
        udcr
    )";

    $dbEsign->query($qTrxOtp);

    echo 'tte: ' . $tte . PHP_EOL;
}
