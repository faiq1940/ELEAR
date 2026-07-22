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

# Desain Sistem — Web E-Learning Sederhana (Akses Dosen & Mahasiswa)

## 1. Ringkasan Konsep

| Elemen wajib tugas | Implementasi di sistem ini |
|---|---|
| Minimal 2 role | **Dosen** dan **Mahasiswa** |
| Approval/verifikasi | Mahasiswa mengajukan pendaftaran kelas → **Dosen approve/reject** |
| File upload | Dosen upload **materi**, Mahasiswa upload **file tugas** |
| Notifikasi otomatis | Notifikasi in-app/email saat: status pendaftaran berubah, materi baru, tugas dinilai |
| Proses terjadwal (cron) | **Reminder deadline tugas (H-1)** dan **auto-close pengumpulan tugas** yang lewat deadline |

Flowchart alur pendaftaran kelas (login → ajukan → review dosen → approve/reject → notifikasi) digunakan sebagai dasar **Activity Diagram** pada dokumentasi UML.

---

## 2. Struktur Database (ERD)

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

### Catatan tabel
- **ENROLLMENTS** adalah tabel kunci untuk proses approval (Bagian 2 tugas): status `pending` dibuat mahasiswa, diubah dosen menjadi `approved`/`rejected`.
- **SUBMISSIONS.status** diisi otomatis oleh scheduled job: jika sudah lewat deadline dan belum ada file → `not_submitted`; jika submit setelah deadline → `late`.
- **NOTIFICATIONS** dipicu oleh event (enrollment disetujui/ditolak, materi baru, tugas dinilai) dan oleh cron job (reminder deadline).

---

## 3. Menu & Fitur per Role

### 3.1 Akses Dosen

| Menu | Fitur |
|---|---|
| Dashboard | Ringkasan: jumlah kelas diampu, mahasiswa terdaftar, tugas belum dinilai |
| Kelola Mata Kuliah | Tambah/edit/hapus mata kuliah/kelas yang diampu |
| Persetujuan Pendaftaran | Lihat daftar mahasiswa yang mengajukan (pending) → **approve/reject** |
| Materi Kuliah | Upload, edit, hapus file materi per kelas |
| Kelola Tugas | Buat tugas baru, atur deadline, lihat status (open/closed) |
| Penilaian | Lihat daftar submission per tugas, beri **nilai & feedback** |
| Notifikasi | Daftar notifikasi (pendaftaran baru masuk, dsb.) |
| Profil | Edit profil, ganti password |

### 3.2 Akses Mahasiswa

| Menu | Fitur |
|---|---|
| Dashboard | Ringkasan: kelas diikuti, tugas mendatang & deadline terdekat |
| Cari & Daftar Kelas | Cari mata kuliah, ajukan pendaftaran (status pending → approved/rejected) |
| Kelas Saya | Daftar kelas yang sudah disetujui |
| Materi Kuliah | Lihat/unduh materi per kelas yang diikuti |
| Tugas | Lihat daftar tugas, **upload file jawaban** sebelum deadline |
| Nilai | Lihat nilai & feedback dari dosen per tugas |
| Notifikasi | Status pendaftaran, materi baru, tugas dinilai, reminder deadline |
| Profil | Edit profil, ganti password |

---

## 4. Proses Terjadwal (Scheduled Job / Cron)

| Job | Jadwal | Aksi |
|---|---|---|
| Reminder deadline tugas | Setiap hari (cek H-1 sebelum deadline) | Kirim notifikasi ke mahasiswa yang belum submit |
| Auto-close tugas | Setiap hari / tiap jam | Ubah `assignments.status` jadi `closed` bila lewat deadline; tandai submission mahasiswa yang belum mengumpulkan sebagai `not_submitted` |

Ini memenuhi syarat "minimal satu proses terjadwal/otomatis di background" pada Bagian 2 dokumen tugas.

---

## 5. Use Case Diagram

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
        UC9(["Kelola Notifikasi"])
        UC10(["Edit Profil"])
    end

    Dosen --- UC1
    Dosen --- UC2
    Dosen --- UC3
    Dosen --- UC4
    Dosen --- UC9
    Dosen --- UC10

    Mahasiswa --- UC5
    Mahasiswa --- UC6
    Mahasiswa --- UC7
    Mahasiswa --- UC8
    Mahasiswa --- UC9
    Mahasiswa --- UC10
