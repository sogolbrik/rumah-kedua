# 🏠 RumahKedua

Sistem manajemen kos modern berbasis web untuk pemilik properti dan penghuni — dirancang dengan **presisi data**, **kejelasan antarmuka**, dan **pengalaman pengguna yang elegan**.

> Built for real-world boarding house owners who need reliability, not just features.

---

## 🌟 Fitur Utama

- ✅ Manajemen kamar & penghuni  
- ✅ Pelacakan pembayaran bulanan dengan `tanggal_jatuhtempo` dinamis  
- ✅ **Data transaksi immutable**: `status_pembayaran` tidak pernah diubah setelah disimpan  
- ✅ Notifikasi WhatsApp otomatis saat user resmi jadi penghuni (`role = 'penghuni'`)  
- ✅ Notifikasi keterlambatan — **hanya 1x per bulan** (tidak spam)  
- ✅ Sistem role: `admin` dan `penghuni` dengan middleware terpisah  
- ✅ Login dengan **"Remember Me"** (bertahan 7 hari)  
- ✅ Export laporan ke **Excel** (`.xlsx`, `.csv`) dan **PDF**  
- ✅ Import data penghuni dari file Excel  
- ✅ Dashboard admin dengan visualisasi **Chart.js**  
- ✅ UI interaktif dengan **SweetAlert2** dan **Alpine.js**

---

## 🛠 Tech Stack

| Kategori        | Teknologi |
|-----------------|-----------|
| Framework       | Laravel 12 |
| PHP             | ≥ 8.2 |
| Frontend        | Blade, **Tailwind CSS v4**, **Alpine.js** |
| Styling         | Tailwind + custom CSS |
| Ikon            | **Font Awesome 6** |
| Visualisasi     | **Chart.js** |
| Notifikasi UI   | **SweetAlert2** |
| Export/Import   | `maatwebsite/excel`, `barryvdh/laravel-dompdf` |
| Autentikasi     | Autentikasi Manual |
| JavaScript      | Vanilla JS + Alpine.js |

---

## 📦 Dependencies Utama

### Composer (PHP)
```txt
maatwebsite/excel
barryvdh/laravel-dompdf
guzzlehttp/guzzle
laravel/breeze
```

### NPM (Frontend)
```txt
tailwindcss@latest
alpinejs
chart.js
sweetalert2
```

> 💡 **Catatan**: Proyek ini **tidak menggunakan Livewire, Inertia, atau framework SPA**. Fokus pada **Blade + Alpine.js** untuk interaktivitas ringan.

---

## 🚀 Instalasi

### Prasyarat
- PHP ≥ 8.2
- Composer
- Node.js ≥ 18
- MySQL / MariaDB

### Langkah-langkah

1. **Clone repositori**
   ```bash
   git clone https://github.com/username/rumahkedua.git
   cd rumahkedua
   ```

2. **Install dependensi**
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Konfigurasi environment**
   ```bash
   cp .env.example .env
   ```
   Edit file `.env`:
   - Atur koneksi database (`DB_DATABASE`, `DB_USERNAME`, dll)
   - Sesuaikan `APP_URL` (misal: `http://localhost:8000`)
   - (Opsional) Tambahkan kredensial API WhatsApp

4. **Generate key & migrasi**
   ```bash
   php artisan key:generate
   php artisan migrate --seed
   ```

5. **Jalankan aplikasi**
   ```bash
   php artisan serve
   ```
   Akses di: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🎨 Desain & UX

- **Dua layout terpisah**:
  - `frontend-main.blade.php` → untuk calon penghuni & publik
  - `admin-main.blade.php` → untuk dashboard admin
- **UI modern & profesional**:
  - Animasi transisi halus
  - Soft shadows, proportional radius, konsistensi spacing
  - Palet warna bisnis (hijau sukses, merah error, biru info)
- **Interaksi pengguna**:
  - Konfirmasi aksi via **SweetAlert2**
  - Grafik pembayaran & hunian via **Chart.js**
  - Ikon intuitif dari **Font Awesome**
  - Komponen dinamis dengan **Alpine.js** (tanpa JS framework berat)

---

## 🔐 Prinsip Teknis

- **Tidak ada perubahan struktur tabel** — logika diatur via aplikasi.
- **Middleware berbasis role**:
  - `role:penghuni` → hanya akses route penghuni
  - `role:admin` → akses penuh ke dashboard
- **Webhook development**: Untuk local testing tanpa domain, gunakan `ngrok` atau `expose`.
- **Session flash** digunakan untuk pesan sukses/error — aman dan sekali pakai.

---

## 📬 Integrasi WhatsApp (Opsional)

Notifikasi otomatis dikirim saat:
- `users.role = 'penghuni'`
- `users.id_kamar` dan `users.tanggal_masuk` terisi

> Butuh endpoint publik? Gunakan **ngrok** selama development:
> ```bash
> ngrok http 8000
> ```

---

## 🤝 Kontribusi

Dikembangkan oleh **GlgDev as sogolbrik**.  
Ingin berkontribusi?
1. Fork repositori  
2. Buat branch baru: `git checkout -b fitur/xyz`  
3. Commit & push  
4. Kirim Pull Request  

Pastikan kode mengikuti gaya proyek: **bersih, fungsional, dan UX-first**.

---

## 📄 Lisensi

MIT License — gunakan, pelajari, dan sesuaikan sesukamu.

---

> **RumahKedua**: Lebih dari sekadar aplikasi kos — ini adalah sistem yang menjaga kepercayaan antara pemilik dan penghuni, satu transaksi yang tidak bisa diubah.
