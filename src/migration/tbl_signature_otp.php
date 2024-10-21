<?php

// Truncate
$qTrxOtp = "TRUNCATE TABLE trx_otp RESTART IDENTITY CASCADE";
$dbNew->query($qTrxOtp);
echo $qTrxOtp . PHP_EOL;

$qTblSignatureOtp = "SELECT * FROM tbl_signature_otp ORDER BY id_signature_otp ASC";
$resTblSignatureOtp = $dbOld->query($qTblSignatureOtp);

while ($objTblSignatureOtp = $dbOld->fetch_object($resTblSignatureOtp))
{
    $kode_otp = $objTblSignatureOtp->id_signature_otp;
    $kode_penandatangan = 'NULL';
    $otp = $objTblSignatureOtp->otp;
    $expired_time = $objTblSignatureOtp->time_expired;
    $udcr = $objTblSignatureOtp->time;

    $qTrxOtp = "INSERT INTO trx_otp (kode_otp, kode_penandatangan, otp, expired_time, udcr)
    VALUES (
        $kode_otp,
        $kode_penandatangan,
        $otp,
        $expired_time,
        $udcr
    )";

    $dbNew->query($qTrxOtp);

    echo 'otp: ' . $otp . PHP_EOL;
}
