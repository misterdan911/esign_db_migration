<?php

// Truncate
$qLogPengajuan = "TRUNCATE TABLE log_pengajuan RESTART IDENTITY CASCADE";
$dbEsign->query($qLogPengajuan);
echo $qLogPengajuan . PHP_EOL;

$qLogPengajuan = "SELECT * FROM log_pengajuan ORDER BY id_log ASC";
$resLogPengajuan = $dbProEsign->query($qLogPengajuan);

echo 'Migrating log_pengajuan...' . PHP_EOL;

while($objLogPengajuan = $dbProEsign->fetch_object($resLogPengajuan))
{
    $kode_log_pengajuan = $objLogPengajuan->id_log;
    $table_log = $objLogPengajuan->table_log;
    $crud_log = $objLogPengajuan->crud_log;
    $desc_log = $objLogPengajuan->desc_log;
    $udcr = $objLogPengajuan->created_at;
    $udch = $objLogPengajuan->updated_at;

    $qInsertLog = "INSERT INTO log_pengajuan (kode_log_pengajuan, table_log, crud_log, desc_log, udcr, udch)
    VALUES (
        $kode_log_pengajuan,
        $table_log,
        $crud_log,
        $desc_log,
        $udcr,
        $udch
    )";

    $dbEsign->query($qRefPenandatangan);
}

// TODO: update Sequence

echo 'Migrating log_pengajuan... SELESAI' . PHP_EOL;
