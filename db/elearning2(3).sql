-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2017 at 07:22 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elearning2`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ambil_data_profil` (IN `p_id` INT)  NO SQL
BEGIN

declare v_level int(11);

select level from user
where id = p_id into v_level;

IF v_level = 1 THEN
    select * from v_tabel_siswa where id_user = p_id;
ELSEIF v_level = 2 THEN
    select * from v_tabel_guru where id_user = p_id;
ELSEIF v_level = 4 THEN
	select * from v_tabel_admin where id_user = p_id;
END IF;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ambil_data_user` (IN `p_username` VARCHAR(255), IN `p_password` VARCHAR(255))  NO SQL
BEGIN

DECLARE v_id_user INT(11);
DECLARE v_nama VARCHAR(255);
DECLARE v_level INT(1);
DECLARE v_tabel VARCHAR(255);
DECLARE v_role VARCHAR(255);

SELECT id, level FROM user
WHERE username = p_username
AND password = SHA2(p_password,512) into v_id_user, v_level;

IF v_level = 1 THEN
SELECT f_login_ambil_data_nama_siswa(v_id_user) INTO v_nama;
SET v_role = "Siswa";
ELSEIF v_level = 2 THEN
SELECT f_login_ambil_data_nama_guru(v_id_user) INTO v_nama;
SET v_role = "Guru";
ELSEIF v_level = 4 THEN
SELECT f_login_ambil_data_nama_admin(v_id_user) INTO v_nama;
SET v_role = "Admin";
END IF;

SELECT u.id, u.username, (select v_nama) nama, u.level, (select v_role) role FROM user u
WHERE username = p_username
AND password = SHA2(p_password,512);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ganti_password` (IN `p_id` INT, IN `p_password` VARCHAR(255))  NO SQL
UPDATE user 
SET password = SHA2(p_password,512)
WHERE id = p_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hapus_admin` (IN `p_id_admin` INT)  NO SQL
BEGIN

DECLARE v_id_user INT(11);

SELECT id_user FROM admin
WHERE id = p_id_admin INTO v_id_user;

DELETE FROM admin
WHERE id = p_id_admin;

DELETE FROM user
WHERE id = v_id_user;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hapus_angkatan` (IN `p_id` INT)  NO SQL
DELETE FROM angkatan
WHERE id = p_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hapus_banksoal` (IN `p_id` INT)  NO SQL
BEGIN

DELETE FROM jawaban_banksoal
WHERE id_banksoal = p_id;

DELETE FROM banksoal
WHERE id = p_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hapus_detil_kelas` (IN `p_id` INT)  NO SQL
DELETE FROM detil_kelas
WHERE id = p_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hapus_guru` (IN `p_id_guru` INT)  NO SQL
BEGIN

DECLARE v_id_user INT(11);

SELECT id_user FROM guru
WHERE id = p_id_guru INTO v_id_user;

DELETE FROM guru
WHERE id = p_id_guru;

DELETE FROM user
WHERE id = v_id_user;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hapus_kelas` (IN `p_id` INT)  NO SQL
BEGIN

DELETE FROM detil_kelas
WHERE id_kelas = p_id;

DELETE FROM kelas
WHERE id = p_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hapus_materi` (IN `p_id` INT)  NO SQL
BEGIN

DELETE FROM mapel
WHERE id = p_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_hapus_siswa` (IN `p_id_siswa` INT)  NO SQL
BEGIN

DECLARE v_id_user INT(11);

SELECT id_user FROM siswa
WHERE id = p_id_siswa INTO v_id_user;

DELETE FROM siswa
WHERE id = p_id_siswa;

DELETE FROM user
WHERE id = v_id_user;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_kelas_lihat_siswa` (IN `p_id_kelas` INT)  NO SQL
SELECT dk.id id_detil_kelas,
k.id id_kelas,
s.nama,
s.nis
FROM detil_kelas dk, 
kelas k, 
siswa s
WHERE dk.id_kelas = k.id
AND dk.id_siswa = s.id
AND dk.id_kelas = p_id_kelas$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_kumpul_ujian` (IN `p_id_ujian` INT)  NO SQL
BEGIN

DECLARE v_nilai int(11);

SELECT sum(j.status)*10
FROM ujian_soal u, jawaban_banksoal j 
WHERE id_ujian = p_id_ujian 
AND u.id_jawaban = j.id
INTO v_nilai;

IF v_nilai is null
THEN SET v_nilai = 0;
END IF;

UPDATE ujian
SET nilai = v_nilai
WHERE id = p_id_ujian;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_lihat_kelas_tambah_siswa` (IN `p_id_kelas` INT, IN `p_id_angkatan` INT)  NO SQL
BEGIN

SELECT * FROM siswa
WHERE id not in (SELECT id_siswa FROM detil_kelas WHERE id_kelas = p_id_kelas)
AND id_angkatan = p_id_angkatan;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_pilih_jawaban` (IN `p_id_ujian_soal` INT, IN `p_id_jawaban` INT)  NO SQL
UPDATE ujian_soal
SET id_jawaban = p_id_jawaban
WHERE id = p_id_ujian_soal$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_siswa_mulai_ujian` (IN `p_id_kelas` INT, IN `p_id_siswa` INT)  NO SQL
BEGIN

DECLARE v_id_mapel int(11);
DECLARE v_id_ujian int(11);

INSERT INTO ujian
SET id_kelas = p_id_kelas,
id_siswa = p_id_siswa,
waktu_ujian = now();

SET v_id_ujian = LAST_INSERT_ID();

SELECT id_mapel FROM kelas
WHERE id = p_id_kelas
INTO v_id_mapel;

INSERT INTO ujian_soal (id_banksoal, id_ujian)
SELECT id, v_id_ujian
FROM banksoal bs
WHERE id_mapel = v_id_mapel
ORDER BY rand()
LIMIT 10;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tambah_admin` (IN `p_username` VARCHAR(255), IN `p_nama` VARCHAR(255))  NO SQL
BEGIN

DECLARE last_id INT(11);

INSERT INTO user
SET username = p_username,
password = SHA2(p_username,512),
level = 4;

SET last_id = LAST_INSERT_ID();

INSERT INTO admin
set id_user = last_id,
nama = p_nama;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tambah_angkatan` (IN `p_angkatan` VARCHAR(4))  NO SQL
INSERT INTO angkatan
SET angkatan = p_angkatan$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tambah_banksoal` (IN `p_id_mapel` INT, IN `p_soal` VARCHAR(255), IN `p_jawaban1` VARCHAR(255), IN `p_jawaban2` VARCHAR(255), IN `p_jawaban3` VARCHAR(255), IN `p_jawaban4` VARCHAR(255))  NO SQL
BEGIN

DECLARE v_last_id int(11);

INSERT INTO banksoal
SET id_mapel = p_id_mapel,
soal = p_soal;

SET v_last_id = last_insert_id();

CALL sp_tambah_jawaban_banksoal(v_last_id, p_jawaban1, 1);
CALL sp_tambah_jawaban_banksoal(v_last_id, p_jawaban2, 0);
CALL sp_tambah_jawaban_banksoal(v_last_id, p_jawaban3, 0);
CALL sp_tambah_jawaban_banksoal(v_last_id, p_jawaban4, 0);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tambah_detil_kelas` (IN `p_id_kelas` INT, IN `p_id_siswa` INT)  NO SQL
insert into detil_kelas
set id_siswa = p_id_siswa,
id_kelas = p_id_kelas$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tambah_guru` (IN `p_nip` VARCHAR(255), IN `p_nama` VARCHAR(255))  NO SQL
BEGIN

DECLARE last_id INT(11);

INSERT INTO user
SET username = p_nip,
password = SHA2(p_nip,512),
level = 2;

SET last_id = LAST_INSERT_ID();

INSERT INTO guru
set id_user = last_id,
nama = p_nama,
nip = p_nip;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tambah_jawaban_banksoal` (IN `p_id_banksoal` INT, IN `p_jawaban` VARCHAR(255), IN `p_status` INT)  NO SQL
INSERT INTO jawaban_banksoal
SET id_banksoal = p_id_banksoal,
jawaban = p_jawaban,
status = p_status$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tambah_kelas` (IN `p_id_angkatan` INT, IN `p_id_guru` INT, IN `p_id_mapel` INT, IN `p_kelas` VARCHAR(255))  NO SQL
INSERT INTO kelas
SET id_angkatan = p_id_angkatan,
id_guru = p_id_guru,
id_mapel = p_id_mapel,
kelas = p_kelas$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tambah_mapel` (IN `p_guru` INT, IN `p_semester` VARCHAR(255), IN `p_mapel` VARCHAR(255))  NO SQL
BEGIN

DECLARE last_id int(11);

INSERT INTO mapel
set id_guru = p_guru,
semester = p_semester,
mata_pelajaran = p_mapel;

SET last_id = last_insert_id();

SELECT last_id;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_tambah_siswa` (IN `p_nis` VARCHAR(255), IN `p_nama` VARCHAR(255), IN `p_id_angkatan` INT(11))  NO SQL
BEGIN

