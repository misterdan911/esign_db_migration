<?php

// Truncate
$qTrxTte = "TRUNCATE TABLE trx_tte RESTART IDENTITY CASCADE";
$dbEsign->query($qTrxTte);
echo $qTrxTte . PHP_EOL;


$qTblSignature = "SELECT * FROM tbl_signature ORDER BY id_signature ASC";
$resTblSignature = $dbProSiplang->query($qTblSignature);

echo "Migrasi tabel promise_siplang.tbl_signature..." . PHP_EOL;

while ($objTblSignature = $dbProSiplang->fetch_object($resTblSignature))
{
    // buat dapetin $kode_penandatangan -- start
    $kode_penandatangan = "NULL";

    // kalau id_profil_penyedia & id_direksi_perus kosong berati dia adalah pegawai
    if (empty($objTblSignature->id_profil_penyedia) && empty($objTblSignature->id_direksi_perus))
    {
        $qUser = "SELECT email, email_real FROM users WHERE id = $objTblSignature->id_user";
        // echo $qUser . PHP_EOL;
        $resUser = $dbVms->query($qUser);
        $objUser = $dbVms->fetch_object($resUser);

        if (!empty($objUser)) {
            $email = $objUser->email_real;
        }
        else {
            // Kalo user gak ketemu gimana ????
        }
        
        $qPenandatangan = "select kode_penandatangan from ref_penandatangan where email = '$email'";
        $rsPenandatangan = $dbEsign->query($qPenandatangan);
        $objPenandatangan = $dbEsign->fetch_object($rsPenandatangan);

        if (!empty($objPenandatangan)) {
            $kode_penandatangan = $objPenandatangan->kode_penandatangan;
        } else {
            // kalo datanya gak ketemu gimana Hayoooo
        }
    }
    elseif (!empty($objTblSignature->id_direksi_perus))
    {
        // Udah pasti Penyedia
        $kodeDireksiPerus = $objTblSignature->id_direksi_perus;
        $kodeVendor = $objTblSignature->id_profil_penyedia;

        $qPenandatangan = "SELECT kode_penandatangan FROM ref_penandatangan WHERE kode_direksi_perus = $kodeDireksiPerus AND kode_vendor = $kodeVendor";

        $rsPenandatangan = $dbEsign->query($qPenandatangan);
        $objPenandatangan = $dbEsign->fetch_object($rsPenandatangan);

        if (!empty($objPenandatangan)) {
            $kode_penandatangan = $objPenandatangan->kode_penandatangan;
        } else {
            // kalo datanya gak ketemu gimana ???
        }
    }
    elseif(!empty($objTblSignature->id_profil_penyedia))
    {
        // Berarti penyedia perorangan
        $kodeVendor = $objTblSignature->id_profil_penyedia;
        $qPenandatangan = "SELECT kode_penandatangan FROM ref_penandatangan WHERE kode_vendor = $kodeVendor AND kode_direksi_perus IS NULL";

        $rsPenandatangan = $dbEsign->query($qPenandatangan);
        $objPenandatangan = $dbEsign->fetch_object($rsPenandatangan);

        if (!empty($objPenandatangan)) {
            $kode_penandatangan = $objPenandatangan->kode_penandatangan;
        } else {
            // kalo datanya gak ketemu gimana ???
        }        
    }

    // buat dapetin $kode_penandatangan -- end

    // buat dapetin $kode_trx_otp -- start
    $kode_trx_otp = 1;
    $id_otp = $objTblSignature->id_signature_otp;
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
    // buat dapetin $kode_trx_otp -- end

    $jenis_signature = prepareString($dbEsign, $objTblSignature->jenis_signature);
    $tte = prepareString($dbEsign, $objTblSignature->tte);
    $barcode = prepareString($dbEsign, $objTblSignature->hash_final_barcode);
    $dok = prepareString($dbEsign, $objTblSignature->hash_final_dok);
    $udcr = prepareString($dbEsign, $objTblSignature->created_at);

    $qTrxTte = "INSERT INTO trx_tte (kode_penandatangan, kode_trx_otp, jenis_signature, tte, barcode, dok, udcr)
    VALUES (
        $kode_penandatangan,
        $kode_trx_otp,
        $jenis_signature,
        $tte,
        $barcode,
        $dok,
        $udcr
    ) RETURNING kode_tte";

    $resInsert = $dbEsign->query($qTrxTte);
    $rowInsert = pg_fetch_row($resInsert);
    $kode_tte = $rowInsert['0'];

    // Isi tabel log_history -- START
    if (!empty($kode_penandatangan)) {
        $qLogHistory = "SELECT * FROM log_history WHERE id_signature = $objTblSignature->id_signature AND modul_promise = 'siplang'";
        // echo $qLogHistory . PHP_EOL;
        $resLogHistory = $dbProEsign->query($qLogHistory);
        $objLogHistory = $dbProEsign->fetch_object($resLogHistory);

        if (!empty($objLogHistory))
        {
            $modul_promise = $objLogHistory->modul_promise;
            $hash_id_user = $objLogHistory->hash_id_user;
            $hash_tte = $objLogHistory->hash_tte;
            $hash_id_signature = $objLogHistory->hash_id_signature;
            $hash_waktu = $objLogHistory->hash_waktu;
            $hash_final_barcode = $objLogHistory->hash_final_barcode;
            $hash_final_dok = $objLogHistory->hash_final_dok;
            $path_final_barcode = $objLogHistory->path_final_barcode;
            $path_final_dok = $objLogHistory->path_final_dok;
            $base64_dok = $objLogHistory->base64_dok;
            $udcr = $objLogHistory->created_at;

            $modul_promise = prepareString($dbEsign, $modul_promise);
            $hash_id_user = prepareString($dbEsign, $hash_id_user);
            $hash_tte = prepareString($dbEsign, $hash_tte);
            $hash_id_signature = prepareString($dbEsign, $hash_id_signature);
            $hash_waktu = prepareString($dbEsign, $hash_waktu);
            $hash_final_barcode = prepareString($dbEsign, $hash_final_barcode);
            $hash_final_dok = prepareString($dbEsign, $hash_final_dok);
            $path_final_barcode = prepareString($dbEsign, $path_final_barcode);
            $path_final_dok = prepareString($dbEsign, $path_final_dok);
            $base64_dok = prepareString($dbEsign, $base64_dok);
            $udcr = prepareString($dbEsign, $udcr);

            $qInsertLog = "INSERT INTO log_history (kode_tte, modul_promise, hash_id_user, hash_tte, hash_id_signature, hash_waktu, hash_final_barcode, hash_final_dok, path_final_barcode, path_final_dok, base64_dok, udcr)
            VALUES (
                $kode_tte,
                $modul_promise,
                $hash_id_user,
                $hash_tte,
                $hash_id_signature,
                $hash_waktu,
                $hash_final_barcode,
                $hash_final_dok,
                $path_final_barcode,
                $path_final_dok,
                $base64_dok,
                $udcr
            )";
        
            $dbEsign->query($qInsertLog);
        }
    }
    // Isi tabel log_history -- END


    // echo 'tte: ' . $tte . PHP_EOL;
    // die('Dieeeeeee');

}

echo "Migrasi tabel promise_siplang.tbl_signature... SELESAI" . PHP_EOL;

