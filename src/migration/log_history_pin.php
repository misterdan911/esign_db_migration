<?php

// Truncate
$qHistoryPin = "TRUNCATE TABLE log_history_pin RESTART IDENTITY CASCADE";
$dbEsign->query($qHistoryPin);
echo $qHistoryPin . PHP_EOL;

$qHistoryPin = "SELECT * FROM log_history_pin ORDER BY id_log_history_pin ASC";
$resHistoryPin = $dbProEsign->query($qHistoryPin);

echo 'Migrating log_history_pin...' . PHP_EOL;

while($objHistoryPin = $dbProEsign->fetch_object($resHistoryPin))
{
    $kode_log_history_pin = $objHistoryPin->id_log_history_pin;

    // Cari $kode_penandatangan -- START
    $kode_penandatangan = 'NULL';

    if (empty($objHistoryPin->id_pegawai) && !empty($objHistoryPin->id_penyedia)) {
        $qPenyedia = "SELECT * FROM penyedia WHERE id_penyedia = $objHistoryPin->id_penyedia";
        $resPenyedia = $dbProEsign->query($qPenyedia);
        $objPenyedia = $dbProEsign->fetch_object($resPenyedia);

        if (empty($objPenyedia)) {
            echo "dbProEsign.penyedia.id_penyedia: " . $objHistoryPin->id_penyedia . " TIDAK KETEMU" . PHP_EOL;
            echo "qPenyedia: " . $qPenyedia . PHP_EOL;
        }
        elseif (!empty($objPenyedia->id_direksi_perus)) {
            $qPenandatangan = "SELECT kode_penandatangan FROM ref_penandatangan WHERE kode_direksi_perus = $objPenyedia->id_direksi_perus";
            $resPenandatangan = $dbEsign->query($qPenandatangan);
            $objPenandatangan = $dbEsign->fetch_object($resPenandatangan);
            if (!empty($objPenandatangan)) {
                $kode_penandatangan = $objPenandatangan->kode_penandatangan;
            }
            else {
                echo "dbEsign.ref_penandatangan.kode_direksi_perus: " . $objPenyedia->id_direksi_perus . " TIDAK KETEMU" . PHP_EOL;
                echo "qPenandatangan: " . $qPenandatangan . PHP_EOL;
            }
        }
        elseif (!empty($objPenyedia->id_profil_penyedia)) {
            $qPenandatangan = "SELECT kode_penandatangan FROM ref_penandatangan WHERE kode_vendor = $objPenyedia->id_profil_penyedia";
            $resPenandatangan = $dbEsign->query($qPenandatangan);
            $objPenandatangan = $dbEsign->fetch_object($resPenandatangan);
            if (!empty($objPenandatangan)) {
                $kode_penandatangan = $objPenandatangan->kode_penandatangan;
            }
            else {
                echo "dbEsign.ref_penandatangan.kode_vendor: " . $objPenyedia->id_profil_penyedia . " TIDAK KETEMU" . PHP_EOL;
                echo "qPenandatangan: " . $qPenandatangan . PHP_EOL;
            }
        }
    }
    elseif (!empty($objHistoryPin->id_pegawai) && empty($objHistoryPin->id_penyedia)) {
        $qPegawai = "SELECT * FROM pegawai WHERE id_pegawai = $objHistoryPin->id_pegawai";
        $resPegawai = $dbProEsign->query($qPegawai);
        $objPegawai = $dbProEsign->fetch_object($resPegawai);

        if (empty($objPegawai)) {
            echo "dbProEsign.pegawai.id_pegawai: " . $objHistoryPin->id_pegawai . " TIDAK KETEMU" . PHP_EOL;
            echo "qPegawai: " . $qPegawai . PHP_EOL;
        }
        else {
            $nikPegawai = prepareString($dbEsign, $objPegawai->nik_pegawai);
            $qPenandatangan = "SELECT kode_penandatangan FROM ref_penandatangan WHERE nik = $nikPegawai";
            $resPenandatangan = $dbEsign->query($qPenandatangan);
            $objPenandatangan = $dbEsign->fetch_object($resPenandatangan);
            if (!empty($objPenandatangan)) {
                $kode_penandatangan = $objPenandatangan->kode_penandatangan;
            }
            else {
                echo "dbEsign.ref_penandatangan.nik: " . $nikPegawai . " TIDAK KETEMU" . PHP_EOL;
                echo "qPenandatangan: " . $qPenandatangan . PHP_EOL;
            }
        }
    }
    elseif (empty($objHistoryPin->id_pegawai) && empty($objHistoryPin->id_penyedia)) {
        echo "dbProEsign.log_history_pin: id_pegawai & id_penyedia NULL" . PHP_EOL;
        echo "dbProEsign.log_history_pin.id_log_history_pin: " . $objHistoryPin->id_log_history_pin . PHP_EOL;
    }

    // Cari $kode_penandatangan -- END

    $pin_lama = $objHistoryPin->pin_lama;
    $pin_baru = $objHistoryPin->pin_baru;
    $hash_pin_lama = $objHistoryPin->hash_pin_lama;
    $hash_pin_baru = $objHistoryPin->hash_pin_baru;
    $udcr = $objHistoryPin->created_at;

    // $kode_penandatangan = prepareString($dbEsign, $kode_penandatangan);
    $pin_lama = prepareString($dbEsign, $pin_lama);
    $pin_baru = prepareString($dbEsign, $pin_baru);
    $hash_pin_lama = prepareString($dbEsign, $hash_pin_lama);
    $hash_pin_baru = prepareString($dbEsign, $hash_pin_baru);
    $udcr = prepareString($dbEsign, $udcr);

    
    $qInsertLog = "INSERT INTO log_history_pin (kode_log_history_pin, kode_penandatangan, pin_lama, pin_baru, hash_pin_lama, hash_pin_baru, udcr)
    VALUES (
        $kode_log_history_pin,
        $kode_penandatangan,
        $pin_lama,
        $pin_baru,
        $hash_pin_lama,
        $hash_pin_baru,
        $udcr
    )";

    $dbEsign->query($qInsertLog);
}

// update Sequence
$qSequence = "SELECT setval('log_history_pin_kode_log_history_pin_seq', (SELECT MAX(kode_log_history_pin) FROM log_history_pin))";
$dbEsign->query($qSequence);

echo 'Migrating log_history_pin... SELESAI' . PHP_EOL;
