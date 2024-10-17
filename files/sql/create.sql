CREATE TYPE "status_permohonan" AS ENUM (
  'baru',
  'revisi',
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
  "pin" int4,
  "tte" varchar,
  "reset_token" varchar,
  "token_expired_time" timestamptz,
  "udcr" timestamptz,
  "udch" timestamptz
);

CREATE TABLE "trx_tte" (
  "kode_tte" serial PRIMARY KEY,
  "kode_penandatangan" int4,
  "tte" varchar,
  "barcode" varchar,
  "dok" varchar,
  "udcr" timestamptz
);

CREATE TABLE "trx_tte_otp" (
  "kode_tte_otp" serial PRIMARY KEY,
  "kode_tte" int4,
  "otp" int4,
  "expired_time" timestamptz,
  "udcr" timestamptz
);

CREATE TABLE "trx_log_aktifitas_user" (
  "kode_log_aktifitas_user" serial PRIMARY KEY,
  "email" text,
  "aktifitas" text,
  "udcr" timestamptz
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
