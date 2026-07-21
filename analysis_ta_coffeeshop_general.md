# 📊 Analisis General Tugas Akhir — Coffee Shop Project

Dokumen ini merupakan rangkuman master plan dan analisis dari seluruh komponen sistem (Web CI4, Mobile Flutter, Backend Spring Boot API).

---

## 1. Status Repo Ini

Sistem ini dirancang menggunakan arsitektur **3-Tier (Client-Server)** yang terbagi dalam tiga repositori/komponen utama. Berikut adalah status keseluruhannya:

| Komponen | Teknologi | Status Saat Ini | Keterangan / Gap |
|---|---|---|---|
| **Web Customer/Admin** | CodeIgniter 4 | ✅ Fungsional (CRUD lengkap) | Masih direct ke Database lokal (MVC Tradisional). Harus diubah menjadi *consume* API. |
| **Mobile Admin** | Flutter | ✅ Fungsional (Offline) | Masih menggunakan SQLite lokal. Harus diubah menggunakan `http` request ke API. |
| **Backend API** | Spring Boot | ❌ **Belum Ada** | **Prioritas Utama (P0)**. Semua *business logic* dan interaksi DB akan dipusatkan di sini. |
| **Database** | MySQL | ⚠️ Siap (Minimal 5 Tabel) | Tabel sudah dirancang (`menu_produk`, `users`, `pesanan`, `desain_pesanan`, `pesan_kontak`), menunggu koneksi dari Spring Boot. |
| **Payment Gateway** | Midtrans | ⚠️ Opsional/Tertunda | Fitur *nice-to-have* untuk sisi customer, dikerjakan setelah API utama selesai. |

---

## 2. Arsitektur Backend (Spring Boot API)

Mengambil referensi dari *best-practice* pengembangan API, struktur arsitektur **Spring Boot** (yang menghubungkan CI4, Flutter, dan Database) akan dibagi menjadi beberapa *layer* folder berikut:

1. **`ServerApplication.java`**: Titik masuk (*entry point*) utama untuk menjalankan server Spring Boot.
2. **`config/`**: Konfigurasi global server. Terdiri dari *SecurityConfig* (CORS, Hak Akses) dan *WebConfig*.
3. **`security/`**: Menangani Autentikasi dan Otorisasi menggunakan JWT (JSON Web Tokens) agar pertukaran data dari CI4/Flutter ke API aman.
4. **`controller/`**: Lapisan REST API. Bertugas menerima HTTP Request (`GET`, `POST`, `PUT`, `DELETE`) dari CI4 dan Flutter, lalu mengembalikan respons berformat JSON.
5. **`service/`**: Lapisan *Business Logic*. Tempat dimana kalkulasi, validasi pesanan, dan logika inti aplikasi ditulis agar tidak menumpuk di controller.
6. **`repository/`**: Lapisan antarmuka (*interface*) menggunakan Spring Data JPA/Hibernate untuk melakukan operasi CRUD langsung ke MySQL tanpa query manual.
7. **`model/` (Entity)**: Representasi tabel MySQL di dalam kode Java (contoh: kelas `MenuProduk.java` merepresentasikan tabel `menu_produk`).
8. **`dto/` (Data Transfer Object)**: Objek pembungkus data untuk mengatur apa saja yang boleh dikirim atau diterima oleh *controller* (misal: menyembunyikan password user saat return JSON).

---

## 3. Workflow (Alur Kerja Sistem)

Seluruh komponen saling terhubung secara *real-time* melalui **REST API**.

### A. Workflow Pemesanan (Customer via Web CI4)
1. **Browse Menu:** Web CI4 melakukan `GET /api/menu-produk` ke Spring Boot API. API mengambil data dari Database dan mengirim respons JSON. CI4 menampilkannya ke pelanggan.
2. **Checkout:** Pelanggan mengisi form dan tekan pesan.
3. **Save Data:** CI4 melakukan `POST /api/pesanan` ke Spring Boot API. 
4. **Midtrans (Opsional):** Jika aktif, sistem menunggu webhook dari Midtrans. Jika sukses, API mengubah status pesanan dari "Pending" menjadi "Baru".

### B. Workflow Pengelolaan (Admin via Flutter)
1. **Login:** Admin membuka aplikasi Flutter, memasukkan kredensial. Flutter menembak `POST /api/auth/login`. API merespons dengan **JWT Token**.
2. **Terima Pesanan:** Flutter secara berkala / saat dibuka menembak `GET /api/pesanan`. Pesanan customer dari CI4 tadi langsung muncul di HP Admin dengan status "Baru".
3. **Update Status:** Barista membuat pesanan. Admin menekan tombol "Proses" di Flutter. Flutter mengirim `PUT /api/pesanan/{id}`. API mengupdate status di MySQL menjadi "Proses".
4. **Sinkronisasi:** Jika pelanggan me-refresh halaman CI4-nya, status pesanannya otomatis berubah menjadi "Proses" karena sumber datanya sama (Satu Database via API).

---

## 4. Kesimpulan & Action Items Prioritas

Sistem yang dibangun sudah memiliki pondasi *frontend* (Web dan Mobile) yang sangat baik dan siap pakai. **Kesimpulan utamanya adalah: Ketiadaan API Layer (Spring Boot) menjadi penghalang satu-satunya untuk menyatukan kedua *frontend* tersebut secara *online*.**

### 🎯 Action Items Prioritas (Sesuai Urutan)

*   **[P0 - KRITIKAL] Membangun Spring Boot API & MySQL**
    Segera inisiasi proyek Spring Boot. Buat koneksi JPA ke MySQL dan susun `model`, `repository`, `service`, dan `controller` untuk ke-5 tabel utama.
*   **[P0 - KRITIKAL] Migrasi Flutter (Offline -> Online)**
    Ubah `DatabaseHelper` (SQLite) di Flutter menjadi `ApiService` menggunakan *package* `http` agar mengkonsumsi JSON dari Spring Boot.
*   **[P1 - TINGGI] Integrasi CI4 ke API**
    Ganti logika Model di Controller CI4 (yang melakukan query langsung ke MySQL) menjadi operasi cURL (`\Config\Services::curlrequest()`) untuk menembak Spring Boot API.
*   **[P2 - SEDANG] Dokumen Blackbox Testing**
    Buat minimal 25-30 skenario *test case* (untuk Web CI4 dan Mobile Flutter) lengkap dengan ekspektasi, hasil aktual, dan *screenshot* sebagai syarat mutlak dari Dosen.
*   **[P3 - RENDAH] Midtrans & UI Finishing**
    Selesaikan integrasi Midtrans dan rapikan *wireframe* Figma jika sisa waktu sebelum presentasi masih memungkinkan.
