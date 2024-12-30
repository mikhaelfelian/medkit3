<?php
class Migration_create_tbl_m_karyawans extends Migration {
    public function up() {
        $sql = "CREATE TABLE IF NOT EXISTS `" . $this->getTableName('m_karyawans') . "` (
            `id` INT(4) NOT NULL AUTO_INCREMENT,
            `id_user` INT(4) NULL DEFAULT '0',
            `id_poli` INT(4) NULL DEFAULT '0',
            `id_user_group` INT(4) NULL DEFAULT '0',
            `created_at` DATETIME NULL DEFAULT NULL,
            `updated_at` DATETIME NULL DEFAULT NULL,
            `kode` VARCHAR(10) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `nik` VARCHAR(100) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `sip` VARCHAR(100) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `str` VARCHAR(100) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `no_ijin` VARCHAR(100) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `tgl_lahir` DATE NULL DEFAULT NULL,
            `tmp_lahir` VARCHAR(100) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `nama_dpn` VARCHAR(100) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `nama` VARCHAR(100) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `nama_blk` VARCHAR(100) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `nama_pgl` VARCHAR(100) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `alamat` TEXT NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `alamat_domisili` TEXT NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `rt` VARCHAR(3) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `rw` VARCHAR(3) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `kelurahan` VARCHAR(50) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `kecamatan` VARCHAR(50) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `kota` VARCHAR(50) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `jns_klm` ENUM('L','P') NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `jabatan` VARCHAR(100) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `no_hp` VARCHAR(20) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `file_foto` VARCHAR(160) NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            `status` INT(11) NULL DEFAULT NULL COMMENT '1=perawat\r\n2=dokter\r\n3=kasir\r\n4=analis\r\n5=radiografer\r\n6=farmasi',
            `status_aps` ENUM('0','1') NULL DEFAULT NULL COLLATE 'latin1_general_ci',
            PRIMARY KEY (`id`) USING BTREE,
            INDEX `id_poli` (`id_poli`),
            INDEX `id_user` (`id_user`),
            INDEX `id_user_group` (`id_user_group`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE='latin1_general_ci' AUTO_INCREMENT=1
        COMMENT='Table untuk menyimpan data karyawan';";

        return $sql;
    }

    public function down() {
        return "DROP TABLE IF EXISTS `" . $this->getTableName('m_karyawans') . "`;";
    }

    public function getDescription() {
        return "Create table " . $this->getTableName('m_karyawans');
    }
} 