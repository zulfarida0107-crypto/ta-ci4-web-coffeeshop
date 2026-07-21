# Classic Coffee Customer Web

Classic Coffee Customer Web — A responsive CodeIgniter 4 web application for customer ordering, featuring product highlights, menu filtering, instant cart management, and dynamic QR Code invoice generation.

## Fitur Utama

- **Produk Unggulan & Menu Kami:** Pemisahan alur yang jelas antara kopi unggulan nusantara dengan daftar menu reguler.
- **Sistem Keranjang Belanja:** Manajemen keranjang belanja interaktif berbasis Alpine.js di sisi client.
- **Konfirmasi Pembayaran QR:** Halaman pembayaran dengan QR Code dinamis berbasis server-side API, lengkap dengan latar belakang doodle artistik.
- **Floating Status Modal:** Notifikasi instan (sukses/gagal/pending) yang muncul melayang di atas halaman QR Code tanpa mengalihkan halaman.
- **Formulir Hubungi Kami:** Integrasi kontak langsung pelanggan ke database.

## Teknologi

- **Framework:** CodeIgniter 4 (PHP 8.2)
- **Frontend:** Vanilla CSS, Alpine.js, HTML5
- **Database:** MySQL (dihubungkan via Spring Boot Server)
- **Web Server:** Apache (Laragon / XAMPP)

## Panduan Instalasi & Menjalankan Project

1. Pastikan Laragon atau XAMPP Anda aktif dengan PHP 8.2+.
2. Clone repository ini ke dalam direktori server Anda (misal `C:/laragon/www/ta-ci4-web-coffeeshop`).
3. Salin file `.env.example` menjadi `.env` dan sesuaikan pengaturan database serta `app.baseURL`.
4. Jalankan perintah composer untuk instalasi dependensi jika diperlukan:
   ```bash
   composer install
   ```
5. Jalankan server lokal melalui terminal:
   ```bash
   php spark serve --port 8081
   ```
6. Buka `http://localhost:8081` di browser Anda.

## Pengujian & Uji Otomatis (Testing)

Proyek ini dilengkapi dengan skrip pengujian otomatis berbasis **Selenium WebDriver** dan **pytest** untuk menjamin fungsionalitas seluruh alur fitur web (39 skenario uji).

### Prasyarat Testing
1. Pastikan Python 3.x telah terpasang pada komputer Anda.
2. Pasang modul Python yang diperlukan melalui pip:
   ```bash
   pip install selenium pytest pytest-html
   ```
3. Pastikan driver browser (seperti ChromeDriver untuk Google Chrome) sesuai dengan versi browser Anda dan sudah terkonfigurasi.

### Menjalankan Uji Otomatis
1. Jalankan aplikasi web CodeIgniter 4 Anda pada port `8081`.
2. Jalankan perintah berikut melalui terminal:
   ```bash
   cd c:/Dokumen/ta-server-coffeeshop/selenium
   pytest test_ci4_web.py -v --html=report_ci4.html --self-contained-html
   ```
3. Hasil pengujian otomatis akan terekam secara detail dan laporan interaktif akan dibuat pada file `report_ci4.html`.

---

## Dokumentasi & Demo

Gunakan kolom di bawah ini untuk menambahkan tangkapan layar (screenshot), animasi GIF, atau video dokumentasi aplikasi Anda.

| Fitur | Tampilan Dokumentasi | Deskripsi |
| --- | --- | --- |
| **Halaman Beranda** | *(Masukkan gambar di sini)* | Halaman utama dengan daftar produk unggulan dan filter menu interaktif. |
| **Detail Produk & Keranjang** | *(Masukkan gambar di sini)* | Pop-up detail menu dan pengelolaan item belanja pelanggan. |
| **QR Code & Detail Pesanan** | *(Masukkan gambar di sini)* | Halaman pembayaran yang menampilkan data pesanan dan kode QR. |
| **Modal Sukses Transaksi** | *(Masukkan gambar di sini)* | Floating modal sukses yang muncul setelah kasir mengonfirmasi pesanan. |
| **Modal Gagal Transaksi** | *(Masukkan gambar di sini)* | Floating modal yang menginfokan kegagalan sistem lengkap dengan alasannya. |
| **Laporan Uji Otomatis (Selenium)** | *(Masukkan gambar di sini)* | File laporan `report_ci4.html` yang merangkum hasil eksekusi uji otomatis seluruh modul web. |