```

### Pemetaan aktor ke use case

| Aktor | Use case |
|---|---|
| Dosen | Approve/Reject Pendaftaran, Kelola Mata Kuliah, Upload Materi, Kelola Tugas & Beri Nilai |
| Mahasiswa | Cari & Daftar Kelas, Lihat/Unduh Materi, Upload File Tugas, Lihat Nilai & Feedback |
| Dosen & Mahasiswa (bersama) | Kelola Notifikasi, Edit Profil |

### Catatan
- Use case pada diagram ini diturunkan langsung dari tabel menu & fitur per role pada Bagian 3.
- **Kelola Notifikasi** dan **Edit Profil** dipakai bersama kedua role karena keduanya muncul di menu Dosen maupun Mahasiswa.
- Approve/Reject Pendaftaran berelasi `<<include>>` ke pengiriman notifikasi (lihat Bagian 4 dan tabel NOTIFICATIONS pada Bagian 2).

---

## 6. Class Diagram

```mermaid
classDiagram
    class Users {
        +int id
        +string nama
        +string email
        +string password
        +string role
        +login()
        +editProfil()
    }
    class Courses {
        +int id
        +int dosenId
        +string kodeMK
        +string namaMK
        +string deskripsi
        +tambahMateri()
        +buatTugas()
    }
    class Enrollments {
        +int id
        +int mahasiswaId
        +int courseId
        +string status
        +approve()
        +reject()
    }
    class Materials {
        +int id
        +int courseId
        +string judul
        +string filePath
        +upload()
    }
    class Assignments {
        +int id
        +int courseId
        +string judul
        +datetime deadline
        +string status
        +buatTugas()
        +tutupOtomatis()
    }
    class Submissions {
        +int id
        +int assignmentId
        +int mahasiswaId
        +string filePath
        +float nilai
        +string feedback
        +uploadFile()
        +beriNilai()
    }
    class Notifications {
        +int id
        +int userId
        +string tipe
        +boolean isRead
        +kirim()
    }

    Users "1" --> "0..*" Courses : mengajar
    Users "1" --> "0..*" Enrollments : mendaftar
    Users "1" --> "0..*" Submissions : mengumpulkan
    Users "1" --> "0..*" Notifications : menerima
    Courses "1" --> "0..*" Enrollments : memiliki
    Courses "1" --> "0..*" Materials : memiliki
    Courses "1" --> "0..*" Assignments : memiliki
    Assignments "1" --> "0..*" Submissions : memiliki
