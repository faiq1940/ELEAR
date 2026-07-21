-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Jul 2026 pada 00.42
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elear`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `assignments`
--

CREATE TABLE `assignments` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `deadline` datetime NOT NULL,
  `status` enum('open','closed') NOT NULL DEFAULT 'open',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `assignments`
--

INSERT INTO `assignments` (`id`, `course_id`, `judul`, `deskripsi`, `deadline`, `status`, `created_at`) VALUES
(1, 1, 'Tugas 1 — Buat Halaman HTML Sederhana', 'Buat halaman HTML minimal 3 halaman dengan navigasi antar halaman.', '2026-07-27 05:40:41', 'open', '2026-07-20 05:40:41'),
(2, 1, 'Tugas 2 — Form & Validasi JavaScript', 'Buat form pendaftaran dengan validasi menggunakan JavaScript murni.', '2026-08-03 05:40:41', 'open', '2026-07-20 05:40:41'),
(3, 2, 'Tugas 1 — ERD Sistem Perpustakaan', 'Rancang ERD untuk sistem perpustakaan dengan minimal 6 entitas.', '2026-07-19 05:40:41', 'closed', '2026-07-20 05:40:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `dosen_id` int(11) NOT NULL,
  `kode_mk` varchar(20) NOT NULL,
  `nama_mk` varchar(200) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `courses`
--

INSERT INTO `courses` (`id`, `dosen_id`, `kode_mk`, `nama_mk`, `deskripsi`, `created_at`) VALUES
(1, 1, 'IF301', 'Pemrograman Web', 'Mempelajari dasar-dasar pengembangan web frontend dan backend.', '2026-07-20 05:40:41'),
(2, 1, 'IF401', 'Basis Data Lanjut', 'Desain dan optimasi database relasional dan non-relasional.', '2026-07-20 05:40:41'),
(3, 2, 'IF302', 'Rekayasa Perangkat Lunak', 'Metodologi pengembangan perangkat lunak dan manajemen proyek.', '2026-07-20 05:40:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `mahasiswa_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `approved_by` int(11) DEFAULT NULL,
  `requested_at` datetime NOT NULL DEFAULT current_timestamp(),
  `decided_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `enrollments`
--

INSERT INTO `enrollments` (`id`, `mahasiswa_id`, `course_id`, `status`, `approved_by`, `requested_at`, `decided_at`) VALUES
(1, 3, 1, 'pending', NULL, '2026-07-20 05:40:41', NULL),
(2, 4, 1, 'approved', 1, '2026-07-20 05:40:41', '2026-07-20 05:40:41'),
(3, 5, 1, 'rejected', 1, '2026-07-20 05:40:41', '2026-07-20 05:40:41'),
(4, 4, 3, 'approved', 2, '2026-07-20 05:40:41', '2026-07-20 05:40:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `uploaded_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `materials`
--

