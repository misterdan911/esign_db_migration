<?php

// Truncate
$qTrxTte = "TRUNCATE TABLE trx_tte RESTART IDENTITY CASCADE";
$dbEsign->query($qTrxTte);
echo $qTrxTte . PHP_EOL;

// -------------------------------------------------------------
$qTrxOtp = "TRUNCATE TABLE trx_otp RESTART IDENTITY CASCADE";
$dbEsign->query($qTrxOtp);
echo $qTrxOtp . PHP_EOL;

$expired_time = prepareString($dbEsign, date('Y-m-d'));
$qTrxOtp = "INSERT INTO trx_otp (kode_penandatangan, otp, expired_time, udcr) VALUES (NULL, 696969, $expired_time, $expired_time)";
$dbEsign->query($qTrxOtp);
// -------------------------------------------------------------


$qTblSignature = "SELECT * FROM tbl_signature ORDER BY id_signature ASC";
$resTblSignature = $dbProSiplang->query($qTblSignature);

while ($objProSiplang = $dbProSiplang->fetch_object($resTblSignature))
{
    $kode_penandatangan = "NULL";

    $kode_trx_otp = 1;
    $id_otp = $objProSiplang->id_signature_otp;
    $sTblSignatureOtp = "SELECT * FROM tbl_signature_otp WHERE id_signature_otp = $id_otp";
    $resTblSignatureOtp = $dbProSiplang->query($sTblSignatureOtp);
    $objTblSignatureOtp = $dbProSiplang->fetch_object($resTblSignatureOtp);

    if (!empty($objTblSignatureOtp)) {
        $otp = $objTblSignatureOtp->otp;
        $expired_time = prepareString($dbProSiplang, $objTblSignatureOtp->time_expired);
        $udcr = prepareString($dbProSiplang, $objTblSignatureOtp->time);
        $qTrxOtp = "INSERT INTO trx_otp (kode_penandatangan, otp, expired_time, udcr) VALUES ($kode_penandatangan, $otp, $expired_time, $expired_time) RETURNING kode_trx_otp";
        $rsTrxOtp = $dbEsign->query($qTrxOtp);
 
        $rowTrxOtp = pg_fetch_row($rsTrxOtp);
        $kode_trx_otp = $rowTrxOtp['0'];
    }

    // $kode_trx_otp = "???";

    $jenis_signature = prepareString($dbEsign, $objProSiplang->jenis_signature);
    $tte = prepareString($dbEsign, $objProSiplang->tte);
    $barcode = prepareString($dbEsign, $objProSiplang->hash_final_barcode);
    $dok = prepareString($dbEsign, $objProSiplang->hash_final_dok);
    $udcr = prepareString($dbEsign, $objProSiplang->created_at);

    $qTrxTte = "INSERT INTO trx_tte (kode_penandatangan, kode_trx_otp, jenis_signature, tte, barcode, dok, udcr)
    VALUES (
        $kode_penandatangan,
        $kode_trx_otp,
        $jenis_signature,
        $tte,
        $barcode,
        $dok,
        $udcr
    )";

    $dbEsign->query($qTrxTte);

    echo 'tte: ' . $tte . PHP_EOL;
    die('Dieeeeeee');

}
