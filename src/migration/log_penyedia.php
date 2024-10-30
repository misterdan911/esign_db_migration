<?php

// Truncate
$qLogPenyedia = "TRUNCATE TABLE log_penyedia RESTART IDENTITY CASCADE";
$dbEsign->query($qLogPenyedia);
echo $qLogPenyedia . PHP_EOL;

$qLogPenyedia = "SELECT * FROM log_penyedia ORDER BY id_log_penyedia ASC";
$resLogPenyedia = $dbProEsign->query($qLogPenyedia);

echo 'Migrating log_penyedia...' . PHP_EOL;

while($objLogPenyedia = $dbProEsign->fetch_object($resLogPenyedia))
{
    $kode_log_penyedia = $objLogPenyedia->id_log_penyedia;
    $table_log_penyedia = $objLogPenyedia->table_log_penyedia;
    $crud_log_penyedia = $objLogPenyedia->crud_log_penyedia;
    $dpt_log_penyedia = $objLogPenyedia->dpt_log_penyedia;
    $tipe_log_penyedia = $objLogPenyedia->tipe_log_penyedia;
    $desc_log_penyedia = $objLogPenyedia->desc_log_penyedia;
    $udcr = $objLogPenyedia->created_at;
    $udch = $objLogPenyedia->updated_at;

    $table_log_penyedia = prepareString($dbEsign, $table_log_penyedia);
    $crud_log_penyedia = prepareString($dbEsign, $crud_log_penyedia);
    $dpt_log_penyedia = prepareString($dbEsign, $dpt_log_penyedia);
    $tipe_log_penyedia = prepareString($dbEsign, $tipe_log_penyedia);
    $desc_log_penyedia = prepareString($dbEsign, $desc_log_penyedia);
    $udcr = prepareString($dbEsign, $udcr);
    $udch = prepareString($dbEsign, $udch);

    $qInsertLog = "INSERT INTO log_penyedia (kode_log_penyedia, table_log_penyedia, crud_log_penyedia, dpt_log_penyedia, tipe_log_penyedia, desc_log_penyedia, udcr, udch)
    VALUES (
        $kode_log_penyedia,
        $table_log_penyedia,
        $crud_log_penyedia,
        $dpt_log_penyedia,
        $tipe_log_penyedia,
        $desc_log_penyedia,
        $udcr,
        $udch
    )";

    $dbEsign->query($qInsertLog);
}

// update Sequence
$qSequence = "SELECT setval('log_penyedia_kode_log_penyedia_seq', (SELECT MAX(kode_log_penyedia) FROM log_penyedia))";
$dbEsign->query($qSequence);

echo 'Migrating log_penyedia... SELESAI' . PHP_EOL;
