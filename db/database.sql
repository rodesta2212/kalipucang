/*
MySQL Backup
Source Server Version: 5.1.31
Source Database: ryan
Date: 26/01/2022 18:09:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
--  Table structure for `barang`
-- ----------------------------
DROP TABLE IF EXISTS `barang`;
CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL DEFAULT '0',
  `nama_barang` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `stok_barang` int(11) DEFAULT NULL,
  `tahun_input` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_barang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `kepala_keluarga`
-- ----------------------------
DROP TABLE IF EXISTS `kepala_keluarga`;
CREATE TABLE `kepala_keluarga` (
  `id_kk` int(11) NOT NULL DEFAULT '0',
  `id_user` int(11) DEFAULT NULL,
  `no_kk` bigint(20) DEFAULT NULL,
  `alamat` text,
  `no_telp` bigint(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_kk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `transaksi`
-- ----------------------------
DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL DEFAULT '0',
  `id_barang` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `jumlah_pinjam` int(11) DEFAULT NULL,
  `tgl_pinjam` date DEFAULT NULL,
  `jadwal_pinjam` date DEFAULT NULL,
  `jadwal_kembali` date DEFAULT NULL,
  `tgl_kembali` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `kerusakan` int(11) DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` int(11) NOT NULL DEFAULT '0',
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `jabatan` enum('ketua_rt','sekretaris','kepala_keluarga') DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Records 
-- ----------------------------
INSERT INTO `barang` VALUES ('1','Kursi Plastik','Perabotan','100','2015'), ('2','Sound System','Elektronik','1','2018');
INSERT INTO `kepala_keluarga` VALUES ('1','3','3402160312140005','bantul','8215433659','deni_samuri@gmail.com'), ('2','4','3402161811190003','Bantul','85642136597','rohmat_isnawan@gmail.com'), ('3','5','3402161208060013','Bantul','85425632156','joko@gmail.com');
INSERT INTO `transaksi` VALUES ('1','2','5','1','2022-01-26','2022-01-27','2022-01-27','2022-01-26','niakahan','Selesai','0','');
INSERT INTO `user` VALUES ('1','sekretaris','sekretaris','sekretaris','Sekretaris RT'), ('2','ketua','ketua','ketua_rt','Ketua RT'), ('3','deni','deni','kepala_keluarga','Deni Samuri'), ('4','rohmat','rohmat','kepala_keluarga','Rohmat Isnawan'), ('5','joko','joko','kepala_keluarga','Joko');