DECLARE last_id INT(11);

INSERT INTO user
SET username = p_nis,
password = SHA2(p_nis,512),
level = 1;

SET last_id = LAST_INSERT_ID();

INSERT INTO siswa
set id_user = last_id,
id_angkatan = p_id_angkatan,
nama = p_nama,
nis = p_nis;

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ubah_admin` (IN `p_nama` VARCHAR(255), IN `p_id` INT)  NO SQL
UPDATE admin
SET nama = p_nama
WHERE id = p_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ubah_angkatan` (IN `p_angkatan` VARCHAR(255), IN `p_id` INT)  NO SQL
UPDATE angkatan
SET angkatan=p_angkatan
WHERE id=p_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ubah_banksoal` (IN `p_id` INT, IN `p_soal` VARCHAR(255), IN `p_id_jawaban1` INT, IN `p_jawaban1` VARCHAR(255), IN `p_id_jawaban2` INT, IN `p_jawaban2` VARCHAR(255), IN `p_id_jawaban3` INT, IN `p_jawaban3` VARCHAR(255), IN `p_id_jawaban4` INT, IN `p_jawaban4` VARCHAR(255))  NO SQL
BEGIN

UPDATE banksoal
SET soal = p_soal
WHERE id = p_id;

 CALL sp_ubah_jawaban_banksoal(p_id_jawaban1, p_jawaban1);
 CALL sp_ubah_jawaban_banksoal(p_id_jawaban2, p_jawaban2);
 CALL sp_ubah_jawaban_banksoal(p_id_jawaban3, p_jawaban3);
 CALL sp_ubah_jawaban_banksoal(p_id_jawaban4, p_jawaban4);

END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ubah_guru` (IN `p_nama` VARCHAR(255), IN `p_id` INT)  NO SQL
UPDATE guru
SET nama = p_nama
WHERE id = p_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ubah_jawaban_banksoal` (IN `p_id` INT, IN `p_jawaban` VARCHAR(255))  NO SQL
UPDATE jawaban_banksoal
SET jawaban = p_jawaban
WHERE id = p_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ubah_siswa` (IN `p_nama` VARCHAR(255), IN `p_id_angkatan` INT, IN `p_id` INT)  NO SQL
UPDATE siswa
SET nama = p_nama,
id_angkatan = p_id_angkatan
WHERE id = p_id$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ubah_status_kelas` (IN `p_id` INT)  NO SQL
BEGIN

DECLARE v_status_selesai int(11);
DECLARE v_status_selesai_next int(11);

SELECT selesai
FROM kelas
WHERE id = p_id
INTO v_status_selesai;

IF v_status_selesai = 1
THEN SET v_status_selesai_next = 0;
ELSE SET v_status_selesai_next = 1;
END IF;

UPDATE kelas
SET selesai = v_status_selesai_next
WHERE id = p_id;

END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `f_ambil_data_angkatan_dari_kelas` (`p_id_kelas` INT) RETURNS INT(11) NO SQL
BEGIN

DECLARE v_id_angkatan int(11);

SELECT id_angkatan
FROM kelas
WHERE id = p_id_kelas
INTO v_id_angkatan;

return v_id_angkatan;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_ambil_id_admin_dari_id_user` (`p_id_user` INT) RETURNS INT(11) NO SQL
BEGIN

DECLARE v_id_admin int(11);

SELECT a.id
FROM admin a, user u
WHERE a.id_user=u.id
AND u.id=p_id_user into v_id_admin;

return v_id_admin;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_ambil_id_angkatan_dari_angkatan` (`p_angkatan` VARCHAR(255)) RETURNS INT(11) NO SQL
BEGIN

DECLARE v_id int(11);

SELECT id
FROM angkatan
WHERE angkatan = p_angkatan
INTO v_id;

RETURN v_id;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_ambil_id_guru_dari_id_user` (`p_id_user` INT) RETURNS INT(11) NO SQL
BEGIN

DECLARE v_id_guru int(11);

SELECT g.id
FROM guru g, user u
WHERE g.id_user=u.id
AND u.id=p_id_user into v_id_guru;

return v_id_guru;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_ambil_id_kelas_dari_id_ujian` (`p_id_ujian` INT) RETURNS INT(11) NO SQL
BEGIN

DECLARE v_id_kelas int(11);

SELECT id_kelas
FROM ujian
WHERE id = p_id_ujian
INTO v_id_kelas;

RETURN v_id_kelas;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_ambil_id_mapel_dari_banksoal` (`p_id` INT) RETURNS INT(11) NO SQL
BEGIN

DECLARE v_id_mapel int(11);

SELECT id_mapel
FROM banksoal
WHERE id = p_id
INTO v_id_mapel;

RETURN v_id_mapel;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_ambil_id_siswa_dari_id_user` (`p_id_user` INT) RETURNS INT(11) NO SQL
BEGIN

DECLARE v_id_siswa int(11);

SELECT s.id
FROM siswa s, user u
WHERE s.id_user=u.id
AND u.id=p_id_user into v_id_siswa;

return v_id_siswa;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_ambil_jawaban` (`p_id_ujian_soal` INT) RETURNS INT(11) NO SQL
BEGIN

DECLARE v_id_jawaban int(11);

SELECT id_jawaban
FROM ujian_soal
WHERE id = p_id_ujian_soal
INTO v_id_jawaban;

RETURN v_id_jawaban;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_cek_jumlah_siswa_dalam_kelas` (`p_id_kelas` INT) RETURNS INT(11) NO SQL
BEGIN

DECLARE v_jumlah_siswa int(11);

SELECT count(*)
FROM detil_kelas 
WHERE id_kelas = p_id_Kelas
INTO v_jumlah_siswa;

RETURN v_jumlah_siswa;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_cek_jumlah_ujian_siswa` (`p_id_kelas` INT, `p_id_siswa` INT) RETURNS INT(11) NO SQL
BEGIN

DECLARE v_total int(11);

SELECT COUNT(*) FROM ujian
WHERE id_kelas = p_id_kelas
AND id_siswa = p_id_siswa
INTO v_total;

RETURN v_total;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_cek_login` (`p_username` VARCHAR(255), `p_password` VARCHAR(255)) RETURNS INT(1) NO SQL
BEGIN

DECLARE hasil INT(1);

SELECT COUNT(*) FROM user
WHERE username = p_username
AND password = SHA2(p_password,512) into hasil;

return hasil;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_cek_ujian_aktif` (`p_id_kelas` INT, `p_id_siswa` INT) RETURNS INT(11) NO SQL
BEGIN

DECLARE v_id_ujian int(11);

SELECT id_ujian FROM `v_tabel_ujian`
WHERE sekarang >= waktu_ujian
AND deadline >= sekarang
AND id_kelas = p_id_kelas
AND id_siswa = p_id_siswa
AND nilai IS null
LIMIT 1
INTO v_id_ujian;

RETURN v_id_ujian;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_lihat_jumlah_jawaban` (`p_id_banksoal` INT) RETURNS INT(11) NO SQL
BEGIN

DECLARE jumlah_jawaban int(11);

SELECT count(*)
FROM jawaban_banksoal
WHERE id_banksoal = p_id_banksoal into jumlah_jawaban;

RETURN jumlah_jawaban;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_login_ambil_data_nama_admin` (`p_id_user` INT) RETURNS VARCHAR(255) CHARSET latin1 NO SQL
BEGIN

DECLARE v_nama VARCHAR(255);

SELECT nama FROM admin
WHERE id_user = p_id_user into v_nama;

