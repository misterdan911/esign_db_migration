<?php

// Truncate
$qRefPenandatangan = "TRUNCATE TABLE ref_penandatangan RESTART IDENTITY CASCADE";
$dbEsign->query($qRefPenandatangan);
echo $qRefPenandatangan . PHP_EOL;

$kelompok = [
    'pegawai' => 1,
    'penyedia_perusahaan_dpt' => 2,
    'penyedia_perusahaan_luardpt' => 3,
    'penyedia_perorangan_dpt' => 4,
    'penyedia_perorangan_luardpt' => 5,
];

// migrasi tabel pegawai ke ref_penandatangan   ---   START
$qPegawai = "SELECT * FROM pegawai ORDER BY id_pegawai ASC";
$resPegawai = $dbProEsign->query($qPegawai);
$objData = new stdClass();

echo "Migrasi tabel pegawai..." . PHP_EOL;

$arrPegawai = [];

while ($objPegawai = $dbProEsign->fetch_object($resPegawai))
{
    // // skip data kalau NIK nya udah ada sebelumnya
    // if (isset($arrPegawai[$objPegawai->nik_pegawai]) && ($objPegawai->nik_pegawai != '-') ) {
    //     continue;
    // };

    // kalu NIK dan email nya sama dengan data sebelumnya, terindikasi data dobel, maka tidak di insert ke tabel ref_penandatangan
    $arrKey = $objPegawai->email_pegawai .'_'. $objPegawai->nik_pegawai;
    if (isset($arrPegawai[$arrKey])) {
        continue;
    }

    $objData->kode_kelompok_penandatangan = 1;
    $objData->nama = $objPegawai->nama_pegawai;
    $objData->email = $objPegawai->email_pegawai;
    $objData->no_hp = $objPegawai->hp_pegawai;
    $objData->nip = $objPegawai->nip_pegawai;
    $objData->nik = $objPegawai->nik_pegawai;
    $objData->scan_ktp = $objPegawai->ktp_pegawai;
    $objData->kode_vendor = 'NULL';
    $objData->kode_direksi_perus = 'NULL';
    $objData->jabatan_direksi = 'NULL';
    $objData->status_permohonan = 'terima';
    $objData->alasan_ditolak = 'NULL';
    $objData->user_verif = 'NULL';
    $objData->pin = $objPegawai->pin_pegawai;
    $objData->tte = $objPegawai->tte_pegawai;
    $objData->reset_token = 'NULL';
    $objData->token_expired_time = 'NULL';
    $objData->udcr = $objPegawai->created_at;
    $objData->udch = $objPegawai->updated_at;

    $objData->nama = prepareString($dbEsign, $objData->nama);
    $objData->email = prepareString($dbEsign, $objData->email);
    $objData->no_hp = prepareString($dbEsign, $objData->no_hp);
    $objData->nip = prepareString($dbEsign, $objData->nip);
    $objData->nik = prepareString($dbEsign, $objData->nik);
    $objData->scan_ktp = prepareString($dbEsign, $objData->scan_ktp);
    $objData->kode_vendor = prepareString($dbEsign, $objData->kode_vendor);
    $objData->kode_direksi_perus = prepareString($dbEsign, $objData->kode_direksi_perus);
    $objData->jabatan_direksi = prepareString($dbEsign, $objData->jabatan_direksi);
    $objData->status_permohonan = prepareString($dbEsign, $objData->status_permohonan);
    $objData->alasan_ditolak = prepareString($dbEsign, $objData->alasan_ditolak);
    $objData->user_verif = prepareString($dbEsign, $objData->user_verif);
    $objData->pin = prepareString($dbEsign, $objData->pin);
    $objData->tte = prepareString($dbEsign, $objData->tte);
    $objData->reset_token = prepareString($dbEsign, $objData->reset_token);
    $objData->token_expired_time = prepareString($dbEsign, $objData->token_expired_time);
    $objData->udcr = prepareString($dbEsign, $objData->udcr);
    $objData->udch = prepareString($dbEsign, $objData->udch);

    insertToRefPenandatangan($objData);

    $arrKey = $objPegawai->email_pegawai .'_'. $objPegawai->nik_pegawai;
    $arrPegawai[$arrKey] = 1;
}

echo "Migrasi tabel pegawai... SELESAI" . PHP_EOL;
// migrasi tabel pegawai ke ref_penandatangan   ---   END




// migrasi tabel penyedia ke ref_penandatangan   ---   START
$qPenyedia = "SELECT * FROM penyedia ORDER BY id_penyedia ASC";
$resPenyedia = $dbProEsign->query($qPenyedia);
$objData = new stdClass();

echo "Migrasi tabel penyedia..." . PHP_EOL;

$arrPenyedia = [];

