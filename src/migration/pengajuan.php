<?php

// Truncate
$qRefPenandatangan = "TRUNCATE TABLE ref_penandatangan RESTART IDENTITY CASCADE";
$dbNew->query($qRefPenandatangan);
echo $qRefPenandatangan . PHP_EOL;


// info
// nik
// ktp
// pin
// status
// komentar
// id_user
// updated_at
// created_at


$kelompok = [
  'pegawai' => 1,
  'penyedia_perusahaan_dpt' => 2,
  'penyedia_perusahaan_luardpt' => 3,
  'penyedia_perorangan_dpt' => 4,
  'penyedia_perorangan_luardpt' => 5,
];


$qPengajuan = "SELECT * FROM pengajuan ORDER BY id_pengajuan ASC";
$resPengajuan = $dbOld->query($qPengajuan);

while ($objPengajuan = $dbOld->fetch_object($resPengajuan))
{
    $kode_penandatangan = $objPengajuan->id_pengajuan;
    $kode_kelompok_penandatangan = $kelompok[$objPengajuan->jenis];
    $nama = $objPengajuan->nama;
    $email = $objPengajuan->email;
    $no_hp = $objPengajuan->hp;

    if ($objPengajuan->jenis == 'pegawai')
    {
      $qPegawai = "SELECT * FROM pegawai WHERE nik_pegawai = '$objPengajuan->nik'";
      $resPegawai = $dbOld->query($qPegawai);

      $objPegawai = $dbOld->fetch_object($resPegawai);

      if ($objPegawai == false) {
        continue;
      }
      else {
        $nip = $objPengajuan->penandatangan;
      }
      
    }
    
    $nik = $objPengajuan->nik;
    $scan_ktp = $objPengajuan->ktp;

    $kode_vendor = $objPengajuan->id_profil_penyedia;
    $kode_direksi_perus = $objPengajuan->id_direksi_perus;
    $jabatan_direksi = $objPengajuan->penandatangan;

    /*
    $status_permohonan = $objPengajuan->penandatangan;
    $alasan_ditolak = $objPengajuan->penandatangan;
    $user_verif = $objPengajuan->penandatangan;
    $pin = $objPengajuan->penandatangan;
    $tte = $objPengajuan->penandatangan;
    $reset_token = $objPengajuan->penandatangan;
    $token_expired_time = $objPengajuan->penandatangan;
    $udcr = $objPengajuan->penandatangan;
    $udch = $objPengajuan->penandatangan;

    $qRefPenandatangan = "INSERT INTO ref_penandatangan (kode_penandatangan, kode_kelompok_penandatangan, nama, email, no_hp, nip, nik, scan_ktp, kode_vendor, kode_direksi_perus, jabatan_direksi, status_permohonan, alasan_ditolak, user_verif, pin, tte, reset_token, token_expired_time, udcr, udch)
    VALUES (
        $kode_kategori_belanja,
        '$kode',
        '$nama',
        '$status_persetujuan'
    )";

    $dbNew->query($qRefPenandatangan);

    echo 'kategori_belanja: ' . $nama . PHP_EOL;
    */
}
