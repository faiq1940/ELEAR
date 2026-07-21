<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SMART · Dashboard Mahasiswa</title>
    <style>
        /* ── RESET & VARIABEL ── */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        :root {
            --bg-start: #eef4ff;
            --bg-end: #f9fbff;
            --sidebar-start: #0f172a;
            --sidebar-end: #1e3a8a;
            --primary: #2563eb;
            --primary-light: #3b7fd4;
            --primary-soft: #dbeafe;
            --success: #16a34a;
            --success-bg: #dcfce7;
            --warning: #f59e0b;
            --warning-bg: #fef3c7;
            --danger: #dc2626;
            --danger-bg: #fee2e2;
            --text: #1f2a44;
            --text-secondary: #64748b;
            --border: #e2e8f0;
            --shadow: 0 12px 35px rgba(15, 23, 42, 0.08);
            --radius: 20px;
            --radius-sm: 12px;
            --font: 'Inter', 'Segoe UI', Roboto, Arial, sans-serif;
            --transition: 0.25s ease;
        }
        html {
            font-size: 14px;
        }
        body {
            font-family: var(--font);
            background: linear-gradient(135deg, var(--bg-start), var(--bg-end));
            color: var(--text);
            display: flex;
            min-height: 100vh;
            margin: 0;
        }

        /* ── SIDEBAR ── */
        #sidebar {
            width: 260px;
            min-height: 100vh;
            background: linear-gradient(180deg, var(--sidebar-start), var(--sidebar-end));
            color: #fff;
            padding: 24px 18px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            flex-shrink: 0;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 10;
        }
        .logo-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 24px;
        }
        .logo-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-sm);
            background: linear-gradient(135deg, #60a5fa, #2563eb);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 20px;
            color: #fff;
            flex-shrink: 0;
        }
        .logo-text {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        #nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
            flex: 1;
            padding-top: 8px;
        }
        .nav-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            text-align: left;
            font-family: var(--font);
        }
        .nav-btn:hover {
            background: rgba(255, 255, 255, 0.08);
            color: #fff;
        }
        .nav-btn.active {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            box-shadow: inset 3px 0 0 #60a5fa;
        }
        .nav-btn span {
            font-size: 16px;
            width: 24px;
            text-align: center;
        }

        .user-wrap {
            margin-top: 20px;
            padding: 14px 16px;
            border-radius: var(--radius-sm);
            background: rgba(255, 255, 255, 0.10);
            backdrop-filter: blur(8px);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .avatar {
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            font-size: 13px;
        }
        .user-name {
            font-weight: 600;
            font-size: 13px;
            color: #fff;
            line-height: 1.3;
        }
        .user-role {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.6);
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.20);
            color: #fff;
            padding: 8px 14px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font);
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 100%;
        }
        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.40);
        }

        /* ── MAIN ── */
        #main {
            flex: 1;
            padding: 28px 32px 36px;
            min-width: 0;
        }

        /* ── TOPBAR ── */
        #topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 28px;
        }
        .welcome-title {
            font-size: 26px;
            font-weight: 700;
            color: #0f172a;
        }
        .welcome-sub {
            color: var(--text-secondary);
            margin-top: 2px;
            font-size: 13px;
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        .search-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            padding: 8px 14px;
            border-radius: 999px;
            box-shadow: var(--shadow);
            min-width: 200px;
            border: 1px solid var(--border);
        }
        .search-wrap input {
            border: none;
            outline: none;
            background: transparent;
            width: 100%;
            color: var(--text);
            font-family: var(--font);
            font-size: 13px;
        }
        .search-wrap input::placeholder {
            color: #94a3b8;
        }
        .icon-btn {
            border: none;
            border-radius: 999px;
            padding: 8px 12px;
            background: #fff;
            color: var(--primary);
            box-shadow: var(--shadow);
            cursor: pointer;
            font-size: 16px;
            transition: var(--transition);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 4px;
            text-decoration: none;
            font-family: var(--font);
        }
        .icon-btn:hover {
            background: var(--primary-soft);
            transform: translateY(-1px);
        }
        .notif-dot {
            background: var(--danger);
            color: #fff;
            font-size: 10px;
            padding: 1px 6px;
            border-radius: 999px;
            font-weight: 700;
        }

        /* ── FLASH / TOAST ── */
        .flash {
            padding: 12px 18px;
            border-radius: var(--radius-sm);
            margin-bottom: 16px;
            font-weight: 600;
            font-size: 14px;
        }
        .flash.success {
            background: var(--success-bg);
            color: #166534;
        }
        .flash.error {
            background: var(--danger-bg);
            color: #991b1b;
        }
        #toast {
            position: fixed;
            bottom: 30px;
            right: 30px;
            padding: 14px 24px;
            border-radius: var(--radius-sm);
            color: #fff;
            font-weight: 600;
            font-size: 14px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.20);
            display: none;
            z-index: 999;
            max-width: 400px;
            animation: slideUp 0.3s ease;
        }
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── PAGES ── */
        .page {
            display: none;
            animation: fadeIn 0.3s ease;
        }
        .page.active {
            display: block;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .page-header {
            margin-bottom: 20px;
        }
        .page-header h2 {
            margin: 0 0 4px;
            color: #0f172a;
            font-size: 22px;
        }
        .page-header p {
            margin: 0;
            color: var(--text-secondary);
            font-size: 14px;
        }
        .page-header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 20px;
        }

        /* ── GRIDS ── */
        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }
        .grid-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
        .grid-3-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        /* ── CARDS ── */
        .stat-card,
        .panel,
        .dosen-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 18px 20px;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }
        .stat-card:hover,
        .panel:hover,
        .dosen-card:hover {
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.10);
        }
        .stat-card {
            display: flex;
            gap: 14px;
            align-items: center;
        }
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        .stat-val {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
        }
        .stat-label {
            font-size: 13px;
            color: var(--text-secondary);
        }
        .stat-sub {
            font-size: 12px;
            margin-top: 2px;
        }

        .panel-title {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 12px;
        }

        /* ── PROGRESS ── */
        .progress-track {
            height: 8px;
            border-radius: 999px;
            background: #eef0f6;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            border-radius: inherit;
            transition: width 0.5s ease;
        }

        /* ── TAG PILL ── */
        .tag-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            line-height: 1.4;
        }

        /* ── DOSEN CARD ── */
        .dosen-card {
            text-align: center;
        }
        .dosen-card .avatar {
            margin: 0 auto 8px;
        }
        .dosen-stats {
            display: flex;
            justify-content: space-between;
            margin-top: 12px;
            gap: 8px;
        }
        .dosen-stat-val {
            font-size: 14px;
            font-weight: 700;
        }
        .dosen-stat-label {
            font-size: 11px;
            color: var(--text-secondary);
        }

        /* ── ACTION CHIP ── */
        .action-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 16px;
            border-radius: 999px;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            color: var(--primary);
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            transition: var(--transition);
            border: none;
            cursor: pointer;
            font-family: var(--font);
        }
        .action-chip:hover {
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            transform: translateY(-1px);
        }

        /* ── CARI KELAS ── */
        .search-filter-row {
            display: flex;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }
        .filter-tags {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
        .filter-tag {
            padding: 6px 14px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: #fff;
            font-size: 12px;
            font-weight: 500;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font);
        }
        .filter-tag:hover {
            border-color: var(--primary);
            color: var(--primary);
        }
        .filter-tag.active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .kelas-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
        .kelas-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 18px 20px;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }
        .kelas-card:hover {
            box-shadow: 0 12px 32px rgba(15, 23, 42, 0.10);
        }
        .kelas-card.applied {
            border-left: 4px solid var(--success);
        }
        .kelas-name {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin-top: 4px;
        }
        .kelas-meta {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .cap-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 4px;
        }
        .cap-label {
            font-size: 12px;
            color: var(--text-secondary);
            font-weight: 500;
        }

        .badge {
            padding: 3px 10px;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }
        .badge-active {
            background: var(--success-bg);
            color: #166534;
        }
        .badge-full {
            background: var(--danger-bg);
            color: #991b1b;
        }

        .enroll-btn {
            margin-top: 12px;
            padding: 8px 16px;
            border-radius: 999px;
            border: none;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            font-family: var(--font);
        }
        .enroll-btn.idle {
            background: var(--primary);
            color: #fff;
        }
        .enroll-btn.idle:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
        }
        .enroll-btn.done {
            background: var(--success-bg);
            color: #166534;
            cursor: default;
        }
        .enroll-btn.full-btn {
            background: #eef0f6;
            color: #94a3b8;
            cursor: not-allowed;
        }

        /* ── MATERI & TUGAS ── */
        .kelas-select-row {
            margin-bottom: 16px;
        }
        .kelas-select-row select {
            padding: 10px 18px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            background: #fff;
            font-size: 14px;
            font-weight: 500;
            color: var(--text);
            font-family: var(--font);
            min-width: 200px;
            cursor: pointer;
            outline: none;
        }
        .kelas-select-row select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .tab-row {
            display: flex;
            gap: 4px;
            border-bottom: 2px solid var(--border);
            margin-bottom: 16px;
        }
        .tab-btn {
            padding: 8px 20px;
            border: none;
            background: transparent;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font);
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
        }
        .tab-btn:hover {
            color: var(--text);
        }
        .tab-btn.active {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }
        .tab-content {
            display: none;
            animation: fadeIn 0.25s ease;
        }
        .tab-content.active {
            display: block;
        }

        .material-item,
        .assignment-item {
            padding: 14px 18px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            margin-bottom: 10px;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.04);
        }
        .material-item-title,
        .assignment-item-title {
            font-weight: 600;
            font-size: 15px;
            color: #0f172a;
        }
        .material-item-desc,
        .assignment-item-desc {
            font-size: 13px;
            color: var(--text-secondary);
            margin: 4px 0 6px;
        }
        .material-item-meta,
        .assignment-item-meta {
            font-size: 12px;
            color: #94a3b8;
        }
        .submit-tugas-btn {
            margin-top: 8px;
            padding: 6px 18px;
            border-radius: 999px;
            border: none;
            background: var(--primary);
            color: #fff;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font);
        }
        .submit-tugas-btn:hover {
            background: #1d4ed8;
        }
        .submitted-tag {
            display: inline-block;
            margin-top: 8px;
            padding: 4px 14px;
            border-radius: 999px;
            background: var(--success-bg);
            color: #166534;
            font-size: 12px;
            font-weight: 600;
        }

        /* ── NILAI ── */
        .nilai-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 16px;
        }
        .nilai-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 16px 18px;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }
        .nilai-card:hover {
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.08);
        }
        .nilai-course-tag {
            font-size: 11px;
            font-weight: 600;
            color: var(--primary);
            background: var(--primary-soft);
            padding: 2px 10px;
            border-radius: 999px;
            display: inline-block;
            margin-bottom: 6px;
        }
        .nilai-score {
            font-size: 28px;
            font-weight: 700;
        }
        .nilai-feedback {
            font-size: 12px;
            color: var(--text-secondary);
            margin-top: 4px;
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            padding: 40px 20px;
            text-align: center;
            color: var(--text-secondary);
            font-size: 14px;
        }
        .empty-state .empty-icon {
            font-size: 40px;
            display: block;
            margin-bottom: 10px;
        }

        /* ── COMING SOON ── */
        .coming-soon {
            padding: 60px 20px;
            text-align: center;
        }

        /* ── MODAL ── */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.50);
            backdrop-filter: blur(6px);
            z-index: 1000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .modal-overlay.active {
            display: flex;
        }
        .modal-box {
            background: #fff;
            border-radius: var(--radius);
            padding: 28px 32px;
            max-width: 520px;
            width: 100%;
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.25);
            animation: fadeIn 0.25s ease;
            max-height: 90vh;
            overflow-y: auto;
        }
        .modal-title {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 18px;
        }
        .form-group {
            margin-bottom: 14px;
        }
        .form-group label {
            display: block;
            font-weight: 600;
            font-size: 13px;
            color: var(--text);
            margin-bottom: 4px;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            border: 1px solid var(--border);
            font-size: 14px;
            font-family: var(--font);
            color: var(--text);
            transition: var(--transition);
            background: #fff;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
            outline: none;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 70px;
        }
        .form-row-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }
        .modal-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 20px;
        }
        .modal-actions .btn-secondary,
        .modal-actions .btn-primary {
            padding: 10px 24px;
            border-radius: 999px;
            border: none;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font);
        }
        .modal-actions .btn-secondary {
            background: #f1f5f9;
            color: var(--text-secondary);
        }
        .modal-actions .btn-secondary:hover {
            background: #e2e8f0;
        }
        .modal-actions .btn-primary {
            background: var(--primary);
            color: #fff;
        }
        .modal-actions .btn-primary:hover {
            background: #1d4ed8;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {
            .grid-3,
            .grid-2,
            .grid-3-cards,
            .kelas-grid {
                grid-template-columns: 1fr 1fr;
            }
        }
        @media (max-width: 768px) {
            #sidebar {
                width: 100%;
                min-height: auto;
                height: auto;
                position: relative;
                padding: 16px;
            }
            body {
                flex-direction: column;
            }
            #main {
                padding: 16px;
            }
            .grid-3,
            .grid-2,
            .grid-3-cards,
            .kelas-grid {
                grid-template-columns: 1fr;
            }
            #topbar {
                flex-direction: column;
                align-items: stretch;
            }
            .topbar-right {
                flex-wrap: wrap;
            }
            .search-wrap {
                min-width: 100%;
            }
            .form-row-2 {
                grid-template-columns: 1fr;
            }
            .modal-box {
                padding: 20px;
            }
            .page-header-row {
                flex-direction: column;
                align-items: stretch;
            }
        }
        @media (max-width: 480px) {
            .stats-row {
                flex-direction: column;
            }
            .grade-input-row {
                flex-direction: column;
                align-items: stretch;
            }
            .grade-input-row input[type="number"],
            .grade-input-row input[type="text"] {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <!-- ─── TOAST ─── -->
    <div id="toast"></div>

    <!-- ─── SIDEBAR ─── -->
    <div id="sidebar">
        <div>
            <div class="logo-wrap">
                <div class="logo-icon">S</div>
                <span class="logo-text">SMART</span>
            </div>
            <nav id="nav"></nav>
        </div>
        <div class="user-wrap">
            <div class="user-info">
                <div class="avatar" id="sidebarAvatar" style="background:#3b7fd4;">HP</div>
                <div>
                    <div class="user-name" id="sidebarName">Harry Potter</div>
                    <div class="user-role" id="sidebarRole">Mahasiswa</div>
                </div>
            </div>
            <button class="logout-btn" onclick="logout()">🚪 Logout</button>
        </div>
    </div>

    <!-- ─── MAIN ─── -->
    <div id="main">

        <!-- TOPBAR -->
        <div id="topbar">
            <div>
                <div class="welcome-title" id="welcomeTitle">Selamat datang, Harry 👋</div>
                <div class="welcome-sub" id="welcomeSub">Senin, 20 Juli 2026 · Dashboard</div>
            </div>
            <div class="topbar-right">
                <div class="search-wrap">
                    <span>🔍</span>
                    <input id="globalSearch" placeholder="Cari..." oninput="handleGlobalSearch()" />
                </div>
                <button class="icon-btn">🔔<span class="notif-dot">3</span></button>
                <div class="avatar" id="topbarAvatar" style="background:#3b7fd4;width:34px;height:34px;font-size:12px;">HP</div>
            </div>
        </div>

        <!-- ─── CONTENT ─── -->
        <div id="content">

            <!-- DASHBOARD -->
            <div class="page active" id="page-dashboard">
                <div class="grid-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#2dbe7c18;">⭐</div>
                        <div>
                            <div class="stat-val" id="statNilai">4.8</div>
                            <div class="stat-label">Rata-rata nilai</div>
                            <div class="stat-sub" style="color:#2dbe7c;">+0.2 bulan ini</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#3b7fd418;">🏅</div>
                        <div>
                            <div class="stat-val" id="statPoin">225</div>
                            <div class="stat-label">Total poin</div>
                            <div class="stat-sub" style="color:#3b7fd4;">Peringkat #3</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#f5a62318;">📋</div>
                        <div>
                            <div class="stat-val" id="statKehadiran">19/20</div>
                            <div class="stat-label">Kehadiran</div>
                            <div class="stat-sub" style="color:#f5a623;">95% on-time</div>
                        </div>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="panel">
                        <div class="panel-title">Progres Kamu</div>
                        <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
                            <svg width="80" height="80" viewBox="0 0 80 80" style="flex-shrink:0;">
                                <circle cx="40" cy="40" r="30" fill="none" stroke="#eef0f6" stroke-width="8"/>
                                <circle cx="40" cy="40" r="30" fill="none" stroke="#2dbe7c" stroke-width="8" stroke-dasharray="137.44 50.89" stroke-dashoffset="47.12" stroke-linecap="round"/>
                                <text x="40" y="45" text-anchor="middle" font-size="14" font-weight="700" fill="#1a2a4a">73%</text>
                            </svg>
                            <div style="flex:1;min-width:120px;">
                                <div style="font-size:12px;color:#5a6480;margin-bottom:8px;">Progres tim kamu</div>
                                <div style="margin-bottom:6px;">
                                    <div style="display:flex;justify-content:space-between;margin-bottom:2px;">
                                        <span style="font-size:11px;font-weight:500;">Mattie Blooman</span>
                                        <span style="font-size:11px;color:#5a6480;">70%</span>
                                    </div>
                                    <div class="progress-track"><div class="progress-fill" style="width:70%;background:#3b7fd4;"></div></div>
                                </div>
                                <div style="margin-bottom:6px;">
                                    <div style="display:flex;justify-content:space-between;margin-bottom:2px;">
                                        <span style="font-size:11px;font-weight:500;">Olivia Arribas</span>
                                        <span style="font-size:11px;color:#5a6480;">60%</span>
                                    </div>
                                    <div class="progress-track"><div class="progress-fill" style="width:60%;background:#3b7fd4;"></div></div>
                                </div>
                                <div>
                                    <div style="display:flex;justify-content:space-between;margin-bottom:2px;">
                                        <span style="font-size:11px;font-weight:500;">Graham Griffiths</span>
                                        <span style="font-size:11px;color:#5a6480;">56%</span>
                                    </div>
                                    <div class="progress-track"><div class="progress-fill" style="width:56%;background:#3b7fd4;"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-title">Kelas Aktif</div>
                        <div id="dashboardKelasList">
                            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                                <span class="tag-pill" style="background:#3b7fd418;color:#3b7fd4;">AI/ML</span>
                                <div style="flex:1;min-width:0;">
                                    <div style="font-size:12px;font-weight:500;">Machine Learning A</div>
                                    <div style="font-size:11px;color:#5a6480;">Dr. Severus Snape</div>
                                </div>
                                <span style="font-size:11px;color:#5a6480;">22/30</span>
                            </div>
                            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                                <span class="tag-pill" style="background:#3b7fd418;color:#3b7fd4;">AI/ML</span>
                                <div style="flex:1;min-width:0;">
                                    <div style="font-size:12px;font-weight:500;">Deep Learning B</div>
                                    <div style="font-size:11px;color:#5a6480;">Prof. Lily Potter</div>
                                </div>
                                <span style="font-size:11px;color:#5a6480;">19/25</span>
                            </div>
                            <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px;">
                                <span class="tag-pill" style="background:#8e44ad18;color:#8e44ad;">Vision</span>
                                <div style="flex:1;min-width:0;">
                                    <div style="font-size:12px;font-weight:500;">Computer Vision C</div>
                                    <div style="font-size:11px;color:#5a6480;">Dr. Harry Potter</div>
                                </div>
                                <span style="font-size:11px;color:#5a6480;">15/20</span>
                            </div>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <span class="tag-pill" style="background:#2dbe7c18;color:#2dbe7c;">NLP</span>
                                <div style="flex:1;min-width:0;">
                                    <div style="font-size:12px;font-weight:500;">NLP Dasar D</div>
                                    <div style="font-size:11px;color:#5a6480;">Dr. Severus Snape</div>
                                </div>
                                <span style="font-size:11px;color:#5a6480;">28/35</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-title">Aksi Cepat</div>
                    <div style="display:flex;flex-wrap:wrap;gap:10px;">
                        <button class="action-chip" onclick="navigate('cari-kelas')">📘 Lihat materi</button>
                        <button class="action-chip" onclick="navigate('materi-tugas')">📝 Tugas saya</button>
                        <button class="action-chip" onclick="showToast('Fitur jadwal segera hadir!','#3b7fd4')">📅 Jadwal kelas</button>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-title">Dosen Pembimbing</div>
                    <div class="grid-3-cards">
                        <div class="dosen-card">
                            <div class="avatar" style="width:52px;height:52px;font-size:16px;background:#1a2a4a;margin:0 auto 8px;">SS</div>
                            <div style="font-weight:600;font-size:14px;">Severus Snape</div>
                            <div style="font-size:11px;color:#5a6480;margin-bottom:10px;">Teacher</div>
                            <div class="dosen-stats">
                                <div><div class="dosen-stat-val" style="color:#e74c3c;">78</div><div class="dosen-stat-label">Kuliah</div></div>
                                <div><div class="dosen-stat-val" style="color:#3b7fd4;">4.9</div><div class="dosen-stat-label">Nilai</div></div>
                                <div><div class="dosen-stat-val" style="color:#2dbe7c;">6 thn</div><div class="dosen-stat-label">Pengalaman</div></div>
                            </div>
                        </div>
                        <div class="dosen-card">
                            <div class="avatar" style="width:52px;height:52px;font-size:16px;background:#3b7fd4;margin:0 auto 8px;">LP</div>
                            <div style="font-weight:600;font-size:14px;">Lily Potter</div>
                            <div style="font-size:11px;color:#5a6480;margin-bottom:10px;">Teacher</div>
                            <div class="dosen-stats">
                                <div><div class="dosen-stat-val" style="color:#e74c3c;">43</div><div class="dosen-stat-label">Kuliah</div></div>
                                <div><div class="dosen-stat-val" style="color:#3b7fd4;">4.8</div><div class="dosen-stat-label">Nilai</div></div>
                                <div><div class="dosen-stat-val" style="color:#2dbe7c;">16 thn</div><div class="dosen-stat-label">Pengalaman</div></div>
                            </div>
                        </div>
                        <div class="dosen-card">
                            <div class="avatar" style="width:52px;height:52px;font-size:16px;background:#2dbe7c;margin:0 auto 8px;">HP</div>
                            <div style="font-weight:600;font-size:14px;">Harry Potter</div>
                            <div style="font-size:11px;color:#5a6480;margin-bottom:10px;">Mentor</div>
                            <div class="dosen-stats">
                                <div><div class="dosen-stat-val" style="color:#e74c3c;">0</div><div class="dosen-stat-label">Kuliah</div></div>
                                <div><div class="dosen-stat-val" style="color:#3b7fd4;">5.0</div><div class="dosen-stat-label">Nilai</div></div>
                                <div><div class="dosen-stat-val" style="color:#2dbe7c;">3 thn</div><div class="dosen-stat-label">Pengalaman</div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARI KELAS -->
            <div class="page" id="page-cari-kelas">
                <div class="page-header">
                    <h2>Cari Kelas</h2>
                    <p>Temukan dan daftarkan diri ke kelas yang tersedia.</p>
                </div>
                <div class="search-filter-row">
                    <div class="search-wrap" style="flex:1;min-width:200px;">
                        <span>🔍</span>
                        <input id="kelasSearch" placeholder="Cari nama kelas atau dosen..." oninput="renderKelas()" />
                    </div>
                    <div class="filter-tags" id="filterTags"></div>
                </div>
                <div class="kelas-grid" id="kelasGrid"></div>
                <div class="empty-state" id="kelasEmpty" style="display:none;">
                    <span class="empty-icon">🔍</span>
                    Kelas tidak ditemukan. Coba kata kunci lain.
                </div>
            </div>

            <!-- MATERI & TUGAS -->
            <div class="page" id="page-materi-tugas">
                <div class="page-header-row">
                    <div class="page-header" style="margin-bottom:0;">
                        <h2 id="mtTitle">Kelas Saya — Materi & Tugas</h2>
                        <p id="mtSub">Akses materi dan kerjakan tugas dari kelas yang sudah kamu ikuti.</p>
                    </div>
                </div>
                <div class="kelas-select-row">
                    <select id="mtKelasSelect" onchange="onMtKelasChange()"></select>
                </div>
                <div id="mtEmpty" class="empty-state" style="display:none;"></div>
                <div id="mtBody" style="display:none;">
                    <div class="tab-row">
                        <button class="tab-btn active" id="tabMateri" onclick="switchMtTab('materi')">📄 Materi</button>
                        <button class="tab-btn" id="tabTugas" onclick="switchMtTab('tugas')">📝 Tugas</button>
                    </div>
                    <div class="tab-content active" id="tabMateriContent"></div>
                    <div class="tab-content" id="tabTugasContent"></div>
                </div>
            </div>

            <!-- NILAI -->
            <div class="page" id="page-nilai">
                <div class="page-header">
                    <h2 id="nilaiTitle">Nilai Saya</h2>
                    <p id="nilaiSub">Rekap nilai dan feedback dari setiap tugas yang sudah kamu kumpulkan.</p>
                </div>
                <div id="nilaiContent"></div>
            </div>

            <!-- COMING SOON -->
            <div class="page" id="page-jadwal"><div class="coming-soon"><span style="font-size:48px;display:block;margin-bottom:12px;">🚧</span><div style="font-size:18px;font-weight:600;">Halaman Jadwal</div><div style="font-size:13px;color:#64748b;">Fitur segera tersedia.</div></div></div>
            <div class="page" id="page-laporan"><div class="coming-soon"><span style="font-size:48px;display:block;margin-bottom:12px;">🚧</span><div style="font-size:18px;font-weight:600;">Halaman Laporan</div><div style="font-size:13px;color:#64748b;">Fitur segera tersedia.</div></div></div>
            <div class="page" id="page-dosen"><div class="coming-soon"><span style="font-size:48px;display:block;margin-bottom:12px;">🚧</span><div style="font-size:18px;font-weight:600;">Halaman Dosen</div><div style="font-size:13px;color:#64748b;">Fitur segera tersedia.</div></div></div>

        </div><!-- /content -->
    </div><!-- /main -->

    <!-- ─── MODALS ─── -->
    <!-- Submit Tugas -->
    <div class="modal-overlay" id="modalSubmit">
        <div class="modal-box">
            <div class="modal-title">Kumpulkan Tugas</div>
            <div class="form-group"><label>Nama File Jawaban</label><input type="text" id="sfFilename" placeholder="jawaban_tugas1.pdf" /></div>
            <div class="modal-actions">
                <button class="btn-secondary" onclick="closeModal('modalSubmit')">Batal</button>
                <button class="btn-primary" onclick="saveSubmission()">Kumpulkan</button>
            </div>
        </div>
    </div>

    <script>
        // ═══════════════════════════════════════════════════════
        //  DATA
        // ═══════════════════════════════════════════════════════

        let kelasList = [
            { id: 1, nama: "Machine Learning A", dosen: "Dr. Severus Snape", jadwal: "Senin, 08:00–10:00", ruang: "Lab A-301",
                kapasitas: 30, terdaftar: 22, status: "active", tag: "AI/ML" },
            { id: 2, nama: "Deep Learning B", dosen: "Prof. Lily Potter", jadwal: "Selasa, 13:00–15:00", ruang: "Lab B-202",
                kapasitas: 25, terdaftar: 19, status: "active", tag: "AI/ML" },
            { id: 3, nama: "Computer Vision C", dosen: "Dr. Harry Potter", jadwal: "Rabu, 10:00–12:00", ruang: "Lab A-105",
                kapasitas: 20, terdaftar: 15, status: "active", tag: "Vision" },
            { id: 4, nama: "NLP Dasar D", dosen: "Dr. Severus Snape", jadwal: "Kamis, 14:00–16:00", ruang: "Lab C-401",
                kapasitas: 35, terdaftar: 28, status: "active", tag: "NLP" },
            { id: 5, nama: "Data Engineering E", dosen: "Prof. Lily Potter", jadwal: "Jumat, 09:00–11:00", ruang: "Lab B-103",
                kapasitas: 28, terdaftar: 10, status: "active", tag: "Data" },
            { id: 6, nama: "Cloud Computing F", dosen: "Dr. Harry Potter", jadwal: "Senin, 13:00–15:00", ruang: "Lab D-201",
                kapasitas: 30, terdaftar: 30, status: "full", tag: "Cloud" },
        ];

        let enrollments = [
            { id: 1, studentName: "Andi Pratama", nim: "2021001", avatar: "AP", kelas: "Machine Learning A", status: "pending",
                tanggal: "18 Jul 2026" },
            { id: 2, studentName: "Budi Santoso", nim: "2021002", avatar: "BS", kelas: "Deep Learning B", status: "pending",
                tanggal: "18 Jul 2026" },
            { id: 3, studentName: "Citra Dewi", nim: "2021003", avatar: "CD", kelas: "Machine Learning A", status: "approved",
                tanggal: "17 Jul 2026" },
            { id: 4, studentName: "Dian Rahayu", nim: "2021004", avatar: "DR", kelas: "Computer Vision C", status: "pending",
                tanggal: "19 Jul 2026" },
            { id: 5, studentName: "Eko Widodo", nim: "2021005", avatar: "EW", kelas: "Deep Learning B", status: "rejected",
                tanggal: "16 Jul 2026" },
            { id: 6, studentName: "Fitri Handayani", nim: "2021006", avatar: "FH", kelas: "NLP Dasar D", status: "pending",
                tanggal: "19 Jul 2026" },
            { id: 7, studentName: "Harry Potter", nim: "2021099", avatar: "HP", kelas: "Machine Learning A", status: "approved",
                tanggal: "12 Jul 2026" },
        ];

        let appliedKelas = [];
        let approvedKelasNames = ["Machine Learning A"];
        let materialsData = {
            "Machine Learning A": [
                { id: 1, judul: "Pengenalan Supervised Learning",
                    deskripsi: "Slide dan ringkasan konsep dasar supervised learning.", tanggal: "14 Jul 2026" },
                { id: 2, judul: "Studi Kasus: Decision Tree",
                    deskripsi: "Contoh implementasi decision tree pada dataset Iris.", tanggal: "17 Jul 2026" },
            ],
            "NLP Dasar D": [
                { id: 3, judul: "Tokenisasi & Text Preprocessing",
                    deskripsi: "Materi dasar pemrosesan teks sebelum masuk ke model NLP.", tanggal: "15 Jul 2026" },
            ],
        };
        let assignmentsData = {
            "Machine Learning A": [{
                id: 1,
                judul: "Tugas 1: Implementasi Regresi Linear",
                deskripsi: "Implementasikan regresi linear sederhana menggunakan Python.",
                deadline: "25 Jul 2026",
                submissions: [
                    { studentName: "Citra Dewi", nim: "2021003", avatar: "CD", fileName: "regresi_citra.py",
                        tanggal: "19 Jul 2026", nilai: null, feedback: null },
                ]
            }],
            "NLP Dasar D": [{
                id: 2,
                judul: "Tugas 1: Text Cleaning Pipeline",
                deskripsi: "Buat pipeline pembersihan teks sederhana.",
                deadline: "28 Jul 2026",
                submissions: []
            }],
        };

        // ═══════════════════════════════════════════════════════
        //  STATE
        // ═══════════════════════════════════════════════════════

        let activePage = "dashboard";
        let activeFilter = "all";
        let mtActiveTab = "materi";
        let mtSelectedKelas = null;
        let submittingAssignmentId = null;
        let nextEnrollId = 8;
        let nextAssignmentId = 3;

        const MHS_IDENTITY = { name: "Harry Potter", nim: "2021099", avatar: "HP" };
        const tagColors = { "AI/ML": "#3b7fd4", "Vision": "#8e44ad", "NLP": "#2dbe7c", "Data": "#f5a623", "Cloud": "#e74c3c" };
        const avatarColors = ["#1a5fa0", "#2dbe7c", "#8e44ad", "#e74c3c", "#f5a623", "#0f6e56"];

        const navMahasiswa = [
            { icon: "📊", label: "Dashboard", key: "dashboard" },
            { icon: "📚", label: "Cari Kelas", key: "cari-kelas" },
            { icon: "🗂️", label: "Kelas Saya", key: "materi-tugas" },
            { icon: "🏆", label: "Nilai", key: "nilai" },
            { icon: "📅", label: "Jadwal", key: "jadwal" },
            { icon: "📝", label: "Laporan", key: "laporan" },
            { icon: "👩‍🏫", label: "Dosen", key: "dosen" },
        ];

        // ═══════════════════════════════════════════════════════
        //  HELPERS
        // ═══════════════════════════════════════════════════════

        function showToast(msg, color = "#2563eb") {
            const t = document.getElementById("toast");
            t.textContent = msg;
            t.style.background = color;
            t.style.display = "block";
            clearTimeout(t._hide);
            t._hide = setTimeout(() => { t.style.display = "none"; }, 3200);
        }

        function closeModal(id) { document.getElementById(id).classList.remove("active"); }

        function openModal(id) { document.getElementById(id).classList.add("active"); }

        function getTagColor(tag) { return tagColors[tag] || "#3b7fd4"; }

        function getAvatarColor(id) { return avatarColors[id % avatarColors.length]; }

        // ── LOGOUT ──
        function logout() {
            if (confirm("Apakah Anda yakin ingin logout?")) {
                // Simulasi redirect ke halaman login
                showToast("Logout berhasil! Mengalihkan ke halaman login...", "#7c3aed");
                setTimeout(() => {
                    window.location.href = "http://127.0.0.1:8000/"; // Ganti dengan URL login sebenarnya
                }, 1500);
            }
        }

        // ═══════════════════════════════════════════════════════
        //  NAVIGATION
        // ═══════════════════════════════════════════════════════

        function renderNav() {
            const nav = document.getElementById("nav");
            nav.innerHTML = navMahasiswa.map(item => `
            <button class="nav-btn ${activePage === item.key ? 'active' : ''}" onclick="navigate('${item.key}')">
              <span>${item.icon}</span>${item.label}
            </button>
          `).join("");
        }

        function updateUser() {
            document.getElementById("sidebarAvatar").textContent = MHS_IDENTITY.avatar;
            document.getElementById("sidebarAvatar").style.background = "#3b7fd4";
            document.getElementById("sidebarName").textContent = MHS_IDENTITY.name;
            document.getElementById("sidebarRole").textContent = "Mahasiswa";
            document.getElementById("topbarAvatar").textContent = MHS_IDENTITY.avatar;
            document.getElementById("topbarAvatar").style.background = "#3b7fd4";
            document.getElementById("welcomeTitle").textContent = `Selamat datang, Harry 👋`;
        }

        function updatePageLabel() {
            const found = navMahasiswa.find(n => n.key === activePage);
            document.getElementById("welcomeSub").textContent =
                `Senin, 20 Juli 2026 · ${found ? found.label : "Dashboard"}`;
        }

        function navigate(page) {
            document.querySelectorAll(".page").forEach(p => p.classList.remove("active"));
            const el = document.getElementById("page-" + page);
            if (el) el.classList.add("active");
            activePage = page;
            renderNav();
            updatePageLabel();

            switch (page) {
                case "cari-kelas":
                    renderKelas();
                    break;
                case "materi-tugas":
                    renderMateriTugas();
                    break;
                case "nilai":
                    renderNilai();
                    break;
                default:
                    break;
            }
        }

        // ═══════════════════════════════════════════════════════
        //  DASHBOARD
        // ═══════════════════════════════════════════════════════

        function updateDashboardStats() {
            // Mahasiswa stats tetap
            document.getElementById("statNilai").textContent = "4.8";
            document.getElementById("statPoin").textContent = "225";
            document.getElementById("statKehadiran").textContent = "19/20";
            // Reset dashboard kelas list ke default (sudah ada di HTML)
        }

        // ═══════════════════════════════════════════════════════
        //  CARI KELAS
        // ═══════════════════════════════════════════════════════

        const tags = ["all", "AI/ML", "Vision", "NLP", "Data", "Cloud"];

        function renderFilterTags() {
            document.getElementById("filterTags").innerHTML = tags.map(t =>
                `<button class="filter-tag ${activeFilter === t ? 'active' : ''}" onclick="setTagFilter('${t}')">
              ${t === "all" ? "Semua" : t}
            </button>`
            ).join("");
        }

        function setTagFilter(tag) {
            activeFilter = tag;
            renderFilterTags();
            renderKelas();
        }

        function renderKelas() {
            renderFilterTags();
            const search = (document.getElementById("kelasSearch")?.value || "").toLowerCase();
            const filtered = kelasList.filter(k => {
                const matchSearch = k.nama.toLowerCase().includes(search) || k.dosen.toLowerCase().includes(search);
                const matchTag = activeFilter === "all" || k.tag === activeFilter;
                return matchSearch && matchTag;
            });
            const grid = document.getElementById("kelasGrid");
            const empty = document.getElementById("kelasEmpty");
            if (filtered.length === 0) { grid.innerHTML = "";
                empty.style.display = "block"; return; }
            empty.style.display = "none";
            grid.innerHTML = filtered.map(k => {
                const pct = Math.round((k.terdaftar / k.kapasitas) * 100);
                const isApplied = appliedKelas.includes(k.id);
                const isFull = k.status === "full";
                const barColor = pct >= 90 ? "#e74c3c" : pct >= 70 ? "#f5a623" : "#2dbe7c";
                const tc = getTagColor(k.tag);
                let btnClass = "enroll-btn idle",
                    btnText = "Ajukan Pendaftaran",
                    btnDisabled = "";
                if (isApplied) { btnClass = "enroll-btn done";
                    btnText = "✓ Sudah Diajukan";
                    btnDisabled = "disabled"; } else if (isFull) { btnClass = "enroll-btn full-btn";
                    btnText = "Kelas Penuh";
                    btnDisabled = "disabled"; }
                const badgeHtml = isFull ?
                    `<span class="badge badge-full">Penuh</span>` :
                    `<span class="badge badge-active">Aktif</span>`;
                return `
              <div class="kelas-card ${isApplied ? 'applied' : ''}">
                <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:10px;">
                  <div>
                    <span class="tag-pill" style="background:${tc}18;color:${tc};margin-bottom:5px;">${k.tag}</span>
                    <div class="kelas-name">${k.nama}</div>
                  </div>
                  ${badgeHtml}
                </div>
                <div class="kelas-meta">👩‍🏫 ${k.dosen}</div>
                <div class="kelas-meta">🕐 ${k.jadwal}</div>
                <div class="kelas-meta" style="margin-bottom:12px;">📍 ${k.ruang}</div>
                <div>
                  <div class="cap-row">
                    <span class="cap-label">Kapasitas</span>
                    <span style="font-size:11px;font-weight:500;color:${pct>=90?'#e74c3c':'#1a2a4a'};">${k.terdaftar}/${k.kapasitas} (${pct}%)</span>
                  </div>
                  <div class="progress-track"><div class="progress-fill" style="width:${pct}%;background:${barColor};"></div></div>
                </div>
                <button class="${btnClass}" ${btnDisabled} onclick="ajukanKelas(${k.id})">${btnText}</button>
              </div>
            `;
            }).join("");
        }

        function ajukanKelas(id) {
            if (appliedKelas.includes(id)) return;
            const k = kelasList.find(x => x.id === id);
            if (!k || k.status === "full") return;
            appliedKelas.push(id);
            enrollments.push({
                id: nextEnrollId++,
                studentName: MHS_IDENTITY.name,
                nim: MHS_IDENTITY.nim,
                avatar: MHS_IDENTITY.avatar,
                kelas: k.nama,
                status: "pending",
                tanggal: "20 Jul 2026",
            });
            showToast(`✓ Pendaftaran "${k.nama}" berhasil diajukan!`, "#16a34a");
            renderKelas();
        }

        // ═══════════════════════════════════════════════════════
        //  MATERI & TUGAS (Mahasiswa)
        // ═══════════════════════════════════════════════════════

        function getMtKelasOptions() {
            return approvedKelasNames;
        }

        function renderMateriTugas() {
            document.getElementById("mtTitle").textContent = "Kelas Saya — Materi & Tugas";
            document.getElementById("mtSub").textContent = "Akses materi dan kerjakan tugas dari kelas yang sudah kamu ikuti.";

            const options = getMtKelasOptions();
            const select = document.getElementById("mtKelasSelect");
            const empty = document.getElementById("mtEmpty");
            const body = document.getElementById("mtBody");

            if (options.length === 0) {
                select.innerHTML = "";
                body.style.display = "none";
                empty.style.display = "block";
                empty.textContent = "Kamu belum tergabung di kelas manapun. Ajukan pendaftaran di menu \"Cari Kelas\".";
                return;
            }
            empty.style.display = "none";
            body.style.display = "block";
            if (!mtSelectedKelas || !options.includes(mtSelectedKelas)) mtSelectedKelas = options[0];
            select.innerHTML = options.map(k =>
                `<option value="${k}" ${k===mtSelectedKelas?"selected":""}>${k}</option>`
            ).join("");
            switchMtTab(mtActiveTab);
        }

        function onMtKelasChange() {
            mtSelectedKelas = document.getElementById("mtKelasSelect").value;
            switchMtTab(mtActiveTab);
        }

        function switchMtTab(tab) {
            mtActiveTab = tab;
            document.getElementById("tabMateri").classList.toggle("active", tab === "materi");
            document.getElementById("tabTugas").classList.toggle("active", tab === "tugas");
            document.getElementById("tabMateriContent").classList.toggle("active", tab === "materi");
            document.getElementById("tabTugasContent").classList.toggle("active", tab === "tugas");
            if (tab === "materi") renderMateriList();
            else renderTugasList();
        }

        function renderMateriList() {
            const list = materialsData[mtSelectedKelas] || [];
            const el = document.getElementById("tabMateriContent");
            if (list.length === 0) {
                el.innerHTML = `<div class="empty-state"><span class="empty-icon">📭</span>Belum ada materi untuk kelas ini.</div>`;
                return;
            }
            el.innerHTML = list.map(m =>
                `<div class="material-item">
              <div class="material-item-title">📄 ${m.judul}</div>
              <div class="material-item-desc">${m.deskripsi}</div>
              <div class="material-item-meta">Diunggah ${m.tanggal}</div>
            </div>`
            ).join("");
        }

        function renderTugasList() {
            const list = assignmentsData[mtSelectedKelas] || [];
            const el = document.getElementById("tabTugasContent");
            if (list.length === 0) {
                el.innerHTML = `<div class="empty-state"><span class="empty-icon">📭</span>Belum ada tugas untuk kelas ini.</div>`;
                return;
            }
            el.innerHTML = list.map(a => {
                const mySubmission = a.submissions.find(s => s.studentName === MHS_IDENTITY.name);
                const actionHtml = mySubmission ?
                    `<span class="submitted-tag">✓ Terkumpul: ${mySubmission.fileName}</span>` :
                    `<button class="submit-tugas-btn" onclick="openSubmitModal(${a.id})">Kumpulkan Tugas</button>`;
                return `<div class="assignment-item">
                <div class="assignment-item-title">📝 ${a.judul}</div>
                <div class="assignment-item-desc">${a.deskripsi}</div>
                <div class="assignment-item-meta">Tenggat: ${a.deadline}</div>
                ${actionHtml}
              </div>`;
            }).join("");
        }

        function openSubmitModal(assignmentId) {
            submittingAssignmentId = assignmentId;
            document.getElementById("sfFilename").value = "";
            openModal("modalSubmit");
        }

        function saveSubmission() {
            const fileName = document.getElementById("sfFilename").value.trim();
            if (!fileName) { showToast("⚠ Masukkan nama file jawaban", "#dc2626"); return; }
            const list = assignmentsData[mtSelectedKelas] || [];
            const a = list.find(x => x.id === submittingAssignmentId);
            if (!a) return;
            a.submissions.push({ studentName: MHS_IDENTITY.name, nim: MHS_IDENTITY.nim, avatar: MHS_IDENTITY.avatar,
                fileName, tanggal: "20 Jul 2026", nilai: null, feedback: null });
            closeModal("modalSubmit");
            showToast(`✓ Tugas berhasil dikumpulkan`, "#16a34a");
            renderTugasList();
        }

        // ═══════════════════════════════════════════════════════
        //  NILAI (Mahasiswa)
        // ═══════════════════════════════════════════════════════

        function renderNilai() {
            const content = document.getElementById("nilaiContent");
            let cards = [];
            approvedKelasNames.forEach(kelasNama => {
                const list = assignmentsData[kelasNama] || [];
                list.forEach(a => {
                    const sub = a.submissions.find(s => s.studentName === MHS_IDENTITY.name);
                    if (sub) cards.push({ kelas: kelasNama, judul: a.judul, sub });
                });
            });
            if (cards.length === 0) {
                content.innerHTML = `<div class="empty-state">Belum ada tugas yang dikumpulkan atau dinilai.</div>`;
                return;
            }
            content.innerHTML = `<div class="nilai-grid">` + cards.map(c => {
                const graded = c.sub.nilai !== null;
                const scoreColor = !graded ? "#b07a00" : c.sub.nilai >= 80 ? "#16a34a" : c.sub.nilai >= 60 ? "#f59e0b" :
                    "#dc2626";
                return `
              <div class="nilai-card">
                <div class="nilai-course-tag">${c.kelas}</div>
                <div style="font-size:13px;font-weight:600;color:#0f172a;margin-bottom:8px;">${c.judul}</div>
                <div class="nilai-score" style="color:${scoreColor};">${graded ? c.sub.nilai : "Menunggu"}</div>
                <div class="nilai-feedback">${graded ? `💬 ${c.sub.feedback}` : "Tugas sudah dikumpulkan, menunggu penilaian."}</div>
              </div>
            `;
            }).join("") + `</div>`;
        }

        // ═══════════════════════════════════════════════════════
        //  GLOBAL SEARCH
        // ═══════════════════════════════════════════════════════

        function handleGlobalSearch() {
            const q = document.getElementById("globalSearch").value.toLowerCase().trim();
            if (!q) return;
            const foundKelas = kelasList.filter(k => k.nama.toLowerCase().includes(q) || k.dosen.toLowerCase().includes(q));
            if (foundKelas.length > 0) {
                navigate("cari-kelas");
                document.getElementById("kelasSearch").value = q;
                renderKelas();
                showToast(`🔍 Ditemukan ${foundKelas.length} kelas`, "#3b7fd4");
                return;
            }
            for (const [kelas, items] of Object.entries(materialsData)) {
                const found = items.filter(m => m.judul.toLowerCase().includes(q) || m.deskripsi.toLowerCase().includes(q));
                if (found.length > 0) {
                    navigate("materi-tugas");
                    mtSelectedKelas = kelas;
                    renderMateriTugas();
                    showToast(`📄 Ditemukan ${found.length} materi di "${kelas}"`, "#3b7fd4");
                    return;
                }
            }
            showToast(`🔍 Tidak ditemukan hasil untuk "${q}"`, "#f59e0b");
        }

        // ═══════════════════════════════════════════════════════
        //  INIT
        // ═══════════════════════════════════════════════════════

        function init() {
            updateUser();
            renderNav();
            updatePageLabel();
            navigate("dashboard");
            updateDashboardStats();
            document.querySelectorAll(".modal-overlay").forEach(m => m.classList.remove("active"));
        }

        init();
    </script>

</body>
</html>