while ($objPenyedia = $dbProEsign->fetch_object($resPenyedia))
{
    // kalau NIK dan email nya sama dengan data sebelumnya, terindikasi data dobel, maka tidak di insert ke tabel ref_penandatangan
    $arrKey = $objPenyedia->email_penyedia .'_'. $objPenyedia->nik_penyedia;
    if (isset($arrPenyedia[$arrKey])) {
        continue;
    }

    // Dapatkan kode_kelompok_penandatangan -- START
    $emailPengajuan = $dbProEsign->escape_string($objPenyedia->email_penyedia);
    $nikPengajuan = $dbProEsign->escape_string($objPenyedia->nik_penyedia);
    $qPengajuan = "SELECT jenis FROM pengajuan WHERE email = '$emailPengajuan' AND nik = '$nikPengajuan'";
    // echo "qPengajuan: " . $qPengajuan . PHP_EOL;
    $resPengajuan = $dbProEsign->query($qPengajuan);
    $objPengajuan = $dbProEsign->fetch_object($resPengajuan);

    if (!empty($objPengajuan)) {
        $objData->kode_kelompok_penandatangan = $kelompok[$objPengajuan->jenis];
    }
    else {
        $objData->kode_kelompok_penandatangan = 'NULL';
    }

    // Dapatkan kode_kelompok_penandatangan -- END

    $objData->nama = $objPenyedia->nama_penyedia;
    $objData->email = $objPenyedia->email_penyedia;
    $objData->no_hp = $objPenyedia->hp_penyedia;
    $objData->nip = 'NULL';
    $objData->nik = $objPenyedia->nik_penyedia;
    $objData->scan_ktp = $objPenyedia->ktp_penyedia;
    $objData->kode_vendor = $objPenyedia->id_profil_penyedia;
    $objData->kode_direksi_perus = $objPenyedia->id_direksi_perus;
    $objData->jabatan_direksi = $objPenyedia->jabatan_penyedia;
    $objData->status_permohonan = 'terima';
    $objData->alasan_ditolak = 'NULL';
    $objData->user_verif = 'NULL';
    $objData->pin = $objPenyedia->pin_penyedia;
    $objData->tte = $objPenyedia->tte_penyedia;
    $objData->reset_token = 'NULL';
    $objData->token_expired_time = 'NULL';
    $objData->udcr = $objPenyedia->created_at;
    $objData->udch = $objPenyedia->updated_at;

    $objData->nama = prepareString($dbEsign, $objData->nama);
    $objData->email = prepareString($dbEsign, $objData->email);
    $objData->no_hp = prepareString($dbEsign, $objData->no_hp);
    $objData->nip = prepareString($dbEsign, $objData->nip);
    $objData->nik = prepareString($dbEsign, $objData->nik);
    $objData->scan_ktp = prepareString($dbEsign, $objData->scan_ktp);
    $objData->kode_vendor = prepareString($dbEsign, $objData->kode_vendor);
    $objData->kode_direksi_perus = prepareString($dbEsign, $objData->kode_direksi_perus);
    $objData->jabatan_direksi = prepareString($dbEsign, $objData->jabatan_direksi);
    $objData->status_permohonan = prepareString($dbEsign, $objData->status_permohonan);
    $objData->alasan_ditolak = prepareString($dbEsign, $objData->alasan_ditolak);
    $objData->user_verif = prepareString($dbEsign, $objData->user_verif);
    $objData->pin = prepareString($dbEsign, $objData->pin);
    $objData->tte = prepareString($dbEsign, $objData->tte);
    $objData->reset_token = prepareString($dbEsign, $objData->reset_token);
    $objData->token_expired_time = prepareString($dbEsign, $objData->token_expired_time);
    $objData->udcr = prepareString($dbEsign, $objData->udcr);
    $objData->udch = prepareString($dbEsign, $objData->udch);

    insertToRefPenandatangan($objData);

    $arrKey = $objPenyedia->email_penyedia .'_'. $objPenyedia->nik_penyedia;
    $arrPenyedia[$arrKey] = 1;
}

echo "Migrasi tabel penyedia... SELESAI" . PHP_EOL;
// migrasi tabel pegawai ke ref_penandatangan   ---   END




function insertToRefPenandatangan($objData)
{
    $dbEsign = $GLOBALS['db_esign'];

    $qRefPenandatangan = "INSERT INTO ref_penandatangan (kode_kelompok_penandatangan, nama, email, no_hp, nip, nik, scan_ktp, kode_vendor, kode_direksi_perus, jabatan_direksi, status_permohonan, alasan_ditolak, user_verif, pin, tte, reset_token, token_expired_time, udcr, udch)
    VALUES (
      $objData->kode_kelompok_penandatangan,
      $objData->nama,
      $objData->email,
      $objData->no_hp,
      $objData->nip,
      $objData->nik,
      $objData->scan_ktp,
      $objData->kode_vendor,
      $objData->kode_direksi_perus,
      $objData->jabatan_direksi,
      $objData->status_permohonan,
      $objData->alasan_ditolak,
      $objData->user_verif,
      $objData->pin,
      $objData->tte,
      $objData->reset_token,
      $objData->token_expired_time,
      $objData->udcr,
      $objData->udch
    )";

    $dbEsign->query($qRefPenandatangan);

    // echo 'nama: ' . $objData->nama . PHP_EOL;
}
