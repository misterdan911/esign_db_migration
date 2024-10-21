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

$qPengajuan = "SELECT * FROM pengajuan ORDER BY id_pengajuan ASC";
$resPengajuan = $dbProEsign->query($qPengajuan);

while ($objPengajuan = $dbProEsign->fetch_object($resPengajuan))
{
    $kode_penandatangan = $objPengajuan->id_pengajuan;
    $kode_kelompok_penandatangan = $kelompok[$objPengajuan->jenis];
    $nama = $objPengajuan->nama;
    $email = $objPengajuan->email;
    $no_hp = $objPengajuan->hp;

    $isPegawai = false;
    $objPegawai = null;
    $objPenyedia = null;

    if ($objPengajuan->jenis == 'pegawai') $isPegawai = true;

    if ($isPegawai) {
      $nik_pegawai = prepareString($dbProEsign, $objPengajuan->nik);
      $qPegawai = "SELECT * FROM pegawai WHERE nik_pegawai = $nik_pegawai";
      $resPegawai = $dbProEsign->query($qPegawai);
      $objPegawai = $dbProEsign->fetch_object($resPegawai);

      // kalau di tabel promise_esign.pegawai datanya tidak ada, loopnya di skip aja
      if ($objPegawai == false) continue;
    }
    else {
      $nik_penyedia = prepareString($dbProEsign, $objPengajuan->nik);
      $qPenyedia = "SELECT * FROM penyedia WHERE nik_penyedia = $nik_penyedia";
      $resPenyedia = $dbProEsign->query($qPenyedia);
      $objPenyedia = $dbProEsign->fetch_object($resPenyedia);

      // kalau di tabel promise_esign.vendor datanya tidak ada, loopnya di skip aja
      if ($objPenyedia == false) continue;

    }

    $nip = 'NULL';
    $jabatan_direksi = 'NULL';
    $kode_vendor = 'NULL';
    $kode_direksi_perus = 'NULL';
    if ($isPegawai) {
      $nip = $objPegawai->nip_pegawai;
    }
    else {
      $jabatan_direksi = $objPenyedia->jabatan_penyedia;
      $kode_vendor = $objPengajuan->id_profil_penyedia;
      $kode_direksi_perus = $objPengajuan->id_direksi_perus;
    }


    $nik = $objPengajuan->nik;
    $scan_ktp = $objPengajuan->ktp;

    if ($objPengajuan->status = 1 || $objPengajuan->status = 2) {
      $status_permohonan = 'terima';
    }
    else {
      $status_permohonan = 'tolak';
    }

    $alasan_ditolak = $objPengajuan->komentar;
    $user_verif = 'NULL';

    if ($isPegawai) {
      $pin = $objPegawai->pin_pegawai;
      $tte = $objPegawai->tte_pegawai;
    }
    else {
      $pin = $objPenyedia->pin_penyedia;
      $tte = $objPenyedia->tte_penyedia;
    }

    $reset_token = 'NULL';
    $token_expired_time = 'NULL';
    $udcr = $objPengajuan->created_at;
    $udch = $objPengajuan->updated_at;

    // prepare string
    $kode_direksi_perus = prepareInteger($kode_direksi_perus);
    $nama = prepareString($dbEsign, $nama);
    $email = prepareString($dbEsign, $email);
    $no_hp = prepareString($dbEsign, $no_hp);
    $nip = prepareString($dbEsign, $nip);
    $nik = prepareString($dbEsign, $nik);
    $scan_ktp = prepareString($dbEsign, $scan_ktp);
    $jabatan_direksi = prepareString($dbEsign, $jabatan_direksi);
    $status_permohonan = prepareString($dbEsign, $status_permohonan);
    $alasan_ditolak = prepareString($dbEsign, $alasan_ditolak);
    $user_verif = prepareString($dbEsign, $user_verif);
    $pin = prepareString($dbEsign, $pin);
    $tte = prepareString($dbEsign, $tte);
    $reset_token = prepareString($dbEsign, $reset_token);
    $token_expired_time = prepareString($dbEsign, $token_expired_time);
    $udcr = prepareString($dbEsign, $udcr);
    $udch = prepareString($dbEsign, $udch);


    // kasus khusus
    // ------------------------------
    if (!$isPegawai && empty($objPengajuan->id_profil_penyedia) && empty($objPengajuan->id_direksi_perus)) {
      continue;
    }
    // ------------------------------


    $qRefPenandatangan = "INSERT INTO ref_penandatangan (kode_penandatangan, kode_kelompok_penandatangan, nama, email, no_hp, nip, nik, scan_ktp, kode_vendor, kode_direksi_perus, jabatan_direksi, status_permohonan, alasan_ditolak, user_verif, pin, tte, reset_token, token_expired_time, udcr, udch)
    VALUES (
      $kode_penandatangan,
      $kode_kelompok_penandatangan,
      $nama,
      $email,
      $no_hp,
      $nip,
      $nik,
      $scan_ktp,
      $kode_vendor,
      $kode_direksi_perus,
      $jabatan_direksi,
      $status_permohonan,
      $alasan_ditolak,
      $user_verif,
      $pin,
      $tte,
      $reset_token,
      $token_expired_time,
      $udcr,
      $udch
    )";

    $dbEsign->query($qRefPenandatangan);

    echo 'nama: ' . $nama . PHP_EOL;
}
