-- Drop Foreign Key
ALTER TABLE ref_penandatangan DROP CONSTRAINT ref_penandatangan_kode_kelompok_penandatangan_fkey;
ALTER TABLE trx_tte DROP CONSTRAINT trx_tte_kode_penandatangan_fkey;
ALTER TABLE trx_otp DROP CONSTRAINT trx_otp_kode_penandatangan_fkey;
