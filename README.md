# alterdev.id — Website & Sistem Informasi

Website company profile **alterdev.id** (*Your Digital Partner and IT Solution*) lengkap dengan panel admin.
Dibangun dengan **Laravel 13 + MySQL**, tampilan *glass + neumorphism*, tanpa proses build front-end
(CSS dan JS biasa di folder `public/`), sehingga mudah dipasang di shared hosting / cPanel.

---

## Fitur

### Website publik

| Halaman | Alamat | Isi |
|---|---|---|
| Beranda | `/` | Hero, layanan, program pelatihan, pendampingan lembaga pendidikan, portofolio (dengan filter), cara kerja, keunggulan, testimoni, artikel terbaru, FAQ, formulir kontak |
| Layanan | `/layanan`, `/layanan/{slug}` | Daftar layanan dan halaman detail per layanan + proyek terkait |
| Pelatihan | `/pelatihan`, `/pelatihan/{slug}` | Program pelatihan, jadwal terdekat, **pendaftaran online** dengan kuota otomatis |
| Portofolio | `/portofolio`, `/portofolio/{slug}` | Daftar proyek dengan filter kategori, studi kasus (tantangan – solusi – hasil) |
| Blog | `/blog`, `/blog/{slug}` | Artikel dengan kategori, pencarian, dan jumlah pembaca |
| Tentang Kami | `/tentang-kami` | Profil, visi, misi, tim |
| Kontak | `/kontak` | Formulir konsultasi, info kontak |
| Sitemap | `/sitemap.xml` | Untuk Google Search Console |

Lainnya: tombol WhatsApp melayang, meta SEO & Open Graph, halaman 404/419/429 berbahasa Indonesia,
perlindungan spam (honeypot + pembatasan kirim formulir).

### Panel admin (`/admin`)

- **Dasbor** — ringkasan pesan baru, pendaftar menunggu, jadwal mendatang, grafik pesan 6 bulan.
- **Pesan Masuk** — status tindak lanjut (Baru → Ditindaklanjuti → Selesai → Arsip), catatan internal,
  tombol balas via WhatsApp/email, pencarian, unduh CSV.
- **Pelatihan** — program, jadwal (tanggal, mode tatap muka/daring/hybrid, lokasi, kuota, biaya, batas daftar),
  daftar peserta per jadwal, ubah status peserta, unduh CSV peserta.
- **Konten** — layanan, portofolio (unggah gambar), testimoni, FAQ, tim, blog (Markdown, draf, terjadwal, gambar sampul).
- **Pengaturan Situs** — nama, tagline, teks beranda, halaman Tentang Kami, kontak, media sosial.
- **Pengguna Admin** & **Akun Saya** — tambah admin, ganti password.
- Notifikasi email ke admin untuk pesan & pendaftar baru (opsional, isi `NOTIFY_EMAIL`).

---

## Kebutuhan

- PHP **8.3** atau lebih baru, dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `gd` atau `imagick`
- Composer 2
- MySQL 8 / MariaDB 10.6+

## Instalasi (lokal)

```bash
# 1. Pasang dependensi
composer install

# 2. Salin konfigurasi lalu sesuaikan isi .env (database, URL, akun admin)
cp .env.example .env
php artisan key:generate

# 3. Buat database kosong bernama "alterdev" di MySQL, lalu:
php artisan migrate --seed

# 4. Tautkan folder upload agar gambar bisa tampil
php artisan storage:link

# 5. Jalankan
php artisan serve
```

Buka `http://localhost:8000` untuk website dan `http://localhost:8000/admin` untuk panel admin.

Akun admin awal diambil dari `.env`:

```
ADMIN_EMAIL=admin@alterdev.id
ADMIN_PASSWORD=isi-password-kuat-minimal-10-karakter
```

Bila `ADMIN_PASSWORD` dikosongkan atau terlalu lemah, `php artisan migrate --seed` akan membuat
password acak dan menampilkannya **satu kali** di terminal — segera catat.

Cara singkat: `composer run setup` menjalankan langkah 1–4 sekaligus (setelah `.env` diisi).

## Menjalankan pengujian

```bash
php artisan test
```

Pengujian memakai SQLite di memori, memeriksa semua halaman publik dan admin, formulir kontak,
pendaftaran pelatihan beserta batas kuota, serta penyimpanan pengaturan.

---

## Pemasangan di hosting (cPanel)

1. Unggah seluruh isi proyek ke folder di luar `public_html`, misalnya `~/alterdev`.
2. Jalankan `composer install --no-dev --optimize-autoloader` (via Terminal cPanel).
3. Arahkan domain ke folder `~/alterdev/public`.
   Jika tidak bisa mengubah document root, salin isi folder `public/` ke `public_html/`
   lalu ubah dua baris di `public_html/index.php` agar menunjuk ke `~/alterdev/vendor/autoload.php`
   dan `~/alterdev/bootstrap/app.php`.
4. Buat database MySQL di cPanel dan isi `.env`:
   ```
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://alterdev.id
   DB_DATABASE=...
   DB_USERNAME=...
   DB_PASSWORD=...
   ```