INSERT INTO `materials` (`id`, `course_id`, `judul`, `file_path`, `uploaded_at`) VALUES
(1, 1, 'Pengantar HTML & CSS', 'uploads/materi/if301_modul1.pdf', '2026-07-20 05:40:41'),
(2, 1, 'JavaScript Dasar', 'uploads/materi/if301_modul2.pdf', '2026-07-20 05:40:41'),
(3, 2, 'Normalisasi Database', 'uploads/materi/if401_modul1.pdf', '2026-07-20 05:40:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `tipe` enum('enrollment','materi','tugas','penilaian','reminder') NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `judul`, `pesan`, `tipe`, `is_read`, `created_at`) VALUES
(1, 4, 'Pendaftaran Kelas Disetujui', 'Selamat! Pendaftaran Anda untuk mata kuliah Pemrograman Web (IF301) telah disetujui.', 'enrollment', 0, '2026-07-20 05:40:42'),
(2, 5, 'Pendaftaran Kelas Ditolak', 'Maaf, pendaftaran Anda untuk mata kuliah Pemrograman Web (IF301) tidak dapat disetujui.', 'enrollment', 0, '2026-07-20 05:40:42'),
(3, 1, 'Pendaftaran Kelas Baru', 'Andi Pratama mengajukan pendaftaran untuk mata kuliah Pemrograman Web (IF301).', 'enrollment', 0, '2026-07-20 05:40:42'),
(4, 4, 'Materi Baru Tersedia', 'Dosen telah mengunggah materi baru \"JavaScript Dasar\" untuk mata kuliah Pemrograman Web (IF301).', 'materi', 0, '2026-07-20 05:40:42'),
(5, 4, 'Reminder: Deadline Tugas Besok', 'Tugas 1 — Buat Halaman HTML Sederhana pada mata kuliah Pemrograman Web akan ditutup besok. Segera kumpulkan!', 'reminder', 0, '2026-07-20 05:40:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `submissions`
--

CREATE TABLE `submissions` (
  `id` int(11) NOT NULL,
  `assignment_id` int(11) NOT NULL,
  `mahasiswa_id` int(11) NOT NULL,
  `file_path` varchar(500) DEFAULT NULL,
  `submitted_at` datetime DEFAULT NULL,
  `status` enum('submitted','late','not_submitted','graded') NOT NULL DEFAULT 'submitted',
  `nilai` float DEFAULT NULL,
  `feedback` text DEFAULT NULL,
  `graded_by` int(11) DEFAULT NULL,
  `graded_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `submissions`
--

INSERT INTO `submissions` (`id`, `assignment_id`, `mahasiswa_id`, `file_path`, `submitted_at`, `status`, `nilai`, `feedback`, `graded_by`, `graded_at`) VALUES
(1, 1, 4, 'uploads/submissions/dewi_tugas1_if301.zip', '2026-07-20 05:40:42', 'submitted', NULL, NULL, NULL, NULL),
(2, 3, 4, NULL, NULL, 'not_submitted', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('dosen','mahasiswa') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Dr. Budi Santoso', 'budi.santoso@kampus.ac.id', '$2b$12$hashedPasswordDosen1', 'dosen', '2026-07-20 05:40:41'),
(2, 'Ir. Siti Rahayu', 'siti.rahayu@kampus.ac.id', '$2b$12$hashedPasswordDosen2', 'dosen', '2026-07-20 05:40:41'),
(3, 'Andi Pratama', 'andi.pratama@mahasiswa.ac.id', '$2b$12$hashedPasswordMhs1', 'mahasiswa', '2026-07-20 05:40:41'),
(4, 'Dewi Lestari', 'dewi.lestari@mahasiswa.ac.id', '$2b$12$hashedPasswordMhs2', 'mahasiswa', '2026-07-20 05:40:41'),
(5, 'Raka Wijaya', 'raka.wijaya@mahasiswa.ac.id', '$2b$12$hashedPasswordMhs3', 'mahasiswa', '2026-07-20 05:40:41');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_assignments_course` (`course_id`),
  ADD KEY `idx_assignments_status` (`status`),
  ADD KEY `idx_assignments_deadline` (`deadline`);

--
-- Indeks untuk tabel `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_mk` (`kode_mk`),
  ADD KEY `idx_courses_dosen` (`dosen_id`);

--
-- Indeks untuk tabel `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_enrollment` (`mahasiswa_id`,`course_id`),
  ADD KEY `fk_enrollments_approver` (`approved_by`),
  ADD KEY `idx_enrollments_course` (`course_id`),
  ADD KEY `idx_enrollments_status` (`status`);

--
-- Indeks untuk tabel `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_materials_course` (`course_id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_notifications_user` (`user_id`),
  ADD KEY `idx_notifications_is_read` (`is_read`);

--
-- Indeks untuk tabel `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_submission` (`assignment_id`,`mahasiswa_id`),
  ADD KEY `fk_submissions_grader` (`graded_by`),
  ADD KEY `idx_submissions_assignment` (`assignment_id`),
  ADD KEY `idx_submissions_mahasiswa` (`mahasiswa_id`),
  ADD KEY `idx_submissions_status` (`status`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `assignments`
--
ALTER TABLE `assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `submissions`
--
ALTER TABLE `submissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `fk_assignments_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `fk_courses_dosen` FOREIGN KEY (`dosen_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `fk_enrollments_approver` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_enrollments_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_enrollments_mahasiswa` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `materials`
--
ALTER TABLE `materials`
  ADD CONSTRAINT `fk_materials_course` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `fk_submissions_assignment` FOREIGN KEY (`assignment_id`) REFERENCES `assignments` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_submissions_grader` FOREIGN KEY (`graded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_submissions_mahasiswa` FOREIGN KEY (`mahasiswa_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
