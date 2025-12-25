# 🖥️ Backend & Web Admin – Aplikasi Sewa Perlengkapan Resepsi Pernikahan

Proyek ini merupakan aplikasi backend dan web admin yang dikembangkan menggunakan **Laravel**.  
Aplikasi ini berfungsi sebagai:
- **Backend (API)** untuk aplikasi mobile berbasis React Native
- **Aplikasi Web Admin** untuk mengelola data pesanan, katalog, dan pengguna

## ⚙️ Teknologi yang Digunakan

- Framework: **Laravel**
- Bahasa Pemrograman: **PHP**
- Database: **MySQL**
- Autentikasi API: **Laravel Sanctum**
- Payment Gateway: **Midtrans**
- Frontend Web Admin: **Blade Template + Alpine JS**
- Backend Mobile: **REST API (JSON Response)**

## 📂 Struktur Aplikasi

- **API Backend**
  - Menyediakan endpoint untuk autentikasi pengguna mobile
  - Menyediakan data katalog perlengkapan
  - Menangani proses pemesanan, pembayaran, dan riwayat transaksi

- **Web Admin**
  - Digunakan oleh admin untuk mengelola data aplikasi
  - Mengelola katalog perlengkapan resepsi
  - Mengelola pesanan dari pengguna
  - Memantau status pembayaran dan status pesanan

## 🔐 Autentikasi

- Autentikasi pengguna mobile menggunakan **Laravel Sanctum**
- Autentikasi admin web menggunakan sistem login bawaan Laravel
- Setiap endpoint API yang bersifat privat dilindungi dengan middleware autentikasi

## 🚀 Fitur Backend (API)

- Autentikasi pengguna (login & registrasi)
- Pengambilan data katalog perlengkapan
- Pengelolaan keranjang dan pemesanan
- Pengecekan ketersediaan stok berdasarkan tanggal sewa
- Integrasi pembayaran menggunakan **Midtrans**
- Pengambilan data riwayat transaksi pengguna

## 🧑‍💼 Fitur Web Admin

- Login Admin
- Manajemen data pengguna
- Manajemen data katalog perlengkapan
- Manajemen pesanan
- Melihat detail pesanan dan status pembayaran
- Update status pesanan (diproses, disewa, selesai, dll)

## 🔗 Integrasi Payment Gateway

- Sistem pembayaran terintegrasi dengan **Midtrans**
- Backend bertugas untuk:
  - Membuat transaksi pembayaran
  - Menerima notifikasi (callback) dari Midtrans
  - Memperbarui status pembayaran pada sistem

## 📄 API Response Format

Semua endpoint API menggunakan format response **JSON** dengan struktur umum sebagai berikut:

```json
{
  "status": true,
  "message": "Request berhasil",
  "data": {}
}