return v_nama;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_login_ambil_data_nama_guru` (`p_id_user` INT) RETURNS VARCHAR(255) CHARSET latin1 NO SQL
BEGIN

DECLARE v_nama VARCHAR(255);

SELECT nama FROM guru
WHERE id_user = p_id_user into v_nama;

return v_nama;

END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `f_login_ambil_data_nama_siswa` (`p_id_user` INT) RETURNS VARCHAR(255) CHARSET latin1 NO SQL
BEGIN

DECLARE v_nama VARCHAR(255);

SELECT nama FROM siswa
WHERE id_user = p_id_user into v_nama;

return v_nama;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `id_user`, `nama`) VALUES
(1, 20, 'Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `angkatan`
--

CREATE TABLE `angkatan` (
  `id` int(11) NOT NULL,
  `angkatan` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `angkatan`
--

INSERT INTO `angkatan` (`id`, `angkatan`) VALUES
(8, '2015'),
(9, '2016'),
(10, '2017');

-- --------------------------------------------------------

--
-- Table structure for table `banksoal`
--

CREATE TABLE `banksoal` (
  `id` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `soal` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banksoal`
--

INSERT INTO `banksoal` (`id`, `id_mapel`, `soal`) VALUES
(91, 18, 'Berikut ini yang bukan merupakan sub proses produksi multimedia adalah'),
(92, 18, 'Mempersiapkan segala sesuatu agar proses produksi dapat berjalan sesuai dengan konsep merupakan tujuan dari tahapan ?'),
(93, 18, 'Yang tidak termasuk dalam tahapan perencanaan produksi adalah'),
(94, 18, 'Tahapan yang paling utama dalam proses penuangan ide proposal adalah ?'),
(95, 18, 'menentukan lingkup proyek merupakan bagian dari ?'),
(96, 18, 'berikut ini yang bukan merupakan bagian dari pengujian adalah ?'),
(97, 18, 'berikut ini salah satu bagian dari story board adalah ?'),
(98, 18, 'doom type game, nonprofit website. Merupakan bagian dari ?'),
(100, 18, 'Membuat Storyboard adalah salah satu proses dalam produksi multimedia, proses tersebut masuk kedalam'),
(101, 18, 'Salah satu software pengolah gambar vektor adalah'),
(102, 18, 'Proses awal dari proses produksi produk multimedia dinamakan'),
(103, 18, 'Rincian perkiraan jumlah total pemasukan dan pengeluaran dipaparkan dalam proposal pada bagian'),
(104, 18, 'Merupakan coretan gambar/sketsa seperti gambar komik yang menggambarkan kejadian dalam film, disebut'),
(105, 18, 'Proses akhir dari proses produksi produk multimedia dinamakan'),
(106, 17, 'Pada awalnya sejarah istilah multimedia berasal dari'),
(107, 17, 'Secara etimologis kata multimedia berasal dari kata?multi?dan?media, kata?media?mempunyai arti'),
(108, 17, ' multimedia terdiri dari beberapa unsur dibawah ini, kecuali'),
(109, 17, 'multimedia terbagi menjadi dua kategori, yaitu'),
(110, 17, 'Yang bukan merupakan pemanfaatan multimedia dalam bidang industry kreatif adalah'),
(111, 17, 'Dalam bidang pendidikan dan penelitian, aplikasi multimedia dimanfaatkan pada bidang-bidang di bawah ini kecuali'),
(112, 17, 'yang tidak termasuk dalam multimedia communication adalah'),
(113, 17, 'yang?termasuk dalam multimedia content production, kecuali'),
(114, 17, 'Pemanfaatan multimedia sebagai media pengajaran dengan memproduksi modul-modul presentasi CD interaktif merupakan salah satu pemanfaatan multimedia dalam bidang'),
(115, 17, 'Salah satu Aplikasi Multimedia adalah'),
(116, 17, 'contoh komunikasi multimedia adalah'),
(117, 17, 'Pengiriman dan penerimaan pesan atau berita antara dua orang atau lebih sehingga pesan tersebut dapat dipahami disebut '),
(118, 17, 'Untuk mengabadikan karya multimedia konten harus disimpan dengan media tertentu agar karya tersebut bisa awet dan tahan lama. Media penyimpanan tersebut adalah, kecuali'),
(119, 17, 'Setiap karya multimedia yang disimpan dalam hardisk komputer akan menempati space yang tersedia. Makin besar sebuah file maka akan semakin besar space yang dibutuhkan. Satuan dari beban file tersebut disebut dengan istilah'),
(120, 17, 'Aplikasi untuk editing video adalah'),
(121, 16, 'Windows XP SP3 merupakan salah satu nama produk dari '),
(122, 16, 'Memori komputer berguna untuk'),
(123, 16, 'Alat-alat apa saja yang tidak dibutuhkan dalam perakitan komputer'),
(124, 16, 'Komponen hardware komputer yang dapat dipasang di motherboard pada waktu mother board belum dipasang di cashing adalah'),
(125, 16, 'Perangkat komputer yang dijadikan media atau tempat memasang processor, memory  dan perangkat keras yang lain ialah'),
(126, 16, 'Berapa pin yang terdapat pada kabel data hard disk/CD-ROM?'),
(127, 16, 'Peralatan apa saja yang kita perlukan pada saat kita merakit sebuah PC?'),
(128, 16, 'Jenis casing yang dapat mati sendiri pada saat di shutdown adalah'),
(129, 16, 'Berapa kali bunyi beep apabila komputer mengalami kerusakan pada cache memory?'),
(130, 16, 'Benda apakah yang ikut bergerak pada saat kita menggerakkanmouse?sehingga?pointer?dapat ikut bergerak'),
(131, 16, 'Kabel warna apakah yang harus diposisikan ditengah saat kita memasang kabel power dari?power supply?ke?motherboard?'),
(132, 16, 'Apa yang harus kita perhatikan pada saat measang sebuah RAM adalah'),
(133, 16, '?Upgrade komponen apa yang akan meningkatkan kinerja seluruh komponen?PC'),
(134, 16, 'Peralatan yang berwujud fisik atau peralatan komputer yang dapat dilihat dengan menggunakan indra mata disebut'),
(135, 16, 'Peralatan yang berwujud fisik atau peralatan komputer yang dapat dilihat dengan menggunakan indra mata disebut'),
(196, 14, 'Peralatan multimedia pada umumnya sangat sensitive terhadap kondisi berikut, kecuali'),
(197, 14, 'Di bawah ini adalah contoh peralatan multimedia, kecuali'),
(198, 14, 'Peralatan yang sering digunakan untuk perawatan peralatan multimedia antara lain'),
(199, 14, 'Cara sederhana untuk membersihkan kotoran?debu dapat digunakan peralatan dan bahan'),
(200, 14, 'Bagian yang paling sensitive dari sebuah kamera adalah'),
(201, 14, 'Untuk membersihkan debu dan sarang serangga sebaiknya menggunakan'),
(202, 14, 'Untuk medapatkan tegangan jala-jala listrik yang stabil, maka kita perlu menggunakan'),
(203, 14, 'Alat yang digunakan sebagai pengaman CPU terhadap lonjakan tegangan jala-jala listrik maupun listrik yang tiba-tiba padam adalah'),
(204, 14, 'Kotak tempat mesin komputer (motherboard dan pendukungnya, power supply, disk drive, hardisk, CD ROM, dll) disebut'),
(205, 14, 'Manakah yang tidak termasuk dalam perawatan mainboard computer'),
(206, 14, 'Perawatan printer yang umumnya dilakukan secara rutin adalah?'),
(207, 14, 'Mengapa peralatan elektronik dianjurkan tidak terkena air laut'),
(208, 14, 'Penyebab ponsel yang paling rawan mengalami kerusakan berat adalah karena, kecuali'),
(209, 14, 'Jangan tinggalkan kaset didalam camcorder anda saat tidak digunakan. Karena'),
(210, 14, 'Tujuan dari defrag flash disk adalah');

-- --------------------------------------------------------

--
-- Table structure for table `detil_kelas`
--

CREATE TABLE `detil_kelas` (
  `id` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detil_kelas`
--

INSERT INTO `detil_kelas` (`id`, `id_kelas`, `id_siswa`) VALUES
(34, 12, 16),
(35, 12, 17),
(36, 12, 18),
(37, 12, 19),
(38, 12, 20),
(39, 11, 21),
(40, 11, 22),
(41, 11, 23),
(42, 11, 24),
(43, 11, 25),
(54, 13, 16),
(55, 13, 17),
(56, 13, 18),
(57, 13, 19),
(58, 13, 20),
(59, 14, 21),
(60, 14, 22),
(61, 14, 23),
(62, 14, 24),
(63, 14, 25),
(64, 15, 16),
(65, 15, 17),
(66, 15, 18),
(67, 15, 19),
(68, 15, 20),
(69, 16, 21),
(70, 16, 22),
(71, 16, 23),
(72, 16, 24),
(73, 16, 25),
(74, 17, 16),
(75, 17, 17),
(76, 17, 18),
(77, 17, 19),
(78, 17, 20),
(79, 18, 21),
(80, 18, 22),
(81, 18, 23),
(82, 18, 24),
(83, 18, 25),
(84, 19, 16),
(85, 19, 17),
(86, 19, 18),
(87, 19, 19);

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `nip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `id_user`, `nama`, `nip`) VALUES
(2, 22, 'Cinta', '14753001'),
(5, 57, 'Kasih', '14753002'),
(6, 58, 'Sayang', '14753003'),
(7, 59, 'Mawaddah', '14753004'),
(8, 60, 'Warahmah', '14753005');

