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

    $table_log = prepareString($dbEsign, $table_log);
    $crud_log = prepareString($dbEsign, $crud_log);
    $desc_log = prepareString($dbEsign, $desc_log);
    $udcr = prepareString($dbEsign, $udcr);
    $udch = prepareString($dbEsign, $udch);


    $qInsertLog = "INSERT INTO log_pengajuan (kode_log_pengajuan, table_log, crud_log, desc_log, udcr, udch)
    VALUES (
        $kode_log_pengajuan,
        $table_log,
        $crud_log,
        $desc_log,
        $udcr,
        $udch
    )";

    $dbEsign->query($qInsertLog);
}

// update Sequence
$qSequence = "SELECT setval('log_pengajuan_kode_log_pengajuan_seq', (SELECT MAX(kode_log_pengajuan) FROM log_pengajuan))";
$dbEsign->query($qSequence);

echo 'Migrating log_pengajuan... SELESAI' . PHP_EOL;