5. Jalankan:
   ```bash
   php artisan key:generate
   php artisan migrate --seed --force
   php artisan storage:link
   php artisan config:cache && php artisan route:cache && php artisan view:cache
   ```
6. Untuk notifikasi email, isi pengaturan `MAIL_*` dan `NOTIFY_EMAIL` di `.env`.

Setiap kali mengubah `.env`, jalankan ulang `php artisan config:cache`.

---

## Keamanan

Perlindungan yang sudah diterapkan:

| Ancaman | Perlindungan |
|---|---|
| Pemalsuan formulir (CSRF) | Token CSRF Laravel di semua formulir |
| XSS / sisipan skrip | Semua keluaran di-*escape*; Markdown membuang HTML mentah & tautan `javascript:`; Content Security Policy tanpa skrip inline |
| Clickjacking | `X-Frame-Options: DENY` dan `frame-ancestors 'none'` |
| SQL Injection | Seluruh kueri lewat Eloquent / *parameter binding* |
| Tebak password (brute force) | Akun dikunci 5 menit setelah 5 kali gagal per email + IP, ditambah batas 10 permintaan/menit per IP; login gagal dicatat di log |
| Password lemah | Minimal 10 karakter berisi huruf & angka; disimpan dengan bcrypt; admin awal tidak bisa memakai password bawaan |
| Sesi | Sesi dienkripsi, ID sesi diperbarui saat login, cookie `HttpOnly` + `SameSite=Lax`, opsi `SESSION_SECURE_COOKIE` untuk HTTPS |
| Unggah berkas berbahaya | Hanya JPG/PNG/WEBP (dicek dari isi berkas), batas ukuran & dimensi, nama berkas acak, folder unggahan menolak eksekusi skrip |
| Spam formulir | *Honeypot* + batas kirim (kontak 5/menit, pendaftaran 10/menit per IP) |
| CSV/Formula injection | Nilai ekspor yang diawali `= + - @` dinetralkan |
| Kebocoran data | Panel admin & halaman pendaftaran tidak disimpan cache dan tidak diindeks; kode pendaftaran acak 8 karakter; pesan login tidak membocorkan email terdaftar |
| Akses berkas sensitif | `.env`, `.git`, dan berkas tersembunyi lain diblokir di `public/.htaccess` |
| Mass assignment | Setiap model memakai daftar `$fillable` dan data yang sudah divalidasi |

**Wajib dilakukan saat produksi:**

1. `APP_ENV=production`, `APP_DEBUG=false` (agar pesan galat tidak menampilkan kode/konfigurasi).
2. Pasang HTTPS (SSL gratis Let's Encrypt/AutoSSL di cPanel), lalu set `SESSION_SECURE_COOKIE=true`.
3. Arahkan *document root* ke folder `public/` — **jangan** letakkan seluruh proyek di `public_html`.
4. Gunakan pengguna database khusus (bukan `root`) dengan password kuat.
5. Pastikan `.env` tidak bisa diunduh: buka `https://domain-anda/.env` → harus muncul 403/404.
6. Perbarui dependensi berkala: `composer update` lalu `composer audit` untuk cek celah keamanan paket.
7. Cadangkan database dan folder `storage/app/public` secara rutin.

Tidak ada sistem yang bisa dijamin 100% aman. Langkah di atas menutup celah umum (OWASP Top 10).
Untuk lapisan tambahan, pertimbangkan Cloudflare (WAF & proteksi DDoS) dan verifikasi dua langkah
untuk akun admin.

## Yang perlu dilengkapi sebelum dipublikasikan

- [ ] Nomor WhatsApp, email, dan alamat kantor → **Admin › Pengaturan Situs › Kontak**
- [ ] Harga mulai di FAQ “Berapa biayanya?” → **Admin › FAQ**
- [ ] Testimoni masih **contoh** → ganti dengan ulasan asli klien (dengan izin) di **Admin › Testimoni**
- [ ] Nama & foto anggota tim → **Admin › Tim**
- [ ] Gambar/tangkapan layar tiap proyek → **Admin › Portofolio**
- [ ] Jadwal pelatihan pertama → **Admin › Program Pelatihan › Tambah Jadwal**

---

## Struktur penting

```
app/
├── Http/Controllers/          # Controller halaman publik
│   └── Admin/                 # Controller panel admin
├── Models/                    # Service, Portfolio, Training, TrainingSchedule,
│                              # TrainingRegistration, Message, Post, Testimonial,
│                              # Faq, TeamMember, Setting
└── Support/                   # Notifier (email), Icons (daftar ikon)
database/
├── migrations/                # Struktur tabel
└── seeders/ContentSeeder.php  # Konten awal (dari desain landing page)
public/css/site.css            # Gaya website (glass + neumorphism)
public/css/admin.css           # Gaya panel admin
resources/views/               # Template Blade (publik, admin, komponen)
routes/web.php                 # Semua rute
```

## Menulis konten dengan Markdown

Deskripsi layanan, program pelatihan, studi kasus portofolio, halaman Tentang Kami, dan isi artikel
mendukung Markdown:

```
## Subjudul
**tebal**, *miring*, [tautan](https://alamat.com)
- poin daftar
1. daftar bernomor
```

Demi keamanan, HTML mentah di dalam Markdown otomatis dibuang.
