ALTER TABLE "ref_penandatangan" ADD FOREIGN KEY ("kode_kelompok_penandatangan") REFERENCES "ref_kelompok_penandatangan" ("kode_kelompok_penandatangan");

ALTER TABLE "trx_tte" ADD FOREIGN KEY ("kode_penandatangan") REFERENCES "ref_penandatangan" ("kode_penandatangan");

ALTER TABLE "trx_otp" ADD FOREIGN KEY ("kode_penandatangan") REFERENCES "ref_penandatangan" ("kode_penandatangan");
