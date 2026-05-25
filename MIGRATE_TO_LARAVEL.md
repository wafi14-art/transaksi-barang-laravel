# Migrasi Ke Laravel Asli

Repo ini belum bisa dijalankan sebagai Laravel penuh. Saat pindah ke Laravel baru, pakai file aplikasi berikut:

- `app/Http/Controllers`
- `app/Http/Middleware/AuthMiddleware.php`
- `app/Models`
- `resources/views`
- `routes/web.php`
- `database/migrations`

File yang tidak perlu dipindah:

- `Illuminate/`
- `helpers.php`
- `autoload.php`
- `public/index.php`

## Catatan soal npm

Repo ini tidak memakai Vite, Webpack, atau pipeline frontend lain, jadi `npm install` dan `npm run dev` memang bukan langkah yang dibutuhkan di sini.
`package.json` yang ada sekarang hanya disediakan agar perintah `npm` tidak gagal karena file hilang.
Kalau nanti aplikasi dipindah ke project Laravel baru yang memakai Vite bawaan, barulah jalankan:

```powershell
npm install
npm run dev
```

## 1. Install tools

Pastikan Windows sudah punya:

- PHP 8.2 atau lebih baru
- Composer
- MySQL atau MariaDB

Paling mudah biasanya pakai Laragon, atau XAMPP + Composer.

## 2. Buat project Laravel baru

```powershell
composer create-project laravel/laravel transaksi-barang-laravel
cd transaksi-barang-laravel
```

## 3. Copy file aplikasi dari repo ini

Salin file/folder berikut ke project Laravel baru:

- `app/Http/Controllers/AuthController.php`
- `app/Http/Controllers/BarangController.php`
- `app/Http/Controllers/PelangganController.php`
- `app/Http/Controllers/TransaksiController.php`
- `app/Http/Middleware/AuthMiddleware.php`
- `app/Models/Barang.php`
- `app/Models/Pelanggan.php`
- `app/Models/Transaksi.php`
- `app/Models/DetailTransaksi.php`
- `app/Models/User.php`
- seluruh folder `resources/views`
- isi `routes/web.php`
- seluruh file di `database/migrations`

## 4. Rename migration ke format Laravel

Laravel membutuhkan prefix timestamp pada nama file migration. Rename menjadi seperti ini:

- `2026_05_08_000001_create_users_table.php`
- `2026_05_08_000002_create_barang_table.php`
- `2026_05_08_000003_create_pelanggan_table.php`
- `2026_05_08_000004_create_transaksi_table.php`
- `2026_05_08_000005_create_detail_transaksi_table.php`

## 5. Buat database

Buat database MySQL, misalnya:

- `transaksi_barang`

Lalu isi `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=transaksi_barang
DB_USERNAME=root
DB_PASSWORD=
```

## 6. Register middleware

Kalau memakai Laravel 11, buka `bootstrap/app.php` lalu tambahkan alias:

```php
->withMiddleware(function ($middleware) {
    $middleware->alias([
        'auth.session' => \App\Http\Middleware\AuthMiddleware::class,
    ]);
})
```

Setelah itu ubah group middleware di `routes/web.php` menjadi:

```php
Route::middleware(['auth.session'])->group(function () {
    // routes
});
```

## 7. Jalankan migration

```powershell
php artisan migrate
```

## 8. Buat user admin pertama

```powershell
php artisan tinker
```

Lalu:

```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password123'),
    'role' => 'admin',
]);
```

## Info login

Setelah membuat user admin di atas, gunakan kredensial berikut untuk login:

- Email: `admin@example.com`
- Password: `password123`

> Pastikan user sudah dibuat di database dan password disimpan dalam bentuk hash.

## 9. Jalankan server

```powershell
php artisan serve
```

Buka:

- `http://127.0.0.1:8000/login`

## Catatan penting

- Model `Barang`, `Pelanggan`, `Transaksi`, dan `DetailTransaksi` sudah disiapkan dengan nama tabel eksplisit karena tabel project ini tidak memakai bentuk plural default Laravel.
- Login saat ini masih memakai session manual, belum auth bawaan Laravel.
- Setelah project berhasil hidup, tahap berikutnya yang bagus adalah merapikan auth, menambah seeder, dan membuat validasi yang lebih lengkap.
