CREATE TYPE "status_permohonan" AS ENUM (
  'baru',
  'revisi',
  'proses',
  'terima',
  'tolak'
);

CREATE TABLE "ref_kelompok_penandatangan" (
  "kode_kelompok_penandatangan" int2 PRIMARY KEY,
  "kelompok_pemohon" varchar
);

CREATE TABLE "ref_penandatangan" (
  "kode_penandatangan" serial PRIMARY KEY,
  "kode_kelompok_penandatangan" int2,
  "nama" varchar,
  "email" varchar,
  "no_hp" varchar,
  "nip" varchar,
  "nik" varchar,
  "scan_ktp" varchar,
  "kode_vendor" int4,
  "kode_direksi_perus" int4,
  "jabatan_direksi" varchar,
  "status_permohonan" status_permohonan,
  "alasan_ditolak" text,
  "user_verif" varchar,
  "pin" varchar,
  "tte" varchar,
  "reset_token" varchar,
  "token_expired_time" timestamptz,
  "udcr" timestamptz,
  "udch" timestamptz
);

CREATE TABLE "trx_otp" (
  "kode_trx_otp" serial PRIMARY KEY,
  "kode_penandatangan" int4,
  "otp" int4,
  "expired_time" timestamptz,
  "udcr" timestamptz
);

CREATE TABLE "trx_tte" (
  "kode_tte" serial PRIMARY KEY,
  "kode_penandatangan" int4,
  "kode_trx_otp" int4,
  "jenis_signature" varchar,
  "tte" varchar,
  "barcode" varchar,
  "dok" varchar,
  "udcr" timestamptz
);

CREATE TABLE "log_pengajuan" (
  "kode_log_pengajuan" serial PRIMARY KEY,
  "table_log" varchar,
  "crud_log" varchar,
  "desc_log" text,
  "udcr" timestamptz,
  "udch" timestamptz
);

CREATE TABLE "log_pegawai" (
  "kode_log_pegawai" serial PRIMARY KEY,
  "table_log_pegawai" varchar,
  "crud_log_pegawai" varchar,
  "desc_log_pegawai" text,
  "udcr" timestamptz,
  "udch" timestamptz
);

CREATE TABLE "log_penyedia" (
  "kode_log_penyedia" serial PRIMARY KEY,
  "table_log_penyedia" varchar,
  "crud_log_penyedia" varchar,
  "dpt_log_penyedia" varchar,
  "tipe_log_penyedia" varchar,
  "desc_log_penyedia" text,
  "udcr" timestamptz,
  "udch" timestamptz
);

CREATE TABLE "log_history_pin" (
  "kode_log_history_pin" serial PRIMARY KEY,
  "kode_penandatangan" int4,
  "pin_lama" varchar(6) NOT NULL,
  "pin_baru" varchar(6) NOT NULL,
  "hash_pin_lama" varchar(255) NOT NULL,
  "hash_pin_baru" varchar(255) NOT NULL,
  "udcr" timestamptz(6)
);

COMMENT ON COLUMN "ref_penandatangan"."no_hp" IS 'Nomor Handphone yg tekonensi ke Whatsapp';

COMMENT ON COLUMN "ref_penandatangan"."nip" IS 'Nomor Induk Pegawai - diisi Kalau pemohonya pegawai internal';

COMMENT ON COLUMN "ref_penandatangan"."nik" IS 'Nomor KTP';

COMMENT ON COLUMN "ref_penandatangan"."kode_vendor" IS 'Diisi kalau kelompok pemohon adalah vendor';

COMMENT ON COLUMN "ref_penandatangan"."kode_direksi_perus" IS 'Diisi kalau kelompok pemohon adalah vendor';

COMMENT ON COLUMN "ref_penandatangan"."jabatan_direksi" IS 'Diisi kalau kelompok pemohon adalah vendor';

COMMENT ON COLUMN "ref_penandatangan"."user_verif" IS 'Email user yg mengapprove tte';

COMMENT ON COLUMN "ref_penandatangan"."tte" IS 'p12';

COMMENT ON COLUMN "ref_penandatangan"."token_expired_time" IS 'Waktu expired untuk reset token';
