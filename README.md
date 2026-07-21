# ELEAR
Sistem Informasi Elearning 
# Desain Sistem — Web E-Learning Sederhana (Akses Dosen & Mahasiswa)

## 1. Ringkasan Konsep

| Elemen wajib tugas | Implementasi di sistem ini |
|---|---|
| Minimal 2 role | **Dosen** dan **Mahasiswa** |
| Approval/verifikasi | Mahasiswa mengajukan pendaftaran kelas → **Dosen approve/reject** |
| File upload | Dosen upload **materi**, Mahasiswa upload **file tugas** |
| Notifikasi otomatis | Notifikasi in-app/email saat: status pendaftaran berubah, materi baru, tugas dinilai |
| Proses terjadwal (cron) | **Reminder deadline tugas (H-1)** dan **auto-close pengumpulan tugas** yang lewat deadline |

Flowchart alur pendaftaran kelas (login → ajukan → review dosen → approve/reject → notifikasi) sudah ditampilkan sebagai diagram di atas — gunakan sebagai dasar **Activity Diagram** pada dokumentasi UML.

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

## 5. Pemetaan ke Kriteria Tugas



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

## 7. Pemetaan ke Kriteria Tugas

- **7 diagram UML**: Use Case Diagram (Bagian 5) dan Class Diagram (Bagian 6) sudah tersedia langsung di dokumen ini; ERD (Bagian 2) jadi diagram nomor 7 (Data Flow/ERD); flowchart pendaftaran kelas jadi dasar Activity Diagram; Sequence diagram utama = alur pendaftaran kelas (approval); Sequence diagram kedua = alur submit & penilaian tugas; Component diagram = lapisan Controller → Service → Model mengikuti struktur tabel pada Bagian 2.
- **Konsep cloud yang bisa dipilih (min. 1)**: simpan `file_path` materi & tugas di **object storage** (bukan disk lokal), atau gunakan **managed database** untuk tabel-tabel di atas, atau **CI/CD** otomatis saat push ke branch utama.

- **7 diagram UML**: gunakan flowchart di atas sebagai dasar Activity Diagram; ERD di atas langsung jadi diagram nomor 7 (Data Flow/ERD); Use Case dari tabel menu Bagian 3; Sequence diagram utama = alur pendaftaran kelas (approval); Sequence diagram kedua = alur submit & penilaian tugas; Class diagram dari struktur tabel; Component diagram = lapisan Controller → Service → Model mengikuti tabel di atas.







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
- **Konsep cloud yang bisa dipilih (min. 1)**: simpan `file_path` materi & tugas di **object storage** (bukan disk lokal), atau gunakan **managed database** untuk tabel-tabel di atas, atau **CI/CD** otomatis saat push ke branch utama.


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