-- --------------------------------------------------------

--
-- Table structure for table `jawaban_banksoal`
--

CREATE TABLE `jawaban_banksoal` (
  `id` int(11) NOT NULL,
  `id_banksoal` int(11) NOT NULL,
  `jawaban` varchar(255) NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jawaban_banksoal`
--

INSERT INTO `jawaban_banksoal` (`id`, `id_banksoal`, `jawaban`, `status`) VALUES
(357, 91, 'Planing-Production', 1),
(358, 91, 'Pre-Production', 0),
(359, 91, 'Production', 0),
(360, 91, 'Post-Production', 0),
(361, 92, 'Pre-Production', 1),
(362, 92, 'Planing-Production', 0),
(363, 92, 'post production', 0),
(364, 92, 'Production', 0),
(365, 93, 'dokumentasi', 1),
(366, 93, 'story board', 0),
(367, 93, 'budgeting', 0),
(368, 93, 'scheduling', 0),
(369, 94, 'title goals', 1),
(370, 94, 'audience', 0),
(371, 94, 'title genre', 0),
(372, 94, 'marketing', 0),
(373, 95, 'storyboard', 1),
(374, 95, 'penganggaran', 0),
(375, 95, 'penjadwalan', 0),
(376, 95, 'aset manajemen', 0),
(377, 96, 'Pengujian Perangkat lunak', 1),
(378, 96, 'pengujian user', 0),
(379, 96, 'pengujian konten', 0),
(380, 96, 'pengujian fungsional', 0),
(381, 97, 'menentukan lingkup proyek', 1),
(382, 97, 'konten ahli', 0),
(383, 97, 'konten produksi', 0),
(384, 97, 'konten akuisisi', 0),
(385, 98, 'title genre', 1),
(386, 98, 'marketing requirements', 0),
(387, 98, 'schedule ', 0),
(388, 98, 'budget parameters', 0),
(393, 100, 'Pre Production ', 1),
(394, 100, 'Post Production', 0),
(395, 100, 'Production', 0),
(396, 100, 'Perancangan', 0),
(397, 101, 'adobe ilustrator', 1),
(398, 101, 'Adobe Dreamwaver', 0),
(399, 101, 'adobe photoshop', 0),
(400, 101, 'Adobe Premiere', 0),
(401, 102, 'Pre-Production', 1),
(402, 102, 'Distribution', 0),
(403, 102, 'Post-production', 0),
(404, 102, 'Production', 0),
(405, 103, 'Anggaran Biaya', 1),
(406, 103, 'Pendahuluan', 0),
(407, 103, 'Latar Belakang Masalah', 0),
(408, 103, 'Skenario', 0),
(409, 104, 'storyboard', 1),
(410, 104, 'Skenario', 0),
(411, 104, 'Proposal', 0),
(412, 104, 'Concept Definition', 0),
(413, 105, 'Post-Production', 1),
(414, 105, 'Pre-Production', 0),
(415, 105, 'Production', 0),
(416, 105, 'Pasca Production', 0),
(417, 106, 'Dunia Theater', 1),
(418, 106, 'Komputer', 0),
(419, 106, 'Dunia Film', 0),
(420, 106, 'Video', 0),
(421, 107, 'sesuatu yang dipakai untuk menyampaikan atau membawa sesuatu', 1),
(422, 107, 'Banyak', 0),
(423, 107, 'Bermacam-macam', 0),
(424, 107, 'Menyampaikan', 0),
(425, 108, 'hardware', 1),
(426, 108, 'suara', 0),
(427, 108, 'animasi', 0),
(428, 108, 'video', 0),
(429, 109, 'multimedia content production dan multimedia communication', 1),
(430, 109, 'multimedia animasi dan multimedia kreatif', 0),
(431, 109, 'multimedia informasi dan multimedia komunikasi', 0),
(432, 109, 'mutimedia produksi', 0),
(433, 110, 'Pembuatan modeling dan simulasi', 1),
(434, 110, 'pembuatan iklan', 0),
(435, 110, 'pertunjukan seni', 0),
(436, 110, 'pembuatan film animasi', 0),
(437, 111, 'Pembuatan gambar tampak', 1),
(438, 111, 'Pembuatan jurnal multimedia', 0),
(439, 111, '?Pembuatan modeling dan simulasi', 0),
(440, 111, 'Pembuatan ebook materi pembelajaran', 0),
(441, 112, 'animasi', 1),
(442, 112, 'televisi', 0),
(443, 112, 'radio ', 0),
(444, 112, 'cetak', 0),
(445, 113, 'cetak', 1),
(446, 113, 'animasi', 0),
(447, 113, 'schedule', 0),
(448, 113, 'budget parameters', 0),
(449, 114, 'pendidikan & penelitian ilmiah', 1),
(450, 114, 'bidang teknik', 0),
(451, 114, 'bidang kesehatan', 0),
(452, 114, 'bidang promosi', 0),
(453, 115, 'Adobe Photoshop', 1),
(454, 115, 'windows xp', 0),
(455, 115, 'ms office', 0),
(456, 115, 'winRar', 0),
(457, 116, 'film', 1),
(458, 116, 'website', 0),
(459, 116, 'banner', 0),
(460, 116, 'cd interfaktif', 0),
(461, 117, 'komunikasi', 1),
(462, 117, 'persepsi', 0),
(463, 117, 'interaksi', 0),
(464, 117, 'sosialisasi', 0),
(465, 118, 'video', 1),
(466, 118, 'hardisk', 0),
(467, 118, 'cd drive', 0),
(468, 118, 'flashdisk', 0),
(469, 119, 'bite', 1),
(470, 119, 'pixel', 0),
(471, 119, 'meter', 0),
(472, 119, 'folder', 0),
(473, 120, 'adobe premiere', 1),
(474, 120, 'adobe dreamweaver', 0),
(475, 120, 'adobe photoshop', 0),
(476, 120, 'adobe ilustrator', 0),
(477, 121, 'microsoft', 1),
(478, 121, 'ubuntu', 0),
(479, 121, 'linux', 0),
(480, 121, 'machintos', 0),
(481, 122, 'semua benar', 1),
(482, 122, 'penyimpanan data sementara', 0),
(483, 122, 'melakukan setup OS', 0),
(484, 122, 'Random access memory', 0),
(485, 123, 'gergaji', 1),
(486, 123, 'obeng', 0),
(487, 123, 'sandal karet', 0),
(488, 123, 'tespen', 0),
(489, 124, 'sound card', 1),
(490, 124, 'dvd rom drive', 0),
(491, 124, 'floppy disk', 0),
(492, 124, 'cpu', 0),
(493, 125, 'motherboard', 1),
(494, 125, 'hardisk', 0),
(495, 125, 'casing', 0),
(496, 125, 'power supply', 0),
(497, 126, '40 pin', 1),
(498, 126, '38 pin', 0),
(499, 126, '36 pin', 0),
(500, 126, '42 pin', 0),
(501, 127, 'obeng kembang & obeng min', 1),
(502, 127, 'tang', 0),
(503, 127, 'kunci', 0),
(504, 127, 'tang dan obeng kembang', 0),
(505, 128, 'AT', 1),
(506, 128, 'ATX', 0),
(507, 128, 'Desktop', 0),
(508, 128, 'tower', 0),
(509, 129, '11 kali ', 1),
(510, 129, '10 kali', 0),
(511, 129, '9 kali ', 0),
(512, 129, '6 kali', 0),
(513, 130, 'resistor elektronik', 1),
(514, 130, 'bola', 0),
(515, 130, 'gundu', 0),
(516, 130, 'kaki mouse', 0),
(517, 131, 'hitam', 1),
(518, 131, 'merah', 0),
(519, 131, 'kuning', 0),
(520, 131, 'putih', 0),
(521, 132, 'lubang pada kaki RAM', 1),
(522, 132, 'Besar Memori RAM', 0),
(523, 132, 'slot PCI', 0),
(524, 132, 'Pengunci RAM', 0),
(525, 133, 'Procecor', 1),
(526, 133, 'RAM', 0),
(527, 133, 'Hardisk', 0),
(528, 133, 'VGA Card', 0),
(529, 134, 'Software', 1),
(530, 134, 'hardware', 0),
(531, 134, 'brainware', 0),
(532, 134, 'perangkat aplikasi', 0),
(533, 135, 'internal storage', 1),
(534, 135, 'external storage', 0),
(535, 135, 'general storage', 0),
(536, 135, 'free storage', 0),
(777, 196, 'Kondisi kering', 1),
(778, 196, 'kondisi basah', 0),
(779, 196, 'kondisi panas', 0),
(780, 196, 'kondisi lembab', 0),
(781, 197, 'baliho', 1),
(782, 197, 'kamera digital', 0),
(783, 197, 'komputer', 0),
(784, 197, 'televisi', 0),
(785, 198, 'tisu & vacum cleaner', 1),
(786, 198, 'tang & drei', 0),
(787, 198, 'cd cleaner', 0),
(788, 198, 'disk cleaner', 0),
(789, 199, 'cleaner & disk cleaner', 1),
(790, 199, 'koran & tisu', 0),
(791, 199, 'vacum cleaner', 0),
(792, 199, 'kain kering', 0),
(793, 200, 'lensa', 1),
(794, 200, 'box', 0),
(795, 200, 'hand grip', 0),
(796, 200, 'zoom ring', 0),
(797, 201, 'kuas', 1),
(798, 201, 'kain kering', 0),
(799, 201, 'disk cleaner', 0),
(800, 201, 'vacum cleaner', 0),
(801, 202, 'stabilizer', 1),
(802, 202, 'listrik diesel', 0),
(803, 202, 'generator set', 0),
(804, 202, 'power supply', 0),
(805, 203, 'UPS', 1),
(806, 203, 'power supply', 0),
(807, 203, 'adaptor', 0),
(808, 203, 'generator', 0),
(809, 204, 'casing', 1),
(810, 204, 'box', 0),
(811, 204, 'toolbox', 0),
(812, 204, 'motherboard', 0),
(813, 205, 'menambahkan RAM', 1),
(814, 205, 'menggunakan UPS', 0),
(815, 205, 'melancarkan ventilasi', 0),
(816, 205, 'hindari suhu lembab', 0),
(817, 206, 'membersihkan debu', 1),
(818, 206, 'membersihkan toner', 0),
(819, 206, 'mengisi tinta', 0),
(820, 206, 'mengusahakan tinta menyentuh CHIP', 0),
(821, 207, 'menimbulkan korosi', 1),
(822, 207, 'menyebabkan virus', 0),
(823, 207, 'menyebabkan flex', 0),
(824, 207, 'menimbulkan goresan', 0),
(825, 208, 'masuknya virus ke memori', 1),
(826, 208, 'jatuh dari atas lantai', 0),
(827, 208, 'terendam air', 0),
(828, 208, 'terlalu lama memasang charger', 0),
(829, 209, 'menyebabkan gesekan dan hal ini bisa mengakibatkan masalah  merekam', 1),
(830, 209, 'kaset tidak berfungsi', 0),
(831, 209, 'kaset mudah dipakai kembali', 0),
(832, 209, 'kaset mengakibatkan kehausan', 0),
(833, 210, 'agar kinerja flashdisk kita lebih optimal', 1),
(834, 210, 'agar mudah digunakan kembali', 0),
(835, 210, 'agar terhindar virus', 0),
(836, 210, 'agar struktur data bisa diatur', 0);

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id` int(11) NOT NULL,
  `id_angkatan` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `id_mapel` int(11) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `selesai` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id`, `id_angkatan`, `id_guru`, `id_mapel`, `kelas`, `selesai`) VALUES
(11, 8, 2, 18, 'Alir TKJ 1 A', 0),
(12, 8, 2, 18, 'Alir TKJ 1 B', 0),
(13, 8, 2, 17, 'Etimologi Multimedia 1 A', 0),
(14, 8, 2, 18, 'Etimologi Multimedia 1 B', 0),
(15, 8, 5, 16, 'PPC 1A', 0),
(16, 8, 5, 16, 'PPC 1B', 0),
(17, 8, 6, 14, 'PPM 1A', 0),
(18, 8, 6, 14, 'PPM 1B', 0),
(19, 8, 6, 14, 'PPM test', 0);

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `semester` varchar(255) NOT NULL,
  `mata_pelajaran` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`id`, `id_guru`, `semester`, `mata_pelajaran`) VALUES
(14, 6, '2', 'Perawatan Peralatan Multimedia'),
(16, 5, '1', 'Perakitan Personal Komputer'),
(17, 2, '1', 'Etimologi Multimedia'),
(18, 2, '1', 'Alir Proses Produksi Multimedia');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_angkatan` int(11) NOT NULL,
  `nis` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `id_user`, `id_angkatan`, `nis`, `nama`) VALUES
