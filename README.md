```
# 📝 Simple Note-Taking App

Aplikasi web sederhana untuk mencatat, berbagi catatan ke pengguna lain atau publik, dan memberi komentar. Dibangun menggunakan Laravel 8, PostgreSQL, Inertia.js (Vue 3), dan Tailwind CSS.

---

## 🚀 Fitur Utama

- 🔐 Login/Register user
- 🗒 Membuat catatan pribadi
- 🔗 Share catatan ke user tertentu atau ke publik
- 💬 Komentar pada catatan

---

## 🧠 Alur Aplikasi

1. **Autentikasi:**
   - User login terlebih dahulu.
   - Setelah login, user diarahkan ke dashboard.

2. **Manajemen Catatan:**
   - User dapat membuat catatan pribadi.
   - Catatan dapat dibagikan ke user tertentu (via share).
   - Atau dapat diset sebagai publik.

3. **Komentar:**
   - Pengguna lain (yang mendapatkan akses) dapat berkomentar.
   - Semua komentar ditampilkan di halaman detail catatan.

---

## ⚙️ Plugin / Library yang di gunakan
| Plugin / Library            | Fungsi Utama                      |
| --------------------------- | --------------------------------- |
| `@inertiajs/inertia`        | SPA bridge Laravel ⇄ Vue          |
| `@inertiajs/vue3`           | Inertia adaptor untuk Vue 3       |
| `ziggy-js`                  | Gunakan Laravel route di frontend |
| `tailwindcss`               | Utility CSS styling               |
| `vue` (v3)                  | Reactive frontend framework       |
| `laravel/breeze` (opsional) | Auth dan Inertia starter kit      |
| Vue Transition              | Animasi show/hide elemen          |

---

## 🗂️ Database Design
### ✅ 1. Table users (Menyimpan data pengguna aplikasi.)
| Kolom       | Tipe Data | Keterangan      |
| ----------- | --------- | --------------- |
| id          | UUID (PK) | Primary key     |
| name        | String    | Nama user       |
| email       | String    | Email unik      |
| password    | String    | Password hashed |
| created\_at | Timestamp | Waktu dibuat    |
| updated\_at | Timestamp | Waktu diubah    |

### ✅ 2. Table notes (Menyimpan catatan yang dibuat oleh user.)
| Kolom       | Tipe Data | Keterangan                          |
| ----------- | --------- | ----------------------------------- |
| id          | UUID (PK) | Primary key                         |
| title       | String    | Judul catatan                       |
| content     | Text      | Isi catatan                         |
| is\_public  | Boolean   | Status publik / pribadi             |
| user\_id    | UUID (FK) | Pemilik catatan (relasi ke `users`) |
| created\_at | Timestamp |                                     |
| updated\_at | Timestamp |                                     |

### ✅ 3. Table note_user_shares (Menyimpan data catatan yang dibagikan ke user lain.)
| Kolom       | Tipe Data | Keterangan                           |
| ----------- | --------- | ------------------------------------ |
| id          | UUID (PK) | Primary key                          |
| note\_id    | UUID (FK) | Catatan yang dibagikan               |
| user\_id    | UUID (FK) | Penerima catatan (relasi ke `users`) |
| created\_at | Timestamp |                                      |
| updated\_at | Timestamp |                                      |

### ✅ 4. Table comments (Menyimpan komentar user pada catatan.)
| Kolom       | Tipe Data | Keterangan               |
| ----------- | --------- | ------------------------ |
| id          | UUID (PK) | Primary key              |
| content     | Text      | Isi komentar             |
| note\_id    | UUID (FK) | Catatan yang dikomentari |
| user\_id    | UUID (FK) | User yang mengomentari   |
| created\_at | Timestamp |                          |
| updated\_at | Timestamp |                          |


##🔑 Relasi Antartabel
users ⇄ notes: One to Many

users ⇄ comments: One to Many

notes ⇄ comments: One to Many

notes ⇄ note_user_shares: One to Many

users ⇄ note_user_shares: One to Many

---

## ⚙️ Cara Menjalankan Proyek

### ✅ 1. Manual via CLI (tanpa Docker)

#### 📥 Clone Repo & Install Dependency

```bash
git clone <repo-url>
cd note-app
composer install
npm install
```

#### ⚙️ Setup .env & Key

```bash
cp .env.example .env
php artisan key:generate
```

#### 🗃️ Setup Database PostgreSQL

- Buat database baru, misalnya `note_db`
- Update di `.env`:

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=note_db
DB_USERNAME=postgres
DB_PASSWORD=yourpassword
```

#### 🔧 Jalankan Migrasi & Seeder

```bash
php artisan migrate --seed
```

#### 🔨 Build Frontend & Jalankan

```bash
npm run dev
php artisan serve
```

- Akses: http://localhost:8000

---

### 🐳 2. Jalankan via Docker

#### 🐋 Build & Start

```bash
docker-compose up -d --build
```

#### 📦 Akses Container

```bash
docker exec -it note-app-php bash
composer install
php artisan migrate --seed
```

- Web: http://localhost:8000  
- DB: diakses di `localhost:5432` (user: `postgres`, pass: `postgres`)

---

## 🧪 Akun Dummy Login

| Email | Password |
|-------|----------|
| username: cek di db hasil generate seed | password: password |

---

## 📄 Lisensi

MIT – bebas digunakan dan dikembangkan.

---

## ✍️ Dibuat oleh

Lalan – dibuat untuk pembelajaran aplikasi Laravel + Inertia secara praktis.
```

---