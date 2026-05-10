# Implementasi Payment Gateway (Midtrans QRIS) untuk Top-Up Saldo

Fitur top-up saldo saat ini langsung menambah saldo ke e-Wallet (`wallet_balance`). Untuk menambahkan payment gateway yang bisa menghasilkan QRIS, kita akan menggunakan **Midtrans** (via Snap API), yang merupakan standar payment gateway di Indonesia untuk QRIS.

## User Review Required

> [!IMPORTANT]
> **Integrasi Midtrans membutuhkan API Keys.** 
> Apakah Anda sudah memiliki akun Midtrans (Sandbox/Production) dan memiliki Server Key & Client Key? Jika belum, Anda perlu mendaftar di [Midtrans Simulator/Sandbox](https://simulator.midtrans.com/) terlebih dahulu. 
> Untuk saat ini, saya akan menyiapkan kodenya agar siap digunakan dan Anda hanya tinggal memasukkan kunci API ke file `.env`.

> [!WARNING]
> **Webhook (Notifikasi Pembayaran):**
> Agar saldo otomatis bertambah setelah pelanggan membayar via QRIS, Midtrans perlu mengirimkan notifikasi ke aplikasi kita (Webhook). Karena aplikasi saat ini berjalan di localhost (`127.0.0.1`), webhook dari Midtrans tidak akan bisa langsung masuk kecuali Anda menggunakan tool seperti **Ngrok** untuk mengekspos localhost Anda ke internet, atau melakukan testing di server production/staging.

## Proposed Changes

### 1. Konfigurasi Lingkungan (.env)
Menambahkan variabel environment untuk konfigurasi Midtrans:
- `MIDTRANS_SERVER_KEY`
- `MIDTRANS_CLIENT_KEY`
- `MIDTRANS_IS_PRODUCTION`

### 2. Database & Model

#### [NEW] `TopupTransaction` Model & Migration
Membuat tabel baru untuk mencatat riwayat percobaan top-up dan statusnya dari payment gateway:
- `id` (Primary Key)
- `user_id` (Foreign Key ke users)
- `order_id` (String unik untuk Midtrans, misal: `TOPUP-12345-TIMESTAMP`)
- `amount` (Integer)
- `status` (Enum: `pending`, `success`, `failed`, `expired`)
- `snap_token` (String, opsional untuk menyimpan token dari Midtrans)

### 3. Backend (Controllers & Routes)

#### [MODIFY] `app/Http/Controllers/UserController.php`
- Mengubah fungsi `topup(Request $request)` agar:
  1. Membuat record baru di tabel `TopupTransaction` dengan status `pending`.
  2. Memanggil API Midtrans (menggunakan package resmi `midtrans/midtrans-php` atau Http Client) untuk mendapatkan `snap_token` atau Redirect URL.
  3. Mengembalikan pengguna ke halaman yang menampilkan komponen Midtrans Snap (yang di dalamnya terdapat opsi QRIS).

#### [NEW] Webhook Controller (Misal: `PaymentCallbackController.php`)
- Membuat endpoint POST `/api/midtrans-callback` yang akan dipanggil oleh Midtrans secara otomatis ketika pembayaran berhasil (settled), kedaluwarsa (expired), atau gagal (failed).
- Endpoint ini akan:
  1. Memverifikasi *signature key* dari Midtrans untuk keamanan.
  2. Mencari `TopupTransaction` berdasarkan `order_id`.
  3. Jika status dari Midtrans adalah `settlement` atau `capture`, ubah status transaksi menjadi `success` dan **tambahkan `wallet_balance` user**.

#### [MODIFY] `routes/web.php` & `routes/api.php`
- Mengatur rute untuk proses top-up dan webhook Midtrans.

### 4. Frontend (Views)

#### [MODIFY] `resources/views/user/profile.blade.php`
- Menyesuaikan UI modal top-up. Setelah memasukkan nominal, kita akan memicu popup Midtrans Snap.

## Verification Plan

### Automated Tests
- Menjalankan `php artisan migrate` untuk memastikan tabel transaksi top-up terbuat dengan benar.
- Mengecek syntax dan kompilasi view.

### Manual Verification
1. Login sebagai user dan mencoba top-up e-Wallet.
2. Memastikan aplikasi menghasilkan `order_id` dan berhasil memicu Snap Midtrans UI.
3. Memastikan opsi pembayaran **QRIS** muncul di dalam UI Snap Midtrans.
4. (Opsional, jika ada Ngrok) Mensimulasikan pembayaran berhasil di Midtrans Simulator dan memastikan Webhook tereksekusi, saldo otomatis bertambah, dan status transaksi berubah menjadi `success`.
