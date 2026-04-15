-- 1. Buat Database
CREATE DATABASE IF NOT EXISTS `peminjaman_alat_camp`;
USE `peminjaman_alat_camp`;

-- 2. Tabel Users (Digunakan di User_model.php)
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role` enum('admin','petugas','peminjam') NOT NULL DEFAULT 'peminjam',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Tabel Categories (Digunakan di Kategori_model.php)
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Tabel Equipment (Digunakan di Alat_model.php)
CREATE TABLE IF NOT EXISTS `equipment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `nama_alat` varchar(100) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `harga_sewa` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Tabel Loans (Digunakan di Peminjaman_model.php)
CREATE TABLE IF NOT EXISTS `loans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `equipment_id` int(11) NOT NULL,
  `tanggal_pinjam` datetime NOT NULL,
  `tanggal_jatuh_tempo` datetime NOT NULL,
  `tanggal_kembali` datetime DEFAULT NULL,
  `jumlah` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `denda_terlambat` int(11) DEFAULT 0,
  `denda_kerusakan` int(11) DEFAULT 0,
  `denda` int(11) DEFAULT 0,
  `kondisi_kembali` enum('baik','rusak') DEFAULT 'baik',
  `status` enum('pending','approved','rejected','returned','return_requested') DEFAULT 'pending',
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_equipment` FOREIGN KEY (`equipment_id`) REFERENCES `equipment` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Tabel Activity Logs (Digunakan di Log_model.php)
CREATE TABLE IF NOT EXISTS `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `action` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_log_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data Awal untuk Login (Username: admin / petugas, Password: admin123)
-- Menghapus data lama agar password diperbarui
DELETE FROM `users` WHERE `username` IN ('admin', 'petugas');

INSERT IGNORE INTO `users` (`username`, `password`, `nama_lengkap`, `role`) VALUES
('admin', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgNIvB.f3.P71Sg83Vw.J3p9z0jW', 'Administrator', 'admin'),
('petugas', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgNIvB.f3.P71Sg83Vw.J3p9z0jW', 'Petugas Gudang', 'petugas');

-- Contoh Data Kategori
INSERT IGNORE INTO `categories` (`nama_kategori`) VALUES ('Tenda'), ('Tas'), ('Alat Masak');

-- 7. Stored Procedure untuk Hitung Denda (Rp 5.000 / jam)
DELIMITER //
DROP PROCEDURE IF EXISTS sp_kembalikan_alat //
CREATE PROCEDURE sp_kembalikan_alat(
    IN p_loan_id INT,
    IN p_tgl_kembali DATETIME,
    IN p_kondisi VARCHAR(10),
    IN p_denda_kerusakan INT
)
BEGIN
    DECLARE v_jatuh_tempo DATETIME;
    DECLARE v_jam_telat INT;
    DECLARE v_denda_telat INT DEFAULT 0;
    DECLARE v_denda_rusak INT DEFAULT 0;

    SELECT tanggal_jatuh_tempo INTO v_jatuh_tempo FROM loans WHERE id = p_loan_id;

    IF p_tgl_kembali > v_jatuh_tempo THEN
        -- Menghitung selisih jam dan dibulatkan ke atas
        SET v_jam_telat = CEIL(TIMESTAMPDIFF(SECOND, v_jatuh_tempo, p_tgl_kembali) / 3600);
        -- Denda Rp 10.000 per jam jika telat
        SET v_denda_telat = v_jam_telat * 10000;
    END IF;

    -- Jika kondisi rusak, tambahkan denda flat Rp 10.000
    IF p_kondisi = 'rusak' THEN
        SET v_denda_rusak = 10000;
    END IF;

    -- Tambahkan denda kerusakan tambahan dari input petugas
    SET v_denda_rusak = v_denda_rusak + p_denda_kerusakan;

    UPDATE loans 
    SET tanggal_kembali = p_tgl_kembali, 
        denda_terlambat = v_denda_telat,
        denda_kerusakan = v_denda_rusak,
        denda = v_denda_telat + v_denda_rusak,
        kondisi_kembali = p_kondisi,
        status = 'returned' 
    WHERE id = p_loan_id;
END //
DELIMITER ;
