```
# 📝 Simple Note-Taking App

Aplikasi web sederhana untuk mencatat, berbagi catatan ke pengguna lain atau publik, dan memberi komentar. Dibangun menggunakan Laravel 8, PostgreSQL, Inertia.js (Vue 3), dan Tailwind CSS.

---

## 🚀 Fitur Utama

- 🔐 Login/Register user
- 🗒 Membuat catatan pribadi
- 🔗 Share catatan ke user tertentu atau ke publik
- 💬 Komentar pada catatan
- 🌙 Dark mode toggle

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

4. **Dark Mode:**
   - Tersedia toggle mode gelap/terang yang disimpan di `localStorage`.

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