(16, 27, 8, '15753001', 'Ade Irma Rilyani'),
(17, 28, 8, '15753002', 'Adrian Reza Syahputra'),
(18, 29, 8, '15753003', 'Agung Sapto Margono Dh'),
(19, 30, 8, '15753004', 'Ahmad Fatoni Sapta Ananta'),
(20, 31, 8, '15753005', 'Aida Agustin'),
(21, 32, 8, '15753006', 'Aman Natur Rozak'),
(22, 33, 8, '15753007', 'Andreas Hari Herlambang'),
(23, 34, 8, '15753008', 'Anggia Hesti Febriani'),
(24, 35, 8, '15753009', 'Anita Safitri'),
(25, 36, 8, '15753010', 'Anvita Riliani'),
(26, 37, 9, '15753011', 'Ari Suryono'),
(27, 38, 9, '15753012', 'Arta Windy Pratama'),
(28, 39, 9, '15753013', 'Belinda Yena Putri'),
(29, 40, 9, '15753014', 'Bintang Ali Falaqis'),
(30, 41, 9, '15753015', 'Chandra Mahardika Anjasmara'),
(31, 42, 9, '15753016', 'Cristianson Sihombing'),
(32, 43, 9, '15753017', 'Deby Delia Anneke Putri'),
(33, 44, 9, '15753018', 'Denny Adam'),
(34, 45, 9, '15753019', 'Dewa Gede Sugiada'),
(35, 46, 9, '15753020', 'Diah Santikawati'),
(36, 47, 10, '15753021', 'Diah Septia Ningrum'),
(37, 48, 10, '15753022', 'Dian Asmaul Husna'),
(38, 49, 10, '15753023', 'Diana Sapta Mardiah'),
(39, 50, 10, '15753024', 'Edi Murwanto'),
(40, 51, 10, '15753025', 'Egi Prasetya Wijaya'),
(41, 52, 10, '15753026', 'Egipson Andesta Walco'),
(42, 53, 10, '15753027', 'Gilda Febriandini'),
(43, 54, 10, '15753028', 'Hadi Saputra'),
(44, 55, 10, '15753029', 'Ima Mairestina'),
(45, 56, 10, '15753030', 'Jantika Ayu Ramadhani');

-- --------------------------------------------------------

--
-- Table structure for table `ujian`
--

