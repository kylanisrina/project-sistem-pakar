-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 18 Des 2024 pada 09.33
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sispak`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `user` varchar(16) NOT NULL,
  `pass` varchar(16) NOT NULL,
  `level` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_admin`
--

INSERT INTO `tb_admin` (`user`, `pass`, `level`) VALUES
('admin', 'admin', ''),
('citra', 'citra20', ''),
('elen', 'elen21', ''),
('kylaimut', 'kyla18', ''),
('miftha', 'miftha19', ''),
('trulala', 'trulala1', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_diagnosa`
--

CREATE TABLE `tb_diagnosa` (
  `kode_diagnosa` varchar(16) NOT NULL,
  `nama_diagnosa` varchar(256) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_diagnosa`
--

INSERT INTO `tb_diagnosa` (`kode_diagnosa`, `nama_diagnosa`, `keterangan`) VALUES
('P001', 'Penyakit TBC', 'Penyebab Turbekolosis :\r\nTBC (Tuberkulosis)&nbsp; dikenal dengan TB penyakit paru-paru akibat kuman Mycobacterium tuberculosis. Penyakit ini ditularkan dari percikan ludah yang keluar penderita TBC, ketika berbicara, batuk, atau bersin.\r\n\r\nPengobatan Turbekolosis : TBC dapat dideteksi melalui pemeriksaan dahak. Beberapa tes lain yang dapat dilakukan untuk mendeteksi penyakit menular ini adalah foto Rontgen dada, tes darah, atau tes kulit (Mantoux). TBC disembuhkan jika penderitanya patuh mengonsumsi obat sesuai dengan resep dokter.\r\nPencegahan Turbekolosis :TBC dapat dicegah dengan pemberian vaksin, yang disarankan dilakukan sebelum bayi berusia 2 bulan. Selain itu, pencegahan juga dapat dilakukan dengan cara: Mengenakan masker saat berada di tempat ramai. Tutupi mulut saat bersin, batuk, dan tertawa.\r\nTidak membuang dahak atau meludah sembarangan.'),
('P002', 'Penyakit Campak', 'Penyebab Campak : Campak merupakan infeksi yang disebabkan oleh virus. Kemunculan ruam di seluruh tubuh sebagai gejalanya dan sangat menular. Campak sangat menular dan akan memunculkan ruam pada seluruh tubuh. Umumnya, sekitar satu hingga dua minggu setelah virus masuk ke dalam tubuh, gejala campak baru akan muncul.\r\n\r\nPengobatan Campak :\r\nMinum banyak air untuk mencegah dehidrasi\r\nBanyak istirahat dan hindari sinar matahari selama mata masih sensitif terhadap cahaya\r\nMinum obat penurun demam dan obat pereda sakit serta nyeri\r\n\r\nPencegahan Campak :\r\nCampak juga dikenal dengan rubeola atau campak merah. Saat ini telah tersedia vaksin untuk mencegah penyakit ini. Vaksin untuk campak termasuk dalam bagian dari vaksin MMR (campak, gondongan, campak Jerman). Vaksinasi MMR adalah vaksin gabungan untuk campak dan campak Jerman. Vaksinasi MMR diberikan dua kali. Pertama, diberikan ketika Si Kecil berusia 15 bulan dan dosis vaksin MMR berikutnya diberikan saat mereka berusia 5-6 tahun atau sebelum memasuki masa sekolah dasar. Vaksin memiliki fungsi yang cukup penting dalam mencegah campak.'),
('P003', 'Penyakit Cacar Air', 'Penyebab Cacar Air :\r\nPenyakit cacar air atau dalam istilah medis disebut varicella adalah infeksi yang disebabkan virus Varicella. Penderita yang terinfeksi virus ini ditandai dengan munculnya ruam kemerahan berisi cairan yang sangat gatal di seluruh tubuh.Cacar air disebabkan oleh virus, yang mudah menular melalui percikan ludah, serta kontak langsung dengan cairan yang berasal dari ruam. Penyakit ini lebih rentan menyerang anak-anak di bawah usia 12 tahun.\r\n\r\nPengobatan Cacar Air :\r\nPengobatan cacar air bertujuan untuk mengurangi keparahan gejala yang dialami oleh pasien, dengan atau tanpa bantuan obat. Ada beberapa pengobatan mandiri yang bisa dilakukan untuk meringankan gejala, yaitu: Perbanyak minum dan mengonsumsi makanan yang lembut.Tidak menggaruk ruam atau luka cacar air. Mengenakan pakaian berbahan lembut dan ringan\r\n\r\nPencegahan Cacar Air :\r\nSebagai upaya pencegahan penyakit cacar air, dianjurkan untuk melakukan vaksinasi cacar air atau vaksin varicella. Di Indonesia sendiri, vaksinasi cacar air tidak termasuk dalam daftar imunisasi rutin lengkap, tapi tetap dianjurkan untuk diberikan.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_gejala`
--

CREATE TABLE `tb_gejala` (
  `kode_gejala` varchar(8) NOT NULL,
  `nama_gejala` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_gejala`
--

INSERT INTO `tb_gejala` (`kode_gejala`, `nama_gejala`) VALUES
('G001', 'Flu'),
('G002', 'Demam'),
('G003', 'Tidak Nafsu Makan'),
('G004', 'Nyeri Tenggorokon'),
('G005', 'Mual atau Muntah'),
('G006', 'Ruam Kulit Berwarna Merah'),
('G007', 'Batuk'),
('G008', 'Diare'),
('G009', 'Mata Merah'),
('G010', 'Nyeri Dada atau Sesak');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_identitas`
--

CREATE TABLE `tb_identitas` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jk` varchar(10) NOT NULL,
  `umur` int NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `gejala` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_relasi`
--

CREATE TABLE `tb_relasi` (
  `ID` int NOT NULL,
  `kode_diagnosa` varchar(16) NOT NULL,
  `kode_gejala` varchar(16) NOT NULL,
  `mb` double NOT NULL,
  `md` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `tb_relasi`
--

INSERT INTO `tb_relasi` (`ID`, `kode_diagnosa`, `kode_gejala`, `mb`, `md`) VALUES
(0, 'P001', 'G002', 0.6, 0.2),
(1, 'P001', 'G003', 0.8, 0.1),
(2, 'P001', 'G004', 0.8, 0.2),
(3, 'P001', 'G005', 0.8, 0.2),
(4, 'P001', 'G007', 0.8, 0.5),
(5, 'P001', 'G010', 0.9, 0.1),
(6, 'P002', 'G001', 0.9, 0.1),
(7, 'P002', 'G002', 0.8, 0.1),
(8, 'P002', 'G003', 0.9, 0.1),
(9, 'P002', 'G004', 0.7, 0.2),
(10, 'P002', 'G005', 0.9, 0.1),
(11, 'P002', 'G006', 0.8, 0.1),
(12, 'P002', 'G007', 0.8, 0.1),
(13, 'P002', 'G008', 0.9, 0.1),
(14, 'P002', 'G009', 0.9, 0.1),
(15, 'P003', 'G002', 0.8, 0.5),
(16, 'P003', 'G003', 0.9, 0.1),
(17, 'P003', 'G004', 0.6, 0.1),
(18, 'P003', 'G006', 0.8, 0.1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`user`);

--
-- Indeks untuk tabel `tb_diagnosa`
--
ALTER TABLE `tb_diagnosa`
  ADD PRIMARY KEY (`kode_diagnosa`);

--
-- Indeks untuk tabel `tb_gejala`
--
ALTER TABLE `tb_gejala`
  ADD PRIMARY KEY (`kode_gejala`);

--
-- Indeks untuk tabel `tb_identitas`
--
ALTER TABLE `tb_identitas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tb_relasi`
--
ALTER TABLE `tb_relasi`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `kode_diagnosa` (`kode_diagnosa`),
  ADD KEY `kode_gejala` (`kode_gejala`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_identitas`
--
ALTER TABLE `tb_identitas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_relasi`
--
ALTER TABLE `tb_relasi`
  ADD CONSTRAINT `tb_relasi_ibfk_1` FOREIGN KEY (`kode_diagnosa`) REFERENCES `tb_diagnosa` (`kode_diagnosa`),
  ADD CONSTRAINT `tb_relasi_ibfk_2` FOREIGN KEY (`kode_gejala`) REFERENCES `tb_gejala` (`kode_gejala`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
