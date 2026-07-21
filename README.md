<p align="center">
<img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="280" alt="Laravel Logo">
</p>

<h1 align="center">ELEAR — Sistem Informasi E-Learning</h1>

<p align="center">
Platform pembelajaran daring sederhana dengan dua peran (Dosen &amp; Mahasiswa), lengkap dengan alur persetujuan kelas, upload materi &amp; tugas, penilaian, notifikasi otomatis, dan proses terjadwal (cron).
</p>

<p align="center">
<img src="https://img.shields.io/badge/Laravel-FF2D20?style=flat&logo=laravel&logoColor=white" alt="Laravel">
<img src="https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white" alt="PHP">
<img src="https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white" alt="MySQL">
<img src="https://img.shields.io/badge/status-development-yellow" alt="Status">
</p>

---

## Daftar Isi

- [Tentang Proyek](#tentang-proyek)
- [Fitur Utama](#fitur-utama)
- [Peran Pengguna](#peran-pengguna)
- [Struktur Database (ERD)](#struktur-database-erd)
- [Arsitektur Sistem](#arsitektur-sistem)
- [Proses Terjadwal (Scheduled Job)](#proses-terjadwal-scheduled-job)
- [Teknologi yang Digunakan](#teknologi-yang-digunakan)
- [Instalasi & Menjalankan Proyek](#instalasi--menjalankan-proyek)
- [Menjalankan Scheduler / Cron](#menjalankan-scheduler--cron)
- [Struktur Direktori](#struktur-direktori)
- [Kontribusi](#kontribusi)
- [Lisensi](#lisensi)

---

## Tentang Proyek

**ELEAR** adalah sistem informasi e-learning sederhana yang dibangun menggunakan **Laravel**. Sistem ini dirancang untuk mendukung interaksi antara **Dosen** dan **Mahasiswa** dalam sebuah kelas daring, mulai dari pendaftaran kelas, distribusi materi, pengumpulan tugas, hingga penilaian — dengan notifikasi dan proses otomatis di background.

| Kebutuhan | Implementasi |
|---|---|
| Minimal 2 role | **Dosen** dan **Mahasiswa** |
| Approval / verifikasi | Mahasiswa mengajukan pendaftaran kelas → **Dosen approve/reject** |
| File upload | Dosen upload **materi**, Mahasiswa upload **file tugas** |
| Notifikasi otomatis | Perubahan status pendaftaran, materi baru, tugas dinilai |
| Proses terjadwal (cron) | Reminder deadline tugas (H-1) & auto-close pengumpulan tugas |
| Cloud | Penyimpanan file materi/tugas via **Object Storage** |

---

## Fitur Utama

### ‍ Akses Dosen
- Dashboard ringkasan kelas, mahasiswa, dan tugas yang belum dinilai
- Kelola mata kuliah/kelas (tambah, edit, hapus)
- Approve/reject pendaftaran mahasiswa
- Upload dan kelola materi kuliah
- Buat & kelola tugas beserta deadline
- Penilaian tugas dan pemberian feedback
- Notifikasi & manajemen profil

### ‍ Akses Mahasiswa
- Dashboard ringkasan kelas & deadline terdekat
- Cari dan mendaftar ke kelas (menunggu approval dosen)
- Lihat kelas yang sudah disetujui
- Lihat/unduh materi kuliah
- Upload file jawaban tugas sebelum deadline
- Lihat nilai & feedback dari dosen
- Notifikasi & manajemen profil

---

## ‍‍ Peran Pengguna

```mermaid
graph LR
Dosen((Dosen))
Mahasiswa((Mahasiswa))

subgraph SISTEM["Sistem E-Learning"]
UC1(["Approve/Reject Pendaftaran"])
UC2(["Kelola Mata Kuliah"])
UC3(["Upload Materi"])
UC4(["Kelola Tugas & Beri Nilai"])
UC5(["Cari & Daftar Kelas"])
UC6(["Lihat/Unduh Materi"])
UC7(["Upload File Tugas"])
UC8(["Lihat Nilai & Feedback"])
end

Dosen --- UC1
Dosen --- UC2
Dosen --- UC3
Dosen --- UC4
Mahasiswa --- UC5
Mahasiswa --- UC6
Mahasiswa --- UC7
Mahasiswa --- UC8
```

---

## ️ Struktur Database (ERD)

```mermaid
erDiagram
USERS ||--o{ COURSES : "mengajar (jika dosen)"
USERS ||--o{ ENROLLMENTS : "mendaftar (jika mahasiswa)"
USERS ||--o{ SUBMISSIONS : "mengumpulkan"
USERS ||--o{ NOTIFICATIONS : "menerima"
COURSES ||--o{ ENROLLMENTS : memiliki
COURSES ||--o{ MATERIALS : memiliki
COURSES ||--o{ ASSIGNMENTS : memiliki
ASSIGNMENTS ||--o{ SUBMISSIONS : memiliki

USERS {
int id PK
string nama
string email
string password
enum role "dosen, mahasiswa"
datetime created_at
}
COURSES {
int id PK
int dosen_id FK
string kode_mk
string nama_mk
text deskripsi
datetime created_at
}
ENROLLMENTS {
int id PK
int mahasiswa_id FK
int course_id FK
enum status "pending, approved, rejected"
int approved_by FK
datetime requested_at
datetime decided_at
}
MATERIALS {
int id PK
int course_id FK
string judul
string file_path
datetime uploaded_at
}
ASSIGNMENTS {
int id PK
int course_id FK
string judul
text deskripsi
datetime deadline
enum status "open, closed"
datetime created_at
}
SUBMISSIONS {
int id PK
int assignment_id FK
int mahasiswa_id FK
string file_path
datetime submitted_at
enum status "submitted, late, not_submitted, graded"
float nilai
text feedback
int graded_by FK
datetime graded_at
}
NOTIFICATIONS {
int id PK
int user_id FK
string judul
text pesan
enum tipe "enrollment, materi, tugas, penilaian, reminder"
boolean is_read
datetime created_at
}
```

---

## ️ Arsitektur Sistem

```mermaid
graph TB
subgraph User
A[Mahasiswa]
B[Dosen]
end

subgraph "Presentation Layer"
C[Web Browser]
D[Dashboard]
end

subgraph "Controller Layer"
E[Authentication Controller]
F[Course Controller]
G[Enrollment Controller]
H[Material Controller]
I[Assignment Controller]
J[Submission Controller]
K[Notification Controller]
end

subgraph "Service Layer"
L[Authentication Service]
M[Course Service]
N[Enrollment Service]
O[Material Service]
P[Assignment Service]
Q[Submission Service]
R[Notification Service]
S[Scheduler Service]
end

subgraph Database
T[(Users)]
U[(Courses)]
V[(Enrollments)]
W[(Materials)]
X[(Assignments)]
Y[(Submissions)]
Z[(Notifications)]
end

subgraph "Cloud Storage"
AA[(Object Storage)]
end

A --> C
B --> C
C --> D
D --> E & F & G & H & I & J & K
E --> L --> T
F --> M --> U
G --> N --> V
H --> O --> W
I --> P --> X
J --> Q --> Y
K --> R --> Z
O --> AA
Q --> AA
S --> X
S --> Y
S --> Z
```

Sistem mengikuti pola **Controller → Service → Model**, dengan file materi dan tugas disimpan di **Object Storage** (cloud), bukan disk lokal.

---

##  Proses Terjadwal (Scheduled Job)

| Job | Jadwal | Aksi |
|---|---|---|
| Reminder deadline tugas | Setiap hari (H-1 sebelum deadline) | Kirim notifikasi ke mahasiswa yang belum submit |
| Auto-close tugas | Setiap hari/jam | Ubah status tugas jadi `closed` bila lewat deadline; tandai submission yang belum dikumpulkan sebagai `not_submitted` |

---

## ️ Teknologi yang Digunakan

- **Backend:** Laravel (PHP)
- **Database:** MySQL / MariaDB
- **Frontend:** Blade / Vite (sesuaikan dengan implementasi Anda)
- **Queue & Scheduler:** Laravel Task Scheduling (`php artisan schedule:run`)
- **Storage:** Laravel Filesystem (lokal / cloud object storage, mis. AWS S3)

---

## Instalasi & Menjalankan Proyek

### 1. Prasyarat

Pastikan sudah terinstal:
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL / MariaDB
- Git

### 2. Clone Repository

```bash
git clone https://github.com/username/elear.git
cd elear
```

### 3. Install Dependency

```bash
composer install
npm install
```

### 4. Konfigurasi Environment

Salin file environment lalu generate application key:

```bash
cp .env.example .env
php artisan key:generate
```

Buka file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=elear
DB_USERNAME=root
DB_PASSWORD=
```

Jika menggunakan cloud object storage (opsional), tambahkan juga kredensial storage (mis. S3) di `.env`.

### 5. Migrasi & Seeder Database

Buat database `elear` terlebih dahulu di MySQL, lalu jalankan:

```bash
php artisan migrate --seed
```

### 6. Buat Symbolic Link Storage

Agar file upload (materi/tugas) bisa diakses publik:

```bash
php artisan storage:link
```

### 7. Build Asset Frontend

```bash
npm run dev
```

Untuk build production:

```bash
npm run build
```

### 8. Jalankan Server Laravel

```bash
php artisan serve
```

Aplikasi dapat diakses melalui:

```
http://127.0.0.1:8000
```

---

## ⏱️ Menjalankan Scheduler / Cron

Fitur **reminder deadline** dan **auto-close tugas** berjalan melalui Laravel Task Scheduler. Saat pengembangan lokal, jalankan:

```bash
php artisan schedule:work
```

Untuk lingkungan production (server Linux), tambahkan cron job berikut (edit dengan `crontab -e`):

```bash
* * * * * cd /path-to-elear && php artisan schedule:run >> /dev/null 2>&1
```

Cron di atas akan memicu Laravel Scheduler setiap menit, yang kemudian menjalankan job sesuai jadwal masing-masing (harian untuk reminder & auto-close).

---

## Struktur Direktori (ringkas)

```
elear/
├── app/
│ ├── Http/Controllers/ # Authentication, Course, Enrollment, Material, Assignment, Submission, Notification
│ ├── Models/ # Users, Courses, Enrollments, Materials, Assignments, Submissions, Notifications
│ ├── Services/ # Business logic tiap modul
│ └── Console/Commands/ # Scheduled job: reminder & auto-close
├── database/
│ ├── migrations/
│ └── seeders/
├── resources/views/ # Blade templates
├── routes/
│ └── web.php
└── README.md
```

---

## Kontribusi

Kontribusi sangat terbuka! Silakan buat *pull request* atau buka *issue* untuk melaporkan bug maupun mengusulkan fitur baru.

1. Fork repository ini
2. Buat branch baru (`git checkout -b fitur-baru`)
3. Commit perubahan (`git commit -m 'Menambahkan fitur X'`)
4. Push ke branch (`git push origin fitur-baru`)
5. Buka Pull Request

---

## Lisensi

Proyek ini menggunakan framework [Laravel](https://laravel.com) yang berlisensi [MIT](https://opensource.org/licenses/MIT). Sesuaikan bagian ini dengan lisensi proyek ELEAR Anda sendiri.

---

<p align="center">Dibuat dengan ️ menggunakan Laravel</p>