CREATE TABLE `ujian` (
  `id` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `waktu_ujian` datetime NOT NULL,
  `nilai` float(11,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ujian`
--

INSERT INTO `ujian` (`id`, `id_kelas`, `id_siswa`, `waktu_ujian`, `nilai`) VALUES
(14, 15, 18, '2017-12-07 10:03:35', 0.00),
(15, 17, 18, '2017-12-07 10:22:16', 0.00),
(16, 12, 18, '2017-12-08 08:56:56', 10.00),
(17, 17, 16, '2017-12-09 13:29:10', 0.00),
(18, 19, 18, '2017-12-11 10:41:13', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `ujian_soal`
--

CREATE TABLE `ujian_soal` (
  `id` int(11) NOT NULL,
  `id_ujian` int(11) NOT NULL,
  `id_banksoal` int(11) NOT NULL,
  `id_jawaban` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ujian_soal`
--

INSERT INTO `ujian_soal` (`id`, `id_ujian`, `id_banksoal`, `id_jawaban`) VALUES
(156, 14, 126, NULL),
(157, 14, 132, NULL),
(158, 14, 127, NULL),
(159, 14, 130, NULL),
(160, 14, 129, NULL),
(161, 14, 128, NULL),
(162, 14, 134, NULL),
(163, 14, 122, NULL),
(164, 14, 123, NULL),
(165, 14, 133, NULL),
(171, 15, 205, 815),
(172, 15, 209, NULL),
(173, 15, 200, NULL),
(174, 15, 208, NULL),
(175, 15, 204, NULL),
(176, 15, 202, NULL),
(177, 15, 207, NULL),
(178, 15, 198, NULL),
(179, 15, 197, NULL),
(180, 15, 201, NULL),
(181, 16, 94, 369),
(182, 16, 101, NULL),
(183, 16, 91, NULL),
(184, 16, 103, NULL),
(185, 16, 104, NULL),
(186, 16, 100, NULL),
(187, 16, 97, NULL),
(188, 16, 105, 415),
(189, 16, 95, NULL),
(190, 16, 98, NULL),
(191, 17, 201, 800),
(192, 17, 200, 795),
(193, 17, 196, NULL),
(194, 17, 208, NULL),
(195, 17, 203, 808),
(196, 17, 207, NULL),
(197, 17, 206, NULL),
(198, 17, 197, NULL),
(199, 17, 209, NULL),
(200, 17, 199, NULL),
(201, 18, 207, 824),
(202, 18, 201, NULL),
(203, 18, 208, NULL),
(204, 18, 203, NULL),
(205, 18, 200, NULL),
(206, 18, 210, NULL),
(207, 18, 205, NULL),
(208, 18, 199, NULL),
(209, 18, 202, NULL),
(210, 18, 209, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `level`) VALUES
(20, 'admin', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', '4'),
(22, '14753001', 'b04752a39538d5e2834ced695ec93bb8328698ff2da917434f4cb2b385ea4795891a396950ee95f0a180a7026e00f9e720f17e3b694674a0df5860e5db034fec', '2'),
(27, '15753001', 'd54db09bbc69dcb76b4fd44cd5477b59ca9c3ea170fa8b355cbb10f13de32b729681696818a8bec093411dc14b4bce01b3c0a49def1cbe5a1ea45270aeaa9bf3', '1'),
(28, '15753002', '55cfe19619b4b9a6c78c82be101b6f01b706b192abaa3d93a153daf261114a4a8b431747f2eb20c10ff1683c572c3be0a5773c92a8950de965d01277c9a1c7e8', '1'),
(29, '15753003', 'b15f598876bb555c5fd04a585d2206b22714bb313d5d41497db8e9f91c2231078d69c09be9291ae3c01c7eea798cd69d45b8e7fd76086b0a89cfbc8cdcef8059', '1'),
(30, '15753004', '9a2d4b74abe822cd437b60790383a65ecc6eb44bd97ae0785e22f0c671fc523070bdc841f02d9d4a77a062b577b67bfafd828ae79483cc5cfacc1c124da86721', '1'),
(31, '15753005', '9ac036145933817f6d4a84aefd71a5511dbc9fd57e5f56044c370ee9a5bf279d76e88a5ccdeb30ef9af6ac6f048ad5dd59d32e2c1a1725fb27c82a8377086b88', '1'),
(32, '15753006', 'a60fe64373fc1bc338174c9dac60246d297b4923f915cd33d6b094a6708d349213bc3d45e373ba233d438b993e6b85369b3138f5a2ef2014ce05f8079701ec2d', '1'),
(33, '15753007', '3117a4fa40b68f8ae9407d07e55ae2d8ae545f5575f9cc12930378138aba711a3b86a9a8a0a62223f67a572624f873728635c60e1bbd31bdbdd3f13739d9dcc7', '1'),
(34, '15753008', '92b6c989658600c6b737991f46ad2d2c8f1887201d8722c562d04908f31f5bf03fecfeeb2d2007e60e117eebeae250bcce439ed7604e55aee67f7fa6057d0626', '1'),
(35, '15753009', 'bf16bf13a63b5cb47c1388347845f0f298f0956bc6a6206be918df83a84d4f889eb673073c081c175023cad299806d858a450470d769813d766adbf1f25078e0', '1'),
(36, '15753010', 'a9b24cb81847242ac8db99785bc4702dcab0537ea2f01aa5d9d4a00624dbe3e37fd49a6521e30772f3799a49d5def1576be9ac4155fc50eed5cb177299d35020', '1'),
(37, '15753011', '4888d768d3c7093ca5f8944ccbd969a0fc02632fcf872d04a84be12317ca9f7323591bb9c32841c9f72b64c40c44f869a101f9e76e72b8f812a353549c25ebe8', '1'),
(38, '15753012', 'f6b488ef59d2c4b025b976a2b4be1b8c19120d54b0a64d2c08196be630863d7d7adf8bb1f651a151e6050b96d0cdf3fcbe4444f2628b4985c085aa12f53c870c', '1'),
(39, '15753013', '6a94377de5dd3ca9c4aa0cc78eb1b050c5020346b2be5f9c3c6f32aabfe9159fd2889e15d1f45dc74bdd3bb0ef1839fd89f0128982189087b587b9ad468f150c', '1'),
(40, '15753014', '646af67c4199bb4b8d474e91fdb87d8bf65f40aa09c4b71525fc511e37464dbba61aec9024e0485b2e402afcfd6d75c2f923f8bab8cc6b78c42e1488d9cc12a7', '1'),
(41, '15753015', '03c60e38dc67d6cb77487ed08adc6eaa1e5e444c3ce04936e67e556e0abaf0fb7cafe8479f119a46129f5c944c3f5e131e86f0d5b87d187ebcd6d8b1d1c87ccc', '1'),
(42, '15753016', 'ec7c313bab5b46188addfb9c60eb6ccfedaa2f1a175357bc72a27fda4e4c6b4052cc44390b1289ec67e36865b5fb683418dcf388e6aba6a46ca72dcf8ea3fa61', '1'),
(43, '15753017', '8ca0990d44cc174c3ab4bbff2cee417b123d9cd13b738adb94d2db85b52a13caa2c909fbbcb82ce32a079c474e74905ad6b9217650b54f40b1099d204bcb8a2e', '1'),
(44, '15753018', 'e12c2e2968b0b50d002732f1e488fb4df618bc9772af02763261ee0abba50dba119f5209e9550e2b4ece89aa4d33131ead486e75277016eea980d6e43cd2ff37', '1'),
(45, '15753019', '56584ab197402de1a4daaf7ca72402e5453d71346c05dba5ab6c66a89d38599b8411fa663b34d312c2d353b3f49b8a97b9999ce6b9491bd2d760826745840b63', '1'),
(46, '15753020', '100c7e5f94d2d9730b38a71749cc9e6e2bc9a0b22fbfef371272efcf1461867ce6464fedd772009a31f38e6310febb9e9a16674e592bf835700f6230d5852f36', '1'),
(47, '15753021', '59db52a74bc91c83e0f1bf1694c144688f4fb73c7ae8800f5230d1f30a4f9dc4bfef873797d219f0f3e7bd0d6dbac5c293db423f36431d84e05f84c556d47d1f', '1'),
(48, '15753022', '1391244052617eb87e0ab196f4e2d8e26e056ad0cdc9cefa6fd3364d9981c302eaa066b160a1a8c86bb4f3302284bc5b42b14486c816934ff71a00d382003245', '1'),
(49, '15753023', '7d873d59a1f0c0e7c51a767ab85f0d84d885b60c3c5310573d58ac9b06ef092d4d4a031b348a3c1f403572f44e6d68aaee3bc062ddf7ab998c3fdd81d2f2218a', '1'),
(50, '15753024', 'c770bd5ad64da39960638c185ee15d40bb39770a92e74d02fc1b0029294edd4d4244d3201860d045d374500b5c56601bdd16290d7d57efb1e7e7e4209b3519ab', '1'),
(51, '15753025', '9fcfeac833e036ddd8e8cd58fdc62152a4ef58171e852f90810a6a849377ceeef0965a762952c5b0041357702a5ffcd951495786bbafc765cabdf5cf0ee1ba48', '1'),
(52, '15753026', '1ed9e211a38b12e44c032a170d49400d8ea48ebb0b4990a06026ce246dc53eca21f153ad4e9d2bb88e4f1147fc77d6b37ccd6dd79be5842d4380a008c1c03be7', '1'),
(53, '15753027', 'bf9f7cdf6ae3f2610813a0082cdd504a89545886f3194c32b41ab56c1b9f9a146ba356c781cb326591ca7ef169e9f91bcfccd61cb65aa792426e24aaf3de4491', '1'),
(54, '15753028', '1f45a17f9f67c037acb2c19916ab789cb4ce5ec8c40cb0aaeb95967e4a02a5039800f3e23bd8e8085e5240bedf8e3ffb9f4c6e09eadff7a13e9439380f14ac65', '1'),
(55, '15753029', '273a20e8e0584f03a73552f4750a22254e695a8c4ba8e4fae914910d73b69e6640f6ded8b12da43d20bc56746f29fba9d1dfb2f808175c1bed0efbc448166c9d', '1'),
(56, '15753030', 'de9b122168de2eaea40b716ea7a0fdb065f2981dbbce2f40693501968e8d97be1952456e419dd131ce3d53700359ab9b77aeb7b829d7f7c6c337b7f1bfc5bf1b', '1'),
(57, '14753002', 'bbdf0bb3b4901a9d1d06e076484264420a64551815285c56c0834058887bb4f75370e16c5b9bb4fe472e704cf60a1f987350338bdccc916f927585d775654a7b', '2'),
(58, '14753003', '5269d7f9bf50f1e25e8b4ad12d77c79780eac63dd8fc551efbde6b7d7f3e8de7ff3a56c90cf5250378a3ffd6c3b6d3b4b5dfda5c62e96092cbdbf2fda8bba540', '2'),
(59, '14753004', 'c75cfbe1c5e9f62b496c766d6bdff8a2dd71c6cc152aa5b3fb0174241c4aa486032f0fcb60986595993a8b0fe1b368457101fee1704219e1eefcb617e68f8ca9', '2'),
(60, '14753005', '93fbb6832716f712b2b63d5bcc9c8551dfbe454674caa34d9d962e6271728c90b3925d9c956162b0b95ec66aa705d644282c551b177c06e58b5598e623bd747d', '2');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_aturan_level_user`
-- (See below for the actual view)
--
CREATE TABLE `v_aturan_level_user` (
`Siswa` int(1)
,`Guru` int(1)
,`Admin` int(1)
,`Siswa Guru` int(1)
,`Siswa Admin` int(1)
,`Guru Admin` int(1)
,`Siswa Guru Admin` int(1)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_detil_banksoal`
-- (See below for the actual view)
--
CREATE TABLE `v_detil_banksoal` (
`id_banksoal` int(11)
,`soal` varchar(255)
,`id_mapel` int(11)
,`id_guru` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_detil_jawaban_banksoal`
-- (See below for the actual view)
--
CREATE TABLE `v_detil_jawaban_banksoal` (
`id_jawaban_banksoal` int(11)
,`jawaban` varchar(255)
,`status` int(1)
,`id_banksoal` int(11)
,`soal` varchar(255)
,`id_mapel` int(11)
,`semester` varchar(255)
,`mapel` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_tabel_admin`
-- (See below for the actual view)
--
CREATE TABLE `v_tabel_admin` (
`id_user` int(11)
,`username` varchar(255)
,`level` varchar(255)
,`id_admin` int(11)
,`nama` varchar(255)
,`role` varchar(5)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_tabel_detil_kelas_siswa`
-- (See below for the actual view)
--
CREATE TABLE `v_tabel_detil_kelas_siswa` (
`id_kelas` int(11)
,`kelas` varchar(255)
,`status` tinyint(1)
,`id_angkatan` int(11)
,`angkatan` varchar(4)
,`nama_guru` varchar(255)
,`nip_guru` varchar(255)
,`id_guru` int(11)
,`id_mapel` int(11)
,`semester` varchar(255)
,`mata_pelajaran` varchar(255)
,`id_detail_kelas` int(11)
,`id_siswa` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_tabel_guru`
-- (See below for the actual view)
--
CREATE TABLE `v_tabel_guru` (
`id_user` int(11)
,`username` varchar(255)
,`level` varchar(255)
,`id_guru` int(11)
,`nama` varchar(255)
,`nip` varchar(255)
,`role` varchar(4)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_tabel_kelas`
-- (See below for the actual view)
--
CREATE TABLE `v_tabel_kelas` (
`id_kelas` int(11)
,`nama_kelas` varchar(255)
,`status_selesai` tinyint(1)
,`id_guru` int(11)
,`angkatan` varchar(4)
,`semester` varchar(255)
,`id_mapel` int(11)
,`mata_pelajaran` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_tabel_materi`
-- (See below for the actual view)
--
CREATE TABLE `v_tabel_materi` (
`id_guru` int(11)
,`nama_guru` varchar(255)
,`nip_guru` varchar(255)
,`id_mapel` int(11)
,`semester` varchar(255)
,`mapel` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_tabel_siswa`
-- (See below for the actual view)
--
CREATE TABLE `v_tabel_siswa` (
`id_user` int(11)
,`username` varchar(255)
,`level` varchar(255)
,`id_siswa` int(11)
,`id_angkatan` int(11)
,`angkatan` varchar(4)
,`nis` varchar(255)
,`nama` varchar(255)
,`role` varchar(5)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_tabel_ujian`
-- (See below for the actual view)
--
CREATE TABLE `v_tabel_ujian` (
`id_ujian` int(11)
,`waktu_ujian` datetime
,`unix_waktu_ujian` bigint(17)
,`nilai` float(11,2)
,`deadline` datetime
,`unix_deadline` bigint(17)
,`id_kelas` int(11)
,`id_siswa` int(11)
,`kelas` varchar(255)
,`selesai` tinyint(1)
,`nis` varchar(255)
,`nama` varchar(255)
,`sekarang` datetime
,`unix_sekarang` bigint(17)
,`mata_pelajaran` varchar(255)
,`semester` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_tabel_ujian_banksoal`
-- (See below for the actual view)
--
CREATE TABLE `v_tabel_ujian_banksoal` (
`id_ujian_banksoal` int(11)
,`id_ujian` int(11)
,`id_banksoal` int(11)
,`id_jawaban` int(11)
,`id_mapel` int(11)
,`soal` varchar(255)
);

-- --------------------------------------------------------

--
-- Structure for view `v_aturan_level_user`
--
DROP TABLE IF EXISTS `v_aturan_level_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_aturan_level_user`  AS  select 1 AS `Siswa`,2 AS `Guru`,4 AS `Admin`,3 AS `Siswa Guru`,5 AS `Siswa Admin`,6 AS `Guru Admin`,7 AS `Siswa Guru Admin` ;

-- --------------------------------------------------------

--
-- Structure for view `v_detil_banksoal`
--
DROP TABLE IF EXISTS `v_detil_banksoal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_detil_banksoal`  AS  select `b`.`id` AS `id_banksoal`,`b`.`soal` AS `soal`,`b`.`id_mapel` AS `id_mapel`,`m`.`id_guru` AS `id_guru` from (`banksoal` `b` join `mapel` `m`) where (`b`.`id_mapel` = `m`.`id`) ;

-- --------------------------------------------------------

--
-- Structure for view `v_detil_jawaban_banksoal`
--
DROP TABLE IF EXISTS `v_detil_jawaban_banksoal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_detil_jawaban_banksoal`  AS  select `j`.`id` AS `id_jawaban_banksoal`,`j`.`jawaban` AS `jawaban`,`j`.`status` AS `status`,`b`.`id` AS `id_banksoal`,`b`.`soal` AS `soal`,`m`.`id` AS `id_mapel`,`m`.`semester` AS `semester`,`m`.`mata_pelajaran` AS `mapel` from ((`jawaban_banksoal` `j` join `banksoal` `b`) join `mapel` `m`) where ((`j`.`id_banksoal` = `b`.`id`) and (`b`.`id_mapel` = `m`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_tabel_admin`
--
DROP TABLE IF EXISTS `v_tabel_admin`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_tabel_admin`  AS  select `u`.`id` AS `id_user`,`u`.`username` AS `username`,`u`.`level` AS `level`,`a`.`id` AS `id_admin`,`a`.`nama` AS `nama`,'Admin' AS `role` from (`admin` `a` join `user` `u`) where (`a`.`id_user` = `u`.`id`) ;

-- --------------------------------------------------------

--
-- Structure for view `v_tabel_detil_kelas_siswa`
--
DROP TABLE IF EXISTS `v_tabel_detil_kelas_siswa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_tabel_detil_kelas_siswa`  AS  select `k`.`id` AS `id_kelas`,`k`.`kelas` AS `kelas`,`k`.`selesai` AS `status`,`a`.`id` AS `id_angkatan`,`a`.`angkatan` AS `angkatan`,`g`.`nama` AS `nama_guru`,`g`.`nip` AS `nip_guru`,`g`.`id` AS `id_guru`,`m`.`id` AS `id_mapel`,`m`.`semester` AS `semester`,`m`.`mata_pelajaran` AS `mata_pelajaran`,`dk`.`id` AS `id_detail_kelas`,`dk`.`id_siswa` AS `id_siswa` from (((((`kelas` `k` join `detil_kelas` `dk`) join `angkatan` `a`) join `guru` `g`) join `mapel` `m`) join `siswa` `s`) where ((`dk`.`id_kelas` = `k`.`id`) and (`k`.`id_angkatan` = `a`.`id`) and (`k`.`id_guru` = `g`.`id`) and (`k`.`id_mapel` = `m`.`id`) and (`dk`.`id_siswa` = `s`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_tabel_guru`
--
DROP TABLE IF EXISTS `v_tabel_guru`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_tabel_guru`  AS  select `u`.`id` AS `id_user`,`u`.`username` AS `username`,`u`.`level` AS `level`,`g`.`id` AS `id_guru`,`g`.`nama` AS `nama`,`g`.`nip` AS `nip`,'Guru' AS `role` from (`guru` `g` join `user` `u`) where (`g`.`id_user` = `u`.`id`) ;

-- --------------------------------------------------------

--
-- Structure for view `v_tabel_kelas`
--
DROP TABLE IF EXISTS `v_tabel_kelas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_tabel_kelas`  AS  select `k`.`id` AS `id_kelas`,`k`.`kelas` AS `nama_kelas`,`k`.`selesai` AS `status_selesai`,`g`.`id` AS `id_guru`,`a`.`angkatan` AS `angkatan`,`m`.`semester` AS `semester`,`m`.`id` AS `id_mapel`,`m`.`mata_pelajaran` AS `mata_pelajaran` from (((`kelas` `k` join `guru` `g`) join `angkatan` `a`) join `mapel` `m`) where ((`k`.`id_angkatan` = `a`.`id`) and (`k`.`id_guru` = `g`.`id`) and (`k`.`id_mapel` = `m`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_tabel_materi`
--
DROP TABLE IF EXISTS `v_tabel_materi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_tabel_materi`  AS  select `g`.`id` AS `id_guru`,`g`.`nama` AS `nama_guru`,`g`.`nip` AS `nip_guru`,`m`.`id` AS `id_mapel`,`m`.`semester` AS `semester`,`m`.`mata_pelajaran` AS `mapel` from (`mapel` `m` join `guru` `g`) where (`m`.`id_guru` = `g`.`id`) order by `m`.`id` desc ;

-- --------------------------------------------------------

--
-- Structure for view `v_tabel_siswa`
--
DROP TABLE IF EXISTS `v_tabel_siswa`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_tabel_siswa`  AS  select `u`.`id` AS `id_user`,`u`.`username` AS `username`,`u`.`level` AS `level`,`s`.`id` AS `id_siswa`,`a`.`id` AS `id_angkatan`,`a`.`angkatan` AS `angkatan`,`s`.`nis` AS `nis`,`s`.`nama` AS `nama`,'Siswa' AS `role` from ((`user` `u` join `siswa` `s`) join `angkatan` `a`) where ((`s`.`id_user` = `u`.`id`) and (`s`.`id_angkatan` = `a`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_tabel_ujian`
--
DROP TABLE IF EXISTS `v_tabel_ujian`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_tabel_ujian`  AS  select `u`.`id` AS `id_ujian`,`u`.`waktu_ujian` AS `waktu_ujian`,unix_timestamp(`u`.`waktu_ujian`) AS `unix_waktu_ujian`,`u`.`nilai` AS `nilai`,(`u`.`waktu_ujian` + interval 1 hour) AS `deadline`,unix_timestamp((`u`.`waktu_ujian` + interval 1 hour)) AS `unix_deadline`,`u`.`id_kelas` AS `id_kelas`,`u`.`id_siswa` AS `id_siswa`,`k`.`kelas` AS `kelas`,`k`.`selesai` AS `selesai`,`s`.`nis` AS `nis`,`s`.`nama` AS `nama`,now() AS `sekarang`,unix_timestamp(now()) AS `unix_sekarang`,`m`.`mata_pelajaran` AS `mata_pelajaran`,`m`.`semester` AS `semester` from (((`ujian` `u` join `kelas` `k`) join `siswa` `s`) join `mapel` `m`) where ((`u`.`id_kelas` = `k`.`id`) and (`u`.`id_siswa` = `s`.`id`) and (`k`.`id_mapel` = `m`.`id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_tabel_ujian_banksoal`
--
DROP TABLE IF EXISTS `v_tabel_ujian_banksoal`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_tabel_ujian_banksoal`  AS  select `u`.`id` AS `id_ujian_banksoal`,`u`.`id_ujian` AS `id_ujian`,`u`.`id_banksoal` AS `id_banksoal`,`u`.`id_jawaban` AS `id_jawaban`,`b`.`id_mapel` AS `id_mapel`,`b`.`soal` AS `soal` from (`ujian_soal` `u` join `banksoal` `b`) where (`u`.`id_banksoal` = `b`.`id`) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `angkatan`
--
ALTER TABLE `angkatan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `angkatan` (`angkatan`);

--
-- Indexes for table `banksoal`
--
ALTER TABLE `banksoal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mapel` (`id_mapel`);

--
-- Indexes for table `detil_kelas`
--
ALTER TABLE `detil_kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `jawaban_banksoal`
--
ALTER TABLE `jawaban_banksoal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_banksoal` (`id_banksoal`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_mapel` (`id_mapel`),
  ADD KEY `id_guru` (`id_guru`),
  ADD KEY `id_angkatan` (`id_angkatan`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_angkatan` (`id_angkatan`);

--
-- Indexes for table `ujian`
--
ALTER TABLE `ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kelas` (`id_kelas`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `ujian_soal`
--
ALTER TABLE `ujian_soal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_banksoal` (`id_banksoal`),
  ADD KEY `id_jawaban` (`id_jawaban`),
  ADD KEY `id_ujian` (`id_ujian`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `angkatan`
--
ALTER TABLE `angkatan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `banksoal`
--
ALTER TABLE `banksoal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;
--
-- AUTO_INCREMENT for table `detil_kelas`
--
ALTER TABLE `detil_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `jawaban_banksoal`
--
ALTER TABLE `jawaban_banksoal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=837;
--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `ujian`
--
ALTER TABLE `ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `ujian_soal`
--
ALTER TABLE `ujian_soal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=211;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Constraints for table `banksoal`
--
ALTER TABLE `banksoal`
  ADD CONSTRAINT `banksoal_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id`);

--
-- Constraints for table `detil_kelas`
--
ALTER TABLE `detil_kelas`
  ADD CONSTRAINT `detil_kelas_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id`),
  ADD CONSTRAINT `detil_kelas_ibfk_2` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id`);

--
-- Constraints for table `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Constraints for table `jawaban_banksoal`
--
ALTER TABLE `jawaban_banksoal`
  ADD CONSTRAINT `jawaban_banksoal_ibfk_1` FOREIGN KEY (`id_banksoal`) REFERENCES `banksoal` (`id`);

--
-- Constraints for table `kelas`
--
ALTER TABLE `kelas`
  ADD CONSTRAINT `kelas_ibfk_1` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id`),
  ADD CONSTRAINT `kelas_ibfk_2` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id`),
  ADD CONSTRAINT `kelas_ibfk_3` FOREIGN KEY (`id_angkatan`) REFERENCES `angkatan` (`id`);

--
-- Constraints for table `mapel`
--
ALTER TABLE `mapel`
  ADD CONSTRAINT `mapel_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id`);

--
-- Constraints for table `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `siswa_ibfk_2` FOREIGN KEY (`id_angkatan`) REFERENCES `angkatan` (`id`);

--
-- Constraints for table `ujian`
--
ALTER TABLE `ujian`
  ADD CONSTRAINT `ujian_ibfk_1` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`id`),
  ADD CONSTRAINT `ujian_ibfk_2` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id`);

--
-- Constraints for table `ujian_soal`
--
ALTER TABLE `ujian_soal`
  ADD CONSTRAINT `ujian_soal_ibfk_1` FOREIGN KEY (`id_banksoal`) REFERENCES `banksoal` (`id`),
  ADD CONSTRAINT `ujian_soal_ibfk_2` FOREIGN KEY (`id_jawaban`) REFERENCES `jawaban_banksoal` (`id`),
  ADD CONSTRAINT `ujian_soal_ibfk_3` FOREIGN KEY (`id_ujian`) REFERENCES `ujian` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
