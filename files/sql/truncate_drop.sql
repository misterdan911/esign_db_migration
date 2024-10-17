TRUNCATE TABLE ref_kelompok_penandatangan RESTART IDENTITY CASCADE;
TRUNCATE TABLE ref_penandatangan RESTART IDENTITY CASCADE;
TRUNCATE TABLE trx_log_aktifitas_user RESTART IDENTITY CASCADE;
TRUNCATE TABLE trx_tte RESTART IDENTITY CASCADE;
TRUNCATE TABLE trx_tte_otp RESTART IDENTITY CASCADE;

DROP TABLE IF EXISTS ref_kelompok_penandatangan RESTART IDENTITY CASCADE;
DROP TABLE IF EXISTS ref_penandatangan RESTART IDENTITY CASCADE;
DROP TABLE IF EXISTS trx_log_aktifitas_user RESTART IDENTITY CASCADE;
DROP TABLE IF EXISTS trx_tte RESTART IDENTITY CASCADE;
DROP TABLE IF EXISTS trx_tte_otp RESTART IDENTITY CASCADE;

DROP TYPE IF EXISTS status_permohonan;

