CREATE DATABASE IF NOT EXISTS db_medkit3;

USE db_medkit3;

CREATE TABLE `tbl_m_pasien` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `kode` VARCHAR(20) NOT NULL COLLATE 'latin1_swedish_ci',
    `nik` VARCHAR(16) NOT NULL COLLATE 'latin1_swedish_ci',
    `nama` VARCHAR(100) NOT NULL COLLATE 'latin1_swedish_ci',
    `nama_pgl` VARCHAR(50) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
    `no_hp` VARCHAR(15) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
    `alamat` TEXT NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
    `alamat_domisili` TEXT NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
    `rt` VARCHAR(3) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
    `rw` VARCHAR(3) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
    `kelurahan` VARCHAR(50) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
    `kecamatan` VARCHAR(50) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
    `kota` VARCHAR(50) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
    `pekerjaan` VARCHAR(100) NULL DEFAULT NULL COLLATE 'latin1_swedish_ci',
    `created_at` TIMESTAMP NOT NULL DEFAULT current_timestamp(),
    `updated_at` TIMESTAMP NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE INDEX `kode` (`kode`) USING BTREE,
    UNIQUE INDEX `nik` (`nik`) USING BTREE
) COLLATE='latin1_swedish_ci' ENGINE=InnoDB; 