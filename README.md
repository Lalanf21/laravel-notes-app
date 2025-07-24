# 📝 Simple Note-Taking App

Aplikasi web sederhana untuk mencatat, berbagi catatan ke pengguna lain atau publik, dan memberi komentar. Dibangun menggunakan Laravel 8, PostgreSQL, Inertia.js (Vue 3), dan Tailwind CSS.

---

## 🚀 Fitur Utama

- 🔐 Login & Register pengguna
- 🗒 Membuat catatan pribadi
- 🔗 Berbagi catatan ke pengguna lain atau publik
- 💬 Memberi komentar pada catatan

---

## 🧠 Alur Aplikasi

1. **Autentikasi:**
   - Pengguna login terlebih dahulu.
   - Setelah login, diarahkan ke halaman dashboard.

2. **Manajemen Catatan:**
   - Membuat catatan pribadi.
   - Catatan dapat dibagikan ke pengguna tertentu atau dibuat publik.

3. **Komentar:**
   - Pengguna yang memiliki akses dapat berkomentar.
   - Komentar ditampilkan pada halaman detail catatan.

---

## ⚙️ Plugin / Library yang Digunakan

| Plugin / Library            | Fungsi Utama                            |
|----------------------------|-----------------------------------------|
| `@inertiajs/inertia`       | Penghubung SPA Laravel ⇄ Vue            |
| `@inertiajs/vue3`          | Adaptor Inertia untuk Vue 3             |
| `ziggy-js`                 | Mengakses route Laravel dari frontend   |
| `tailwindcss`              | Utility CSS untuk styling               |
| `vue` (v3)                 | Framework frontend reaktif              |
| `laravel/breeze` (opsional)| Starter kit auth + Inertia              |
| Vue Transition             | Animasi transisi elemen                 |

---

## 🗂️ Desain Database

### ✅ Tabel `users` – Menyimpan data pengguna

| Kolom       | Tipe Data | Keterangan      |
|-------------|-----------|-----------------|
| id          | UUID (PK) | Primary key     |
| name        | String    | Nama pengguna   |
| email       | String    | Email unik      |
| password    | String    | Password hashed |
| created_at  | Timestamp | Tanggal dibuat  |
| updated_at  | Timestamp | Tanggal diubah  |

### ✅ Tabel `notes` – Menyimpan catatan pengguna

| Kolom       | Tipe Data | Keterangan                          |
|-------------|-----------|-------------------------------------|
| id          | UUID (PK) | Primary key                         |
| title       | String    | Judul catatan                       |
| content     | Text      | Isi catatan                         |
| is_public   | Boolean   | Status publik / pribadi             |
| user_id     | UUID (FK) | Pemilik catatan (relasi ke `users`)|
| created_at  | Timestamp |                                     |
| updated_at  | Timestamp |                                     |

### ✅ Tabel `note_user_shares` – Catatan yang dibagikan ke pengguna lain

| Kolom       | Tipe Data | Keterangan                           |
|-------------|-----------|--------------------------------------|
| id          | UUID (PK) | Primary key                          |
| note_id     | UUID (FK) | Catatan yang dibagikan               |
| user_id     | UUID (FK) | Penerima catatan (relasi ke `users`)|
| created_at  | Timestamp |                                      |
| updated_at  | Timestamp |                                      |

### ✅ Tabel `comments` – Komentar pengguna pada catatan

| Kolom       | Tipe Data | Keterangan               |
|-------------|-----------|--------------------------|
| id          | UUID (PK) | Primary key              |
| content     | Text      | Isi komentar             |
| note_id     | UUID (FK) | Catatan yang dikomentari |
| user_id     | UUID (FK) | Pengguna yang komentar   |
| created_at  | Timestamp |                          |
| updated_at  | Timestamp |                          |

---

## 🔗 Relasi Antar Tabel

- `users` ⇄ `notes`: One to Many  
- `users` ⇄ `comments`: One to Many  
- `notes` ⇄ `comments`: One to Many  
- `notes` ⇄ `note_user_shares`: One to Many  
- `users` ⇄ `note_user_shares`: One to Many  

---

## ⚙️ Cara Menjalankan Proyek

### ✅ 1. Jalankan Manual via CLI (Tanpa Docker)

#### 📥 Clone Repo & Install Dependensi

```bash
git clone <repo-url>
cd note-app
composer install
npm install
```

#### ⚙️ Setup `.env` & Generate App Key

```bash
cp .env.example .env
php artisan key:generate
```

#### 🗃️ Setup Database PostgreSQL

- Buat database baru (misalnya `note_db`)
- Ubah file `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=note_db
DB_USERNAME=postgres
DB_PASSWORD=yourpassword
```

#### 🧱 Jalankan Migrasi & Seeder

```bash
php artisan migrate --seed
```

#### 🧑‍💻 Jalankan Aplikasi

```bash
npm run dev
php artisan serve
```

Akses aplikasi di: [http://localhost:8000](http://localhost:8000)

---

### 🐳 2. Jalankan via Docker

#### 🔧 Build & Start Container

```bash
docker-compose up -d --build
```

#### 📦 Masuk ke Container

```bash
docker exec -it note-app-php bash
composer install
php artisan migrate --seed
```

- Web: [http://localhost:8000](http://localhost:8000)  
- DB: `localhost:5432` (user: `postgres`, password: `postgres`)

---

## 🔐 Akun Dummy Login

| Email / Username            | Password  |
|----------------------------|-----------|
| (lihat database hasil seeder) | `password` |

---

## 📄 Lisensi

MIT – Bebas digunakan dan dikembangkan untuk keperluan apa pun.

---

## ✍️ Dibuat Oleh

**Lalan** – dibuat sebagai latihan praktis membangun aplikasi Laravel + Inertia.
```