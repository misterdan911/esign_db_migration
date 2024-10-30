<?php

// Truncate
$qLogPegawai = "TRUNCATE TABLE log_pegawai RESTART IDENTITY CASCADE";
$dbEsign->query($qLogPegawai);
echo $qLogPegawai . PHP_EOL;

$qLogPegawai = "SELECT * FROM log_pegawai ORDER BY id_log_pegawai ASC";
$resLogPegawai = $dbProEsign->query($qLogPegawai);

echo 'Migrating log_pegawai...' . PHP_EOL;

while($objLogPegawai = $dbProEsign->fetch_object($resLogPegawai))
{
    $kode_log_pegawai = $objLogPegawai->id_log_pegawai;
    $table_log_pegawai = $objLogPegawai->table_log_pegawai;
    $crud_log_pegawai = $objLogPegawai->crud_log_pegawai;
    $desc_log_pegawai = $objLogPegawai->desc_log_pegawai;
    $udcr = $objLogPegawai->created_at;
    $udch = $objLogPegawai->updated_at;

    $table_log_pegawai = prepareString($dbEsign, $table_log_pegawai);
    $crud_log_pegawai = prepareString($dbEsign, $crud_log_pegawai);
    $desc_log_pegawai = prepareString($dbEsign, $desc_log_pegawai);
    $udcr = prepareString($dbEsign, $udcr);
    $udch = prepareString($dbEsign, $udch);

    
    $qInsertLog = "INSERT INTO log_pegawai (kode_log_pegawai, table_log_pegawai, crud_log_pegawai, desc_log_pegawai, udcr, udch)
    VALUES (
        $kode_log_pegawai,
        $table_log_pegawai,
        $crud_log_pegawai,
        $desc_log_pegawai,
        $udcr,
        $udch
    )";

    $dbEsign->query($qInsertLog);
}

// update Sequence
$qSequence = "SELECT setval('log_pegawai_kode_log_pegawai_seq', (SELECT MAX(kode_log_pegawai) FROM log_pegawai))";
$dbEsign->query($qSequence);

echo 'Migrating log_pegawai... SELESAI' . PHP_EOL;
    