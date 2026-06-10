-- =========================================================
-- Database: ta_db_coffeeshop
-- =========================================================

-- 1. Tabel User
CREATE TABLE user (
  id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  nama_lengkap VARCHAR(255) NOT NULL,
  role VARCHAR(50) NOT NULL
);

-- 2. Tabel Menu Produk
CREATE TABLE menu_produk (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nama_produk VARCHAR(255) NOT NULL,
  harga DECIMAL(10,2) NOT NULL,
  deskripsi TEXT,
  kategori VARCHAR(100) NOT NULL
);

-- 3. Tabel Pesanan
CREATE TABLE pesanan (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nama_pelanggan VARCHAR(255) NOT NULL,
  id_produk INT NOT NULL,
  jumlah INT NOT NULL,
  total_harga DECIMAL(10,2) NOT NULL,
  status_pesanan VARCHAR(50) NOT NULL,
  tanggal_pesanan TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  detail_pesanan TEXT DEFAULT '[]'
);

-- 4. Tabel Desain Pesanan
CREATE TABLE desain_pesanan (
  id INT PRIMARY KEY AUTO_INCREMENT,
  id_pesanan INT NOT NULL,
  file_desain_url TEXT,
  keterangan TEXT,
  tanggal_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. Tabel Pesan Kontak
CREATE TABLE pesan_kontak (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nama VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  subjek VARCHAR(255) NOT NULL,
  pesan TEXT NOT NULL,
  tanggal_dikirim TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