```

### Catatan kelas
- Struktur atribut setiap class mengikuti kolom pada tabel ERD di Bagian 2 secara langsung.
- Method ditambahkan berdasarkan fitur pada tabel menu Bagian 3, misalnya `approve()`/`reject()` di `Enrollments` (menu Persetujuan Pendaftaran), dan `tutupOtomatis()` di `Assignments` yang mewakili scheduled job auto-close pada Bagian 4.
- Multiplicity `"1" --> "0..*"` menunjukkan relasi satu-ke-banyak yang sama seperti pada notasi ERD (`||--o{`), hanya direpresentasikan dalam bentuk class diagram (perilaku + struktur), bukan sekadar struktur data.

---

---

# 7. Sequence Diagram

## 7.1 Sequence Diagram – Proses Pendaftaran Kelas

```mermaid
sequenceDiagram
    autonumber

    actor Mahasiswa
    participant Web as Web E-Learning
    participant Enrollment as Enrollment Controller
    participant DB as Database
    actor Dosen
    participant Notification as Notification Service

    Mahasiswa->>Web: Login
    Web->>DB: Validasi akun
    DB-->>Web: Login berhasil

    Mahasiswa->>Web: Cari Mata Kuliah
    Mahasiswa->>Enrollment: Ajukan Pendaftaran

    Enrollment->>DB: Simpan Enrollment (Pending)
    DB-->>Enrollment: Data berhasil disimpan

    Enrollment-->>Dosen: Menampilkan daftar pendaftaran

    Dosen->>Enrollment: Approve / Reject

    Enrollment->>DB: Update Status Enrollment
    DB-->>Enrollment: Status berhasil diperbarui

    Enrollment->>Notification: Kirim Notifikasi

    Notification-->>Mahasiswa: Status Pendaftaran
```

### Penjelasan

Sequence Diagram di atas menggambarkan proses mahasiswa melakukan pendaftaran mata kuliah. Setelah data disimpan dengan status **Pending**, dosen melakukan proses **Approve** atau **Reject**, kemudian sistem memperbarui status pendaftaran dan mengirimkan notifikasi kepada mahasiswa.

---

## 7.2 Sequence Diagram – Upload dan Penilaian Tugas

```mermaid
sequenceDiagram
    autonumber

    actor Mahasiswa
    participant Web as Web E-Learning
    participant Submission as Submission Controller
    participant DB as Database
    actor Dosen
    participant Notification as Notification Service

    Mahasiswa->>Web: Login
    Web->>DB: Validasi akun
    DB-->>Web: Login berhasil

    Mahasiswa->>Submission: Upload File Tugas

    Submission->>DB: Simpan File Submission
    DB-->>Submission: Upload Berhasil

    Dosen->>Submission: Lihat Daftar Submission

    Submission->>DB: Ambil Data Submission
    DB-->>Submission: Data Submission

    Dosen->>Submission: Input Nilai dan Feedback

    Submission->>DB: Simpan Nilai
    DB-->>Submission: Nilai Berhasil Disimpan

    Submission->>Notification: Kirim Notifikasi

    Notification-->>Mahasiswa: Nilai dan Feedback tersedia
```

### Penjelasan

Sequence Diagram ini menjelaskan proses pengumpulan tugas oleh mahasiswa, proses penilaian oleh dosen, penyimpanan nilai ke database, serta pengiriman notifikasi kepada mahasiswa.

---

# 8. Component Diagram

```mermaid
graph TB

subgraph User
A[Mahasiswa]
B[Dosen]
end

subgraph Presentation Layer
C[Web Browser]
D[Dashboard]
end

subgraph Controller Layer
E[Authentication Controller]
F[Course Controller]
G[Enrollment Controller]
H[Material Controller]
I[Assignment Controller]
J[Submission Controller]
K[Notification Controller]
end

subgraph Service Layer
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

subgraph Cloud Storage
AA[(Object Storage)]
end

A --> C
B --> C

C --> D

D --> E
D --> F
D --> G
D --> H
D --> I
D --> J
D --> K

E --> L
F --> M
G --> N
H --> O
I --> P
J --> Q
K --> R

L --> T
M --> U
N --> V
O --> W
P --> X
Q --> Y
R --> Z

O --> AA
Q --> AA

S --> X
S --> Y
S --> Z
```

### Penjelasan

Component Diagram menunjukkan arsitektur sistem Web E-Learning yang terdiri dari **Presentation Layer**, **Controller Layer**, **Service Layer**, **Database**, serta **Cloud Storage**. Seluruh proses bisnis dijalankan melalui controller dan service sebelum mengakses database maupun penyimpanan file.

---

# 9. Pemetaan ke Kriteria Tugas

Dokumen desain Sistem Web E-Learning ini telah memenuhi kebutuhan tugas dengan menyediakan berbagai diagram UML yang saling terintegrasi, yaitu:

- Entity Relationship Diagram (ERD)
- Use Case Diagram
- Class Diagram
- Sequence Diagram Proses Pendaftaran Kelas
- Sequence Diagram Upload dan Penilaian Tugas
- Component Diagram
- Flowchart yang menjadi dasar Activity Diagram

Sistem juga telah memenuhi persyaratan utama, yaitu:

- Minimal dua role (Dosen dan Mahasiswa)
- Approval pendaftaran kelas
- Upload materi kuliah
- Upload file tugas
- Penilaian tugas beserta feedback
- Notifikasi otomatis
- Scheduled Job (Reminder Deadline dan Auto Close Tugas)
- Penyimpanan file menggunakan Cloud Storage (Object Storage)



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
