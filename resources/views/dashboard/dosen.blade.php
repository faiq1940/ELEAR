<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SMART · Dashboard Dosen</title>
    <style>
        /* ═══════════════════════════════════════════ */
        /*  RESET & VARIABEL                         */
        /* ═══════════════════════════════════════════ */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        :root {
            --bg-start: #fdf2f8;
            --bg-end: #f8fbff;
            --sidebar-start: #111827;
            --sidebar-end: #4338ca;
            --primary: #7c3aed;
            --primary-dark: #6d28d9;
            --primary-light: #8b5cf6;
            --primary-soft: #ede9fe;
            --success: #16a34a;
            --success-bg: #dcfce7;
            --warning: #f59e0b;
            --warning-bg: #fef3c7;
            --danger: #dc2626;
            --danger-bg: #fee2e2;
            --text: #1f2a44;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            --border: #e2e8f0;
            --shadow: 0 12px 35px rgba(15, 23, 42, 0.08);
            --shadow-hover: 0 16px 40px rgba(15, 23, 42, 0.12);
            --radius: 20px;
            --radius-sm: 12px;
            --radius-full: 999px;
            --font: 'Inter', 'Segoe UI', Roboto, Arial, sans-serif;
            --transition: 0.25s ease;
        }
        html {
            font-size: 14px;
            scroll-behavior: smooth;
        }
        body {
            font-family: var(--font);
            background: linear-gradient(135deg, var(--bg-start), var(--bg-end));
            color: var(--text);
            display: flex;
            min-height: 100vh;
            margin: 0;
        }

        /* ═══════════════════════════════════════════ */
        /*  SIDEBAR                                   */
        /* ═══════════════════════════════════════════ */
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
            transition: var(--transition);
        }
        #sidebar::-webkit-scrollbar {
            width: 4px;
        }
        #sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        #sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 999px;
        }

        .logo-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 28px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }
        .logo-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--radius-sm);
            background: linear-gradient(135deg, #fb7185, #8b5cf6);
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
            color: #fff;
        }

        #nav {
            display: flex;
            flex-direction: column;
            gap: 2px;
            flex: 1;
            padding-top: 16px;
        }
        .nav-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.6);
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
            background: rgba(255, 255, 255, 0.14);
            color: #fff;
            box-shadow: inset 3px 0 0 #fb7185;
        }
        .nav-btn .nav-icon {
            font-size: 16px;
            width: 24px;
            text-align: center;
            flex-shrink: 0;
        }
        .nav-btn .nav-badge {
            margin-left: auto;
            background: rgba(255, 255, 255, 0.15);
            padding: 1px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 600;
        }

        .user-wrap {
            margin-top: 16px;
            padding: 14px 16px;
            border-radius: var(--radius-sm);
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(8px);
            display: flex;
            flex-direction: column;
            gap: 10px;
            border: 1px solid rgba(255, 255, 255, 0.06);
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
            width: 38px;
            height: 38px;
            font-size: 14px;
        }
        .user-name {
            font-weight: 600;
            font-size: 13px;
            color: #fff;
            line-height: 1.3;
        }
        .user-role {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.5);
        }

        .logout-btn {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
            color: #fff;
            padding: 8px 14px;
            border-radius: var(--radius-full);
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
            text-decoration: none;
        }
        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.18);
            border-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }

        /* ═══════════════════════════════════════════ */
        /*  MAIN                                      */
        /* ═══════════════════════════════════════════ */
        #main {
            flex: 1;
            padding: 28px 32px 36px;
            min-width: 0;
            max-width: 100%;
        }

        /* ═══════════════════════════════════════════ */
        /*  TOPBAR                                    */
        /* ═══════════════════════════════════════════ */
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
            letter-spacing: -0.3px;
        }
        .welcome-title span {
            background: linear-gradient(135deg, var(--primary), #fb7185);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
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
            border-radius: var(--radius-full);
            box-shadow: var(--shadow);
            min-width: 200px;
            border: 1px solid var(--border);
            transition: var(--transition);
        }
        .search-wrap:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.12);
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
            color: var(--text-muted);
        }
        .icon-btn {
            border: none;
            border-radius: var(--radius-full);
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
            position: relative;
        }
        .icon-btn:hover {
            background: var(--primary-soft);
            transform: translateY(-2px);
            box-shadow: var(--shadow-hover);
        }
        .notif-dot {
            background: var(--danger);
            color: #fff;
            font-size: 10px;
            padding: 1px 6px;
            border-radius: var(--radius-full);
            font-weight: 700;
            position: absolute;
            top: -4px;
            right: -4px;
        }

        /* ═══════════════════════════════════════════ */
        /*  TOAST / FLASH                             */
        /* ═══════════════════════════════════════════ */
        .flash {
            padding: 12px 18px;
            border-radius: var(--radius-sm);
            margin-bottom: 16px;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .flash.success {
            background: var(--success-bg);
            color: #166534;
            border-left: 4px solid var(--success);
        }
        .flash.error {
            background: var(--danger-bg);
            color: #991b1b;
            border-left: 4px solid var(--danger);
        }
        .flash.warning {
            background: var(--warning-bg);
            color: #92400e;
            border-left: 4px solid var(--warning);
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
            z-index: 9999;
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

        /* ═══════════════════════════════════════════ */
        /*  PAGES                                     */
        /* ═══════════════════════════════════════════ */
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
                transform: translateY(10px);
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
            font-weight: 700;
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

        /* ═══════════════════════════════════════════ */
        /*  GRIDS                                     */
        /* ═══════════════════════════════════════════ */
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

        /* ═══════════════════════════════════════════ */
        /*  CARDS                                     */
        /* ═══════════════════════════════════════════ */
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
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
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
            line-height: 1.2;
        }
        .stat-label {
            font-size: 13px;
            color: var(--text-secondary);
        }
        .stat-sub {
            font-size: 12px;
            margin-top: 2px;
            font-weight: 500;
        }

        .panel-title {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .panel-title .panel-badge {
            font-size: 11px;
            font-weight: 600;
            padding: 2px 10px;
            border-radius: var(--radius-full);
            background: var(--primary-soft);
            color: var(--primary);
        }

        /* ── PROGRESS ── */
        .progress-track {
            height: 8px;
            border-radius: var(--radius-full);
            background: #eef0f6;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            border-radius: inherit;
            transition: width 0.6s ease;
        }

        /* ── TAG PILL ── */
        .tag-pill {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 4px 10px;
            border-radius: var(--radius-full);
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
            padding: 10px 18px;
            border-radius: var(--radius-full);
            background: linear-gradient(135deg, #f5f3ff, #ede9fe);
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
            background: linear-gradient(135deg, #ede9fe, #ddd6fe);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(124, 58, 237, 0.15);
        }

        /* ═══════════════════════════════════════════ */
        /*  PERSETUJUAN                               */
        /* ═══════════════════════════════════════════ */
        .stats-row {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }
        .mini-stat {
            padding: 14px 20px;
            border-radius: var(--radius-sm);
            flex: 1;
            min-width: 120px;
            text-align: center;
            border: 1px solid var(--border);
            transition: var(--transition);
        }
        .mini-stat:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }
        .mini-stat-val {
            font-size: 26px;
            font-weight: 700;
        }
        .mini-stat-label {
            font-size: 12px;
            font-weight: 500;
        }

        .filter-row {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 16px;
        }
        .filter-btn {
            padding: 6px 16px;
            border-radius: var(--radius-full);
            border: 1px solid var(--border);
            background: #fff;
            font-size: 12px;
            font-weight: 500;
            color: var(--text-secondary);
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font);
        }
        .filter-btn:hover {
            border-color: var(--primary);
            color: var(--primary);
        }
        .filter-btn.active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .table-wrap {
            overflow-x: auto;
            background: #fff;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        table thead {
            background: #f8fafc;
            border-bottom: 1px solid var(--border);
        }
        table th {
            text-align: left;
            padding: 12px 16px;
            font-weight: 600;
            color: var(--text-secondary);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        table td {
            padding: 12px 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }
        table tbody tr:last-child td {
            border-bottom: none;
        }
        table tbody tr:hover {
            background: #fafbff;
        }

        .action-btns {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
        .approve-btn,
        .reject-btn {
            padding: 4px 14px;
            border-radius: var(--radius-full);
            border: none;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font);
        }
        .approve-btn {
            background: var(--success-bg);
            color: #166534;
        }
        .approve-btn:hover {
            background: #bbf7d0;
            transform: scale(1.03);
        }
        .reject-btn {
            background: var(--danger-bg);
            color: #991b1b;
        }
        .reject-btn:hover {
            background: #fecaca;
            transform: scale(1.03);
        }

        .badge {
            padding: 3px 10px;
            border-radius: var(--radius-full);
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }
        .badge-pending {
            background: #fef3c7;
            color: #92400e;
        }
        .badge-approved {
            background: var(--success-bg);
            color: #166534;
        }
        .badge-rejected {
            background: var(--danger-bg);
            color: #991b1b;
        }
        .badge-active {
            background: var(--success-bg);
            color: #166534;
        }
        .badge-full {
            background: var(--danger-bg);
            color: #991b1b;
        }

        /* ═══════════════════════════════════════════ */
        /*  KELOLA MATA KULIAH                       */
        /* ═══════════════════════════════════════════ */
        .matkul-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }
        .matkul-card {
            background: #fff;
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 18px 20px;
            box-shadow: var(--shadow);
            transition: var(--transition);
        }
        .matkul-card:hover {
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
        }
        .matkul-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-top: 12px;
        }
        .matkul-actions .btn-secondary,
        .matkul-actions .btn-danger {
            padding: 6px 14px;
            border-radius: var(--radius-full);
            border: 1px solid var(--border);
            background: #fff;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font);
        }
        .matkul-actions .btn-secondary:hover {
            background: var(--primary-soft);
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-1px);
        }
        .matkul-actions .btn-danger {
            color: var(--danger);
            border-color: var(--danger-bg);
        }
        .matkul-actions .btn-danger:hover {
            background: var(--danger-bg);
            transform: translateY(-1px);
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

        .add-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 10px 20px;
            border-radius: var(--radius-full);
            background: var(--primary);
            color: #fff;
            border: none;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font);
            white-space: nowrap;
        }
        .add-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(124, 58, 237, 0.30);
        }

        /* ═══════════════════════════════════════════ */
        /*  MATERI & TUGAS (DOSEN)                   */
        /* ═══════════════════════════════════════════ */
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
            transition: var(--transition);
        }
        .kelas-select-row select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.12);
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
            transition: var(--transition);
        }
        .material-item:hover,
        .assignment-item:hover {
            box-shadow: 0 6px 16px rgba(15, 23, 42, 0.08);
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
            color: var(--text-muted);
        }

        /* ═══════════════════════════════════════════ */
        /*  NILAI DOSEN                               */
        /* ═══════════════════════════════════════════ */
        .submission-mini {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .submission-mini:last-child {
            border-bottom: none;
        }
        .grade-input-row {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }
        .grade-input-row input[type="number"] {
            width: 70px;
            padding: 4px 8px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 13px;
            font-family: var(--font);
            transition: var(--transition);
        }
        .grade-input-row input[type="text"] {
            width: 140px;
            padding: 4px 10px;
            border-radius: 8px;
            border: 1px solid var(--border);
            font-size: 13px;
            font-family: var(--font);
            transition: var(--transition);
        }
        .grade-input-row input:focus {
            border-color: var(--primary);
            outline: none;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.10);
        }
        .save-grade-btn {
            padding: 4px 14px;
            border-radius: var(--radius-full);
            border: none;
            background: var(--primary);
            color: #fff;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
            transition: var(--transition);
            font-family: var(--font);
        }
        .save-grade-btn:hover {
            background: var(--primary-dark);
            transform: scale(1.04);
        }
        .graded-tag {
            font-size: 12px;
            font-weight: 600;
            color: var(--success);
            background: var(--success-bg);
            padding: 2px 10px;
            border-radius: var(--radius-full);
        }

        /* ═══════════════════════════════════════════ */
        /*  EMPTY STATE & COMING SOON                */
        /* ═══════════════════════════════════════════ */
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
        .coming-soon {
            padding: 60px 20px;
            text-align: center;
        }
        .coming-soon .icon {
            font-size: 48px;
            display: block;
            margin-bottom: 12px;
        }

        /* ═══════════════════════════════════════════ */
        /*  MODAL                                     */
        /* ═══════════════════════════════════════════ */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.50);
            backdrop-filter: blur(6px);
            z-index: 10000;
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
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.10);
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
            border-radius: var(--radius-full);
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
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        /* ═══════════════════════════════════════════ */
        /*  RESPONSIVE                                */
        /* ═══════════════════════════════════════════ */
        @media (max-width: 1024px) {
            .grid-3,
            .grid-2,
            .grid-3-cards,
            .matkul-grid {
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
                border-radius: 0;
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
            .matkul-grid {
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
            .stats-row {
                flex-direction: column;
            }
        }
        @media (max-width: 480px) {
            .grade-input-row {
                flex-direction: column;
                align-items: stretch;
            }
            .grade-input-row input[type="number"],
            .grade-input-row input[type="text"] {
                width: 100%;
            }
            .table-wrap {
                font-size: 12px;
            }
            table th,
            table td {
                padding: 8px 10px;
            }
        }
    </style>
</head>
<body>

    <!-- ─── TOAST NOTIFIKASI ─── -->
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
                <div class="avatar" id="sidebarAvatar" style="background:#8b5cf6;">{{ strtoupper(substr(session('user.name', 'DS'), 0, 2)) }}</div>
                <div>
                    <div class="user-name" id="sidebarName">{{ session('user.name', 'Dosen') }}</div>
                    <div class="user-role" id="sidebarRole">Dosen</div>
                </div>
            </div>
            <a href="/logout" class="logout-btn" onclick="return confirm('Apakah Anda yakin ingin logout?')">
                🚪 Logout
            </a>
        </div>
    </div>

    <!-- ─── MAIN ─── -->
    <div id="main">

        <!-- TOPBAR -->
        <div id="topbar">
            <div>
                <div class="welcome-title" id="welcomeTitle">
                    Selamat datang, <span id="welcomeName">{{ session('user.name', 'Dosen') }}</span> 👋
                </div>
                <div class="welcome-sub" id="welcomeSub">
                    {{ date('l, d F Y') }} · Dashboard Dosen
                </div>
            </div>
            <div class="topbar-right">
                <div class="search-wrap">
                    <span>🔍</span>
                    <input id="globalSearch" placeholder="Cari kelas, materi, atau mahasiswa..." oninput="handleGlobalSearch()" />
                </div>
                <button class="icon-btn" onclick="showToast('📬 Tidak ada notifikasi baru', '#7c3aed')">
                    🔔<span class="notif-dot">3</span>
                </button>
                <div class="avatar" id="topbarAvatar" style="background:#8b5cf6;width:34px;height:34px;font-size:12px;">
                    {{ strtoupper(substr(session('user.name', 'DS'), 0, 2)) }}
                </div>
            </div>
        </div>

        <!-- ─── FLASH MESSAGES ─── -->
        @if (session('success'))
            <div class="flash success">✅ {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="flash error">❌ {{ session('error') }}</div>
        @endif
        @if (session('warning'))
            <div class="flash warning">⚠️ {{ session('warning') }}</div>
        @endif

        <!-- ─── CONTENT ─── -->
        <div id="content">

            <!-- ═══════════════════════════════════════════ -->
            <!--  DASHBOARD                                -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="page active" id="page-dashboard">
                <div class="grid-3">
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#2dbe7c18;">📚</div>
                        <div>
                            <div class="stat-val" id="statKelas">0</div>
                            <div class="stat-label">Kelas aktif</div>
                            <div class="stat-sub" style="color:#2dbe7c;">+0 minggu ini</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#3b7fd418;">🧑‍🎓</div>
                        <div>
                            <div class="stat-val" id="statMhs">0</div>
                            <div class="stat-label">Mahasiswa terdaftar</div>
                            <div class="stat-sub" style="color:#3b7fd4;">Partisipasi 0%</div>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon" style="background:#f5a62318;">📝</div>
                        <div>
                            <div class="stat-val" id="statTugas">0</div>
                            <div class="stat-label">Tugas menunggu</div>
                            <div class="stat-sub" style="color:#f5a623;">0 butuh review</div>
                        </div>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="panel">
                        <div class="panel-title">📈 Ringkasan Kelas</div>
                        <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
                            <svg width="80" height="80" viewBox="0 0 80 80" style="flex-shrink:0;">
                                <circle cx="40" cy="40" r="30" fill="none" stroke="#eef0f6" stroke-width="8"/>
                                <circle cx="40" cy="40" r="30" fill="none" stroke="#7c3aed" stroke-width="8" stroke-dasharray="137.44 50.89" stroke-dashoffset="47.12" stroke-linecap="round"/>
                                <text x="40" y="45" text-anchor="middle" font-size="14" font-weight="700" fill="#1a2a4a">73%</text>
                            </svg>
                            <div style="flex:1;min-width:120px;">
                                <div style="font-size:12px;color:#5a6480;margin-bottom:8px;">Rata-rata kehadiran kelas</div>
                                <div style="margin-bottom:6px;">
                                    <div style="display:flex;justify-content:space-between;margin-bottom:2px;">
                                        <span style="font-size:11px;font-weight:500;">Machine Learning A</span>
                                        <span style="font-size:11px;color:#5a6480;">85%</span>
                                    </div>
                                    <div class="progress-track"><div class="progress-fill" style="width:85%;background:#7c3aed;"></div></div>
                                </div>
                                <div style="margin-bottom:6px;">
                                    <div style="display:flex;justify-content:space-between;margin-bottom:2px;">
                                        <span style="font-size:11px;font-weight:500;">NLP Dasar D</span>
                                        <span style="font-size:11px;color:#5a6480;">78%</span>
                                    </div>
                                    <div class="progress-track"><div class="progress-fill" style="width:78%;background:#8b5cf6;"></div></div>
                                </div>
                                <div>
                                    <div style="display:flex;justify-content:space-between;margin-bottom:2px;">
                                        <span style="font-size:11px;font-weight:500;">Deep Learning B</span>
                                        <span style="font-size:11px;color:#5a6480;">62%</span>
                                    </div>
                                    <div class="progress-track"><div class="progress-fill" style="width:62%;background:#a78bfa;"></div></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-title">📋 Kelas Aktif <span class="panel-badge" id="kelasCountBadge">0</span></div>
                        <div id="dashboardKelasList">
                            <div style="color:var(--text-secondary);font-size:13px;padding:8px 0;">Belum ada kelas yang diampu.</div>
                        </div>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-title">⚡ Aksi Cepat</div>
                    <div style="display:flex;flex-wrap:wrap;gap:10px;">
                        <button class="action-chip" onclick="navigate('kelola-matkul')">📚 Kelola kelas</button>
                        <button class="action-chip" onclick="navigate('persetujuan')">✅ Persetujuan</button>
                        <button class="action-chip" onclick="navigate('nilai')">📊 Nilai mahasiswa</button>
                        <button class="action-chip" onclick="navigate('materi-tugas')">📝 Materi & Tugas</button>
                    </div>
                </div>

                <div class="panel">
                    <div class="panel-title">👨‍🏫 Aktivitas Terbaru</div>
                    <div class="grid-3-cards">
                        <div class="dosen-card">
                            <div class="avatar" style="width:52px;height:52px;font-size:16px;background:#1a2a4a;margin:0 auto 8px;">SS</div>
                            <div style="font-weight:600;font-size:14px;">Severus Snape</div>
                            <div style="font-size:11px;color:#5a6480;margin-bottom:10px;">Dosen</div>
                            <div class="dosen-stats">
                                <div><div class="dosen-stat-val" style="color:#e74c3c;">78</div><div class="dosen-stat-label">Kuliah</div></div>
                                <div><div class="dosen-stat-val" style="color:#3b7fd4;">4.9</div><div class="dosen-stat-label">Nilai</div></div>
                                <div><div class="dosen-stat-val" style="color:#2dbe7c;">6 thn</div><div class="dosen-stat-label">Pengalaman</div></div>
                            </div>
                        </div>
                        <div class="dosen-card">
                            <div class="avatar" style="width:52px;height:52px;font-size:16px;background:#3b7fd4;margin:0 auto 8px;">LP</div>
                            <div style="font-weight:600;font-size:14px;">Lily Potter</div>
                            <div style="font-size:11px;color:#5a6480;margin-bottom:10px;">Dosen</div>
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

            <!-- ═══════════════════════════════════════════ -->
            <!--  KELOLA MATA KULIAH                       -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="page" id="page-kelola-matkul">
                <div class="page-header-row">
                    <div class="page-header" style="margin-bottom:0;">
                        <h2>🗃️ Kelola Mata Kuliah</h2>
                        <p>Buat dan kelola kelas yang kamu ampu. Kelas aktif akan muncul di halaman pencarian mahasiswa.</p>
                    </div>
                    <button class="add-btn" onclick="openKelasModal()"><span>➕</span>Tambah Kelas</button>
                </div>
                <div class="matkul-grid" id="matkulGrid"></div>
                <div class="empty-state" id="matkulEmpty" style="display:none;">
                    <span class="empty-icon">📭</span>
                    Kamu belum membuat kelas. Klik "Tambah Kelas" untuk memulai.
                </div>
            </div>

            <!-- ═══════════════════════════════════════════ -->
            <!--  PERSETUJUAN                              -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="page" id="page-persetujuan">
                <div class="page-header">
                    <h2>✅ Persetujuan Pendaftaran</h2>
                    <p>Kelola pengajuan pendaftaran dari mahasiswa ke kelas yang kamu ampu.</p>
                </div>
                <div class="stats-row">
                    <div class="mini-stat" style="background:#fff8ec;border-color:#fef3c7;">
                        <div class="mini-stat-val" style="color:#b07a00;" id="countPending">0</div>
                        <div class="mini-stat-label" style="color:#9a6a00;">⏳ Menunggu</div>
                    </div>
                    <div class="mini-stat" style="background:#e8f9f1;border-color:#dcfce7;">
                        <div class="mini-stat-val" style="color:#1a7a4a;" id="countApproved">0</div>
                        <div class="mini-stat-label" style="color:#1a7a4a;">✅ Disetujui</div>
                    </div>
                    <div class="mini-stat" style="background:#fdecea;border-color:#fee2e2;">
                        <div class="mini-stat-val" style="color:#a82b1e;" id="countRejected">0</div>
                        <div class="mini-stat-label" style="color:#a82b1e;">❌ Ditolak</div>
                    </div>
                </div>
                <div class="filter-row" id="enrollFilterRow"></div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Mahasiswa</th>
                                <th>NIM</th>
                                <th>Kelas</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="enrollTbody"></tbody>
                    </table>
                    <div class="empty-state" id="enrollEmpty" style="display:none;">
                        <span class="empty-icon">📭</span>
                        Tidak ada data untuk filter ini.
                    </div>
                </div>
            </div>

            <!-- ═══════════════════════════════════════════ -->
            <!--  MATERI & TUGAS (DOSEN)                   -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="page" id="page-materi-tugas">
                <div class="page-header-row">
                    <div class="page-header" style="margin-bottom:0;">
                        <h2 id="mtTitle">📂 Materi & Tugas</h2>
                        <p id="mtSub">Unggah materi kuliah dan buat tugas untuk kelas yang kamu ampu.</p>
                    </div>
                    <button class="add-btn" id="mtAddBtn" onclick="handleMtAdd()" style="display:none;"><span>➕</span>Tambah</button>
                </div>
                <div class="kelas-select-row">
                    <select id="mtKelasSelect" onchange="onMtKelasChange()">
                        <option value="">-- Pilih Kelas --</option>
                    </select>
                </div>
                <div id="mtEmpty" class="empty-state" style="display:none;">
                    <span class="empty-icon">📭</span>
                    <span id="mtEmptyText">Belum ada kelas yang tersedia.</span>
                </div>
                <div id="mtBody" style="display:none;">
                    <div class="tab-row">
                        <button class="tab-btn active" id="tabMateri" onclick="switchMtTab('materi')">📄 Materi</button>
                        <button class="tab-btn" id="tabTugas" onclick="switchMtTab('tugas')">📝 Tugas</button>
                    </div>
                    <div class="tab-content active" id="tabMateriContent"></div>
                    <div class="tab-content" id="tabTugasContent"></div>
                </div>
            </div>

            <!-- ═══════════════════════════════════════════ -->
            <!--  NILAI (DOSEN)                            -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="page" id="page-nilai">
                <div class="page-header">
                    <h2 id="nilaiTitle">🏆 Penilaian Tugas</h2>
                    <p id="nilaiSub">Periksa dan beri nilai pada tugas yang dikumpulkan mahasiswa.</p>
                </div>
                <div class="kelas-select-row" id="nilaiDosenWrap">
                    <select id="nilaiKelasSelect" onchange="renderNilaiDosen()">
                        <option value="">-- Pilih Kelas --</option>
                    </select>
                </div>
                <div id="nilaiContent"></div>
            </div>

            <!-- ═══════════════════════════════════════════ -->
            <!--  COMING SOON                              -->
            <!-- ═══════════════════════════════════════════ -->
            <div class="page" id="page-jadwal">
                <div class="coming-soon">
                    <span class="icon">🚧</span>
                    <div style="font-size:18px;font-weight:600;color:#0f172a;">Halaman Jadwal</div>
                    <div style="font-size:13px;color:var(--text-secondary);">Fitur akan segera tersedia.</div>
                </div>
            </div>
            <div class="page" id="page-laporan">
                <div class="coming-soon">
                    <span class="icon">🚧</span>
                    <div style="font-size:18px;font-weight:600;color:#0f172a;">Halaman Laporan</div>
                    <div style="font-size:13px;color:var(--text-secondary);">Fitur akan segera tersedia.</div>
                </div>
            </div>
            <div class="page" id="page-dosen">
                <div class="coming-soon">
                    <span class="icon">🚧</span>
                    <div style="font-size:18px;font-weight:600;color:#0f172a;">Halaman Dosen</div>
                    <div style="font-size:13px;color:var(--text-secondary);">Fitur akan segera tersedia.</div>
                </div>
            </div>

        </div><!-- /content -->
    </div><!-- /main -->

    <!-- ═══════════════════════════════════════════════════════════ -->
    <!--  MODALS                                                  -->
    <!-- ═══════════════════════════════════════════════════════════ -->

    <!-- MODAL: Kelas -->
    <div class="modal-overlay" id="modalKelas">
        <div class="modal-box">
            <div class="modal-title" id="modalKelasTitle">📚 Tambah Kelas Baru</div>
            <div class="form-group">
                <label>Nama Mata Kuliah</label>
                <input type="text" id="kfNama" placeholder="mis. Algoritma & Struktur Data" />
            </div>
            <div class="form-row-2">
                <div class="form-group">
                    <label>Hari & Jam</label>
                    <input type="text" id="kfJadwal" placeholder="Senin, 08:00–10:00" />
                </div>
                <div class="form-group">
                    <label>Ruang</label>
                    <input type="text" id="kfRuang" placeholder="Lab A-301" />
                </div>
            </div>
            <div class="form-row-2">
                <div class="form-group">
                    <label>Kapasitas</label>
                    <input type="number" id="kfKapasitas" min="1" placeholder="30" />
                </div>
                <div class="form-group">
                    <label>Kategori</label>
                    <select id="kfTag">
                        <option value="AI/ML">AI/ML</option>
                        <option value="Vision">Vision</option>
                        <option value="NLP">NLP</option>
                        <option value="Data">Data</option>
                        <option value="Cloud">Cloud</option>
                    </select>
                </div>
            </div>
            <div class="modal-actions">
                <button class="btn-secondary" onclick="closeModal('modalKelas')">Batal</button>
                <button class="btn-primary" onclick="saveKelas()">Simpan Kelas</button>
            </div>
        </div>
    </div>

    <!-- MODAL: Materi -->
    <div class="modal-overlay" id="modalMateri">
        <div class="modal-box">
            <div class="modal-title">📄 Tambah Materi Kuliah</div>
            <div class="form-group">
                <label>Judul Materi</label>
                <input type="text" id="mfJudul" placeholder="Pengenalan Neural Network" />
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea id="mfDeskripsi" placeholder="Ringkasan singkat isi materi..."></textarea>
            </div>
            <div class="modal-actions">
                <button class="btn-secondary" onclick="closeModal('modalMateri')">Batal</button>
                <button class="btn-primary" onclick="saveMateri()">Unggah Materi</button>
            </div>
        </div>
    </div>

    <!-- MODAL: Tugas -->
    <div class="modal-overlay" id="modalTugas">
        <div class="modal-box">
            <div class="modal-title">📝 Buat Tugas Baru</div>
            <div class="form-group">
                <label>Judul Tugas</label>
                <input type="text" id="tfJudul" placeholder="Tugas 2: Klasifikasi Gambar" />
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea id="tfDeskripsi" placeholder="Instruksi pengerjaan tugas..."></textarea>
            </div>
            <div class="form-group">
                <label>Tenggat Waktu</label>
                <input type="text" id="tfDeadline" placeholder="mis. 30 Jul 2026" />
            </div>
            <div class="modal-actions">
                <button class="btn-secondary" onclick="closeModal('modalTugas')">Batal</button>
                <button class="btn-primary" onclick="saveTugas()">Buat Tugas</button>
            </div>
        </div>
    </div>

    <script>
        // ═══════════════════════════════════════════════════════════
        //  DATA
        // ═══════════════════════════════════════════════════════════

        let kelasList = [
            { id: 1, nama: "Machine Learning A", dosen: "Dr. Severus Snape", jadwal: "Senin, 08:00–10:00",
                ruang: "Lab A-301", kapasitas: 30, terdaftar: 22, status: "active", tag: "AI/ML" },
            { id: 2, nama: "Deep Learning B", dosen: "Prof. Lily Potter", jadwal: "Selasa, 13:00–15:00",
                ruang: "Lab B-202", kapasitas: 25, terdaftar: 19, status: "active", tag: "AI/ML" },
            { id: 3, nama: "Computer Vision C", dosen: "Dr. Harry Potter", jadwal: "Rabu, 10:00–12:00",
                ruang: "Lab A-105", kapasitas: 20, terdaftar: 15, status: "active", tag: "Vision" },
            { id: 4, nama: "NLP Dasar D", dosen: "Dr. Severus Snape", jadwal: "Kamis, 14:00–16:00",
                ruang: "Lab C-401", kapasitas: 35, terdaftar: 28, status: "active", tag: "NLP" },
            { id: 5, nama: "Data Engineering E", dosen: "Prof. Lily Potter", jadwal: "Jumat, 09:00–11:00",
                ruang: "Lab B-103", kapasitas: 28, terdaftar: 10, status: "active", tag: "Data" },
            { id: 6, nama: "Cloud Computing F", dosen: "Dr. Harry Potter", jadwal: "Senin, 13:00–15:00",
                ruang: "Lab D-201", kapasitas: 30, terdaftar: 30, status: "full", tag: "Cloud" },
        ];

        let enrollments = [
            { id: 1, studentName: "Andi Pratama", nim: "2021001", avatar: "AP", kelas: "Machine Learning A",
                status: "pending", tanggal: "18 Jul 2026" },
            { id: 2, studentName: "Budi Santoso", nim: "2021002", avatar: "BS", kelas: "Deep Learning B",
                status: "pending", tanggal: "18 Jul 2026" },
            { id: 3, studentName: "Citra Dewi", nim: "2021003", avatar: "CD", kelas: "Machine Learning A",
                status: "approved", tanggal: "17 Jul 2026" },
            { id: 4, studentName: "Dian Rahayu", nim: "2021004", avatar: "DR", kelas: "Computer Vision C",
                status: "pending", tanggal: "19 Jul 2026" },
            { id: 5, studentName: "Eko Widodo", nim: "2021005", avatar: "EW", kelas: "Deep Learning B",
                status: "rejected", tanggal: "16 Jul 2026" },
            { id: 6, studentName: "Fitri Handayani", nim: "2021006", avatar: "FH", kelas: "NLP Dasar D",
                status: "pending", tanggal: "19 Jul 2026" },
            { id: 7, studentName: "Harry Potter", nim: "2021099", avatar: "HP", kelas: "Machine Learning A",
                status: "approved", tanggal: "12 Jul 2026" },
        ];

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

        // ═══════════════════════════════════════════════════════════
        //  STATE
        // ═══════════════════════════════════════════════════════════

        let activePage = "dashboard";
        let enrollFilter = "all";
        let mtActiveTab = "materi";
        let mtSelectedKelas = null;
        let nilaiSelectedKelas = null;
        let editingKelasId = null;
        let nextKelasId = 7;
        let nextEnrollId = 8;
        let nextAssignmentId = 3;

        const DOSEN_NAME = "Dr. Severus Snape";
        const tagColors = { "AI/ML": "#3b7fd4", "Vision": "#8e44ad", "NLP": "#2dbe7c", "Data": "#f5a623",
        "Cloud": "#e74c3c" };
        const avatarColors = ["#1a5fa0", "#2dbe7c", "#8e44ad", "#e74c3c", "#f5a623", "#0f6e56"];

        const navDosen = [
            { icon: "📊", label: "Dashboard", key: "dashboard" },
            { icon: "🗃️", label: "Kelola Mata Kuliah", key: "kelola-matkul" },
            { icon: "✅", label: "Persetujuan", key: "persetujuan" },
            { icon: "📂", label: "Materi & Tugas", key: "materi-tugas" },
            { icon: "🏆", label: "Nilai", key: "nilai" },
            { icon: "📅", label: "Jadwal", key: "jadwal" },
            { icon: "📝", label: "Laporan", key: "laporan" },
            { icon: "👨‍🏫", label: "Dosen", key: "dosen" },
        ];

        // ═══════════════════════════════════════════════════════════
        //  HELPERS
        // ═══════════════════════════════════════════════════════════

        function showToast(msg, color = "#7c3aed") {
            const t = document.getElementById("toast");
            t.textContent = msg;
            t.style.background = color;
            t.style.display = "block";
            clearTimeout(t._hide);
            t._hide = setTimeout(() => { t.style.display = "none"; }, 3200);
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove("active");
        }

        function openModal(id) {
            document.getElementById(id).classList.add("active");
        }

        function getTagColor(tag) {
            return tagColors[tag] || "#7c3aed";
        }

        function getAvatarColor(id) {
            return avatarColors[id % avatarColors.length];
        }

        // ═══════════════════════════════════════════════════════════
        //  NAVIGATION
        // ═══════════════════════════════════════════════════════════

        function renderNav() {
            const nav = document.getElementById("nav");
            nav.innerHTML = navDosen.map(item => `
                <button class="nav-btn ${activePage === item.key ? 'active' : ''}" onclick="navigate('${item.key}')">
                    <span class="nav-icon">${item.icon}</span>
                    ${item.label}
                    ${item.key === 'persetujuan' ? `<span class="nav-badge" id="pendingBadge">0</span>` : ''}
                </button>
            `).join("");
            updatePendingBadge();
        }

        function updatePendingBadge() {
            const pending = enrollments.filter(e => e.status === "pending").length;
            const badge = document.getElementById("pendingBadge");
            if (badge) badge.textContent = pending;
        }

        function updatePageLabel() {
            const found = navDosen.find(n => n.key === activePage);
            document.getElementById("welcomeSub").textContent =
                `${new Date().toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })} · ${found ? found.label : 'Dashboard'}`;
        }

        function navigate(page) {
            document.querySelectorAll(".page").forEach(p => p.classList.remove("active"));
            const el = document.getElementById("page-" + page);
            if (el) el.classList.add("active");
            activePage = page;
            renderNav();
            updatePageLabel();

            switch (page) {
                case "kelola-matkul":
                    renderKelola();
                    break;
                case "persetujuan":
                    renderEnrollments();
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

        // ═══════════════════════════════════════════════════════════
        //  DASHBOARD
        // ═══════════════════════════════════════════════════════════

        function updateDashboardStats() {
            const myKelas = kelasList.filter(k => k.dosen === DOSEN_NAME);
            const totalMhs = myKelas.reduce((sum, k) => sum + k.terdaftar, 0);
            const totalTugas = Object.values(assignmentsData).reduce((sum, arr) => sum + arr.length, 0);
            const pendingCount = enrollments.filter(e => e.status === "pending").length;

            document.getElementById("statKelas").textContent = myKelas.length || 0;
            document.getElementById("statMhs").textContent = totalMhs;
            document.getElementById("statTugas").textContent = pendingCount;

            // Update badge
            document.getElementById("kelasCountBadge").textContent = myKelas.length;

            // Update daftar kelas di dashboard
            const container = document.getElementById("dashboardKelasList");
            if (myKelas.length === 0) {
                container.innerHTML =
                    `<div style="color:var(--text-secondary);font-size:13px;padding:8px 0;">Belum ada kelas yang diampu.</div>`;
                return;
            }
            container.innerHTML = myKelas.slice(0, 4).map(k =>
                `<div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;padding:6px 0;border-bottom:1px solid #f1f5f9;">
                    <span class="tag-pill" style="background:${getTagColor(k.tag)}18;color:${getTagColor(k.tag)};font-size:10px;">${k.tag}</span>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:12px;font-weight:500;color:#0f172a;">${k.nama}</div>
                        <div style="font-size:11px;color:#64748b;">${k.terdaftar}/${k.kapasitas} mahasiswa</div>
                    </div>
                    <span class="badge ${k.status === 'full' ? 'badge-full' : 'badge-active'}">${k.status === 'full' ? 'Penuh' : 'Aktif'}</span>
                </div>`
            ).join("");
        }

        // ═══════════════════════════════════════════════════════════
        //  KELOLA MATA KULIAH (DOSEN)
        // ═══════════════════════════════════════════════════════════

        function renderKelola() {
            const myKelas = kelasList.filter(k => k.dosen === DOSEN_NAME);
            const grid = document.getElementById("matkulGrid");
            const empty = document.getElementById("matkulEmpty");
            if (myKelas.length === 0) { grid.innerHTML = "";
                empty.style.display = "block"; return; }
            empty.style.display = "none";
            grid.innerHTML = myKelas.map(k => {
                const pct = Math.round((k.terdaftar / k.kapasitas) * 100);
                const tc = getTagColor(k.tag);
                const badgeHtml = k.status === "full" ?
                    `<span class="badge badge-full">Penuh</span>` :
                    `<span class="badge badge-active">Aktif</span>`;
                const barColor = pct >= 90 ? "#e74c3c" : pct >= 70 ? "#f5a623" : "#2dbe7c";
                return `
                    <div class="matkul-card">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:8px;">
                            <div>
                                <span class="tag-pill" style="background:${tc}18;color:${tc};margin-bottom:5px;">${k.tag}</span>
                                <div class="kelas-name">${k.nama}</div>
                            </div>
                            ${badgeHtml}
                        </div>
                        <div class="kelas-meta">🕐 ${k.jadwal}</div>
                        <div class="kelas-meta" style="margin-bottom:10px;">📍 ${k.ruang}</div>
                        <div class="cap-row">
                            <span class="cap-label">Kapasitas</span>
                            <span style="font-size:11px;font-weight:500;color:#1a2a4a;">${k.terdaftar}/${k.kapasitas} (${pct}%)</span>
                        </div>
                        <div class="progress-track"><div class="progress-fill" style="width:${pct}%;background:${barColor};"></div></div>
                        <div class="matkul-actions">
                            <button class="btn-secondary" onclick="openKelasModal(${k.id})">✏️ Edit</button>
                            <button class="btn-secondary" onclick="toggleKelasStatus(${k.id})">${k.status === "full" ? "🔓 Buka" : "🔒 Tutup"}</button>
                            <button class="btn-danger" onclick="deleteKelas(${k.id})">🗑️ Hapus</button>
                        </div>
                    </div>
                `;
            }).join("");
        }

        function openKelasModal(id) {
            editingKelasId = id || null;
            const title = document.getElementById("modalKelasTitle");
            if (id) {
                const k = kelasList.find(x => x.id === id);
                title.textContent = "✏️ Edit Kelas";
                document.getElementById("kfNama").value = k.nama;
                document.getElementById("kfJadwal").value = k.jadwal;
                document.getElementById("kfRuang").value = k.ruang;
                document.getElementById("kfKapasitas").value = k.kapasitas;
                document.getElementById("kfTag").value = k.tag;
            } else {
                title.textContent = "📚 Tambah Kelas Baru";
                document.getElementById("kfNama").value = "";
                document.getElementById("kfJadwal").value = "";
                document.getElementById("kfRuang").value = "";
                document.getElementById("kfKapasitas").value = "";
                document.getElementById("kfTag").value = "AI/ML";
            }
            openModal("modalKelas");
        }

        function saveKelas() {
            const nama = document.getElementById("kfNama").value.trim();
            const jadwal = document.getElementById("kfJadwal").value.trim();
            const ruang = document.getElementById("kfRuang").value.trim();
            const kapasitas = parseInt(document.getElementById("kfKapasitas").value) || 30;
            const tag = document.getElementById("kfTag").value;
            if (!nama || !jadwal || !ruang) { showToast("⚠ Lengkapi semua kolom", "#dc2626"); return; }
            if (editingKelasId) {
                const k = kelasList.find(x => x.id === editingKelasId);
                Object.assign(k, { nama, jadwal, ruang, kapasitas, tag });
                showToast(`✅ Kelas "${nama}" diperbarui`, "#16a34a");
            } else {
                kelasList.push({ id: nextKelasId++, nama, dosen: DOSEN_NAME, jadwal, ruang, kapasitas, terdaftar: 0,
                    status: "active", tag });
                showToast(`✅ Kelas "${nama}" berhasil dibuat`, "#16a34a");
            }
            closeModal("modalKelas");
            renderKelola();
            updateDashboardStats();
        }

        function toggleKelasStatus(id) {
            const k = kelasList.find(x => x.id === id);
            if (!k) return;
            k.status = k.status === "full" ? "active" : "full";
            renderKelola();
            updateDashboardStats();
        }

        function deleteKelas(id) {
            if (!confirm("Yakin ingin menghapus kelas ini?")) return;
            const idx = kelasList.findIndex(x => x.id === id);
            if (idx === -1) return;
            const nama = kelasList[idx].nama;
            kelasList.splice(idx, 1);
            showToast(`🗑️ Kelas "${nama}" dihapus`, "#dc2626");
            renderKelola();
            updateDashboardStats();
        }

        // ═══════════════════════════════════════════════════════════
        //  PERSETUJUAN (DOSEN)
        // ═══════════════════════════════════════════════════════════

        function renderEnrollmentFilter() {
            const pending = enrollments.filter(e => e.status === "pending").length;
            const approved = enrollments.filter(e => e.status === "approved").length;
            const rejected = enrollments.filter(e => e.status === "rejected").length;
            document.getElementById("countPending").textContent = pending;
            document.getElementById("countApproved").textContent = approved;
            document.getElementById("countRejected").textContent = rejected;
            const filters = [
                { val: "all", label: `📋 Semua` },
                { val: "pending", label: `⏳ Menunggu (${pending})` },
                { val: "approved", label: `✅ Disetujui (${approved})` },
                { val: "rejected", label: `❌ Ditolak (${rejected})` },
            ];
            document.getElementById("enrollFilterRow").innerHTML = filters.map(f =>
                `<button class="filter-btn ${enrollFilter === f.val ? 'active' : ''}" onclick="setEnrollFilter('${f.val}')">${f.label}</button>`
            ).join("");
        }

        function setEnrollFilter(f) { enrollFilter = f;
            renderEnrollments(); }

        function renderEnrollments() {
            renderEnrollmentFilter();
            const filtered = enrollFilter === "all" ? enrollments : enrollments.filter(e => e.status === enrollFilter);
            const tbody = document.getElementById("enrollTbody");
            const empty = document.getElementById("enrollEmpty");
            if (filtered.length === 0) { tbody.innerHTML = "";
                empty.style.display = "block"; return; }
            empty.style.display = "none";
            tbody.innerHTML = filtered.map((e, idx) => {
                const avColor = getAvatarColor(e.id);
                let badgeHtml = "";
                if (e.status === "pending") badgeHtml = `<span class="badge badge-pending">⏳ Pending</span>`;
                else if (e.status === "approved") badgeHtml = `<span class="badge badge-approved">✅ Disetujui</span>`;
                else if (e.status === "rejected") badgeHtml = `<span class="badge badge-rejected">❌ Ditolak</span>`;
                let actionHtml = "";
                if (e.status === "pending") {
                    actionHtml =
                        `<div class="action-btns"><button class="approve-btn" onclick="updateEnrollStatus(${e.id},'approved')">✅ Terima</button><button class="reject-btn" onclick="updateEnrollStatus(${e.id},'rejected')">❌ Tolak</button></div>`;
                } else {
                    actionHtml = `<span style="font-size:12px;color:#94a3b8;font-weight:500;">Selesai</span>`;
                }
                return `
                    <tr>
                        <td>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div class="avatar" style="width:28px;height:28px;font-size:10px;background:${avColor};">${e.avatar}</div>
                                <span style="font-weight:500;">${e.studentName}</span>
                            </div>
                        </td>
                        <td>${e.nim}</td>
                        <td>${e.kelas}</td>
                        <td>${e.tanggal}</td>
                        <td>${badgeHtml}</td>
                        <td>${actionHtml}</td>
                    </tr>
                `;
            }).join("");
            updatePendingBadge();
        }

        function updateEnrollStatus(id, newStatus) {
            const enrollment = enrollments.find(e => e.id === id);
            if (!enrollment) return;
            enrollment.status = newStatus;
            if (newStatus === "approved") {
                const k = kelasList.find(x => x.nama === enrollment.kelas);
                if (k) k.terdaftar = Math.min(k.kapasitas, k.terdaftar + 1);
                showToast(`✅ Pendaftaran ${enrollment.studentName} disetujui`, "#16a34a");
            } else {
                showToast(`❌ Pendaftaran ${enrollment.studentName} ditolak`, "#dc2626");
            }
            renderEnrollments();
            updateDashboardStats();
        }

        // ═══════════════════════════════════════════════════════════
        //  MATERI & TUGAS (DOSEN)
        // ═══════════════════════════════════════════════════════════

        function getMtKelasOptions() {
            return kelasList.filter(k => k.dosen === DOSEN_NAME).map(k => k.nama);
        }

        function renderMateriTugas() {
            document.getElementById("mtTitle").textContent = "📂 Materi & Tugas";
            document.getElementById("mtSub").textContent = "Unggah materi kuliah dan buat tugas untuk kelas yang kamu ampu.";

            const options = getMtKelasOptions();
            const select = document.getElementById("mtKelasSelect");
            const empty = document.getElementById("mtEmpty");
            const body = document.getElementById("mtBody");
            const addBtn = document.getElementById("mtAddBtn");

            if (options.length === 0) {
                select.innerHTML = `<option value="">-- Pilih Kelas --</option>`;
                body.style.display = "none";
                addBtn.style.display = "none";
                empty.style.display = "block";
                document.getElementById("mtEmptyText").textContent =
                    "Kamu belum memiliki kelas. Buat kelas di menu \"Kelola Mata Kuliah\".";
                return;
            }
            empty.style.display = "none";
            body.style.display = "block";
            addBtn.style.display = "flex";

            if (!mtSelectedKelas || !options.includes(mtSelectedKelas)) mtSelectedKelas = options[0];
            select.innerHTML = `<option value="">-- Pilih Kelas --</option>` +
                options.map(k => `<option value="${k}" ${k===mtSelectedKelas?"selected":""}>${k}</option>`).join("");

            switchMtTab(mtActiveTab);
        }

        function onMtKelasChange() {
            const val = document.getElementById("mtKelasSelect").value;
            if (!val) {
                document.getElementById("mtBody").style.display = "none";
                return;
            }
            mtSelectedKelas = val;
            document.getElementById("mtBody").style.display = "block";
            switchMtTab(mtActiveTab);
        }

        function switchMtTab(tab) {
            mtActiveTab = tab;
            document.getElementById("tabMateri").classList.toggle("active", tab === "materi");
            document.getElementById("tabTugas").classList.toggle("active", tab === "tugas");
            document.getElementById("tabMateriContent").classList.toggle("active", tab === "materi");
            document.getElementById("tabTugasContent").classList.toggle("active", tab === "tugas");

            const addBtn = document.getElementById("mtAddBtn");
            addBtn.innerHTML = tab === "materi" ? '<span>➕</span> Tambah Materi' :
                '<span>➕</span> Buat Tugas';

            if (tab === "materi") renderMateriList();
            else renderTugasList();
        }

        function handleMtAdd() {
            if (mtActiveTab === "materi") openModal("modalMateri");
            else openModal("modalTugas");
        }

        function renderMateriList() {
            if (!mtSelectedKelas) return;
            const list = materialsData[mtSelectedKelas] || [];
            const el = document.getElementById("tabMateriContent");
            if (list.length === 0) {
                el.innerHTML =
                    `<div class="empty-state"><span class="empty-icon">📭</span>Belum ada materi untuk kelas ini.</div>`;
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

        function saveMateri() {
            const judul = document.getElementById("mfJudul").value.trim();
            const deskripsi = document.getElementById("mfDeskripsi").value.trim();
            if (!judul) { showToast("⚠ Judul materi wajib diisi", "#dc2626"); return; }
            if (!materialsData[mtSelectedKelas]) materialsData[mtSelectedKelas] = [];
            materialsData[mtSelectedKelas].push({ id: Date.now(), judul, deskripsi: deskripsi || "-", tanggal: new Date()
                    .toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) });
            document.getElementById("mfJudul").value = "";
            document.getElementById("mfDeskripsi").value = "";
            closeModal("modalMateri");
            showToast(`✅ Materi "${judul}" berhasil diunggah`, "#16a34a");
            renderMateriList();
        }

        function renderTugasList() {
            if (!mtSelectedKelas) return;
            const list = assignmentsData[mtSelectedKelas] || [];
            const el = document.getElementById("tabTugasContent");
            if (list.length === 0) {
                el.innerHTML =
                    `<div class="empty-state"><span class="empty-icon">📭</span>Belum ada tugas untuk kelas ini.</div>`;
                return;
            }
            el.innerHTML = list.map(a => {
                const graded = a.submissions.filter(s => s.nilai !== null).length;
                return `<div class="assignment-item">
                    <div class="assignment-item-title">📝 ${a.judul}</div>
                    <div class="assignment-item-desc">${a.deskripsi}</div>
                    <div class="assignment-item-meta">📅 Tenggat: ${a.deadline} · 📤 ${a.submissions.length} pengumpulan · ✅ ${graded} dinilai</div>
                </div>`;
            }).join("");
        }

        function saveTugas() {
            const judul = document.getElementById("tfJudul").value.trim();
            const deskripsi = document.getElementById("tfDeskripsi").value.trim();
            const deadline = document.getElementById("tfDeadline").value.trim();
            if (!judul || !deadline) { showToast("⚠ Judul dan tenggat waktu wajib diisi", "#dc2626"); return; }
            if (!assignmentsData[mtSelectedKelas]) assignmentsData[mtSelectedKelas] = [];
            assignmentsData[mtSelectedKelas].push({ id: nextAssignmentId++, judul, deskripsi: deskripsi || "-", deadline,
                submissions: [] });
            document.getElementById("tfJudul").value = "";
            document.getElementById("tfDeskripsi").value = "";
            document.getElementById("tfDeadline").value = "";
            closeModal("modalTugas");
            showToast(`✅ Tugas "${judul}" berhasil dibuat`, "#16a34a");
            renderTugasList();
        }

        // ═══════════════════════════════════════════════════════════
        //  NILAI (DOSEN)
        // ═══════════════════════════════════════════════════════════

        function renderNilai() {
            document.getElementById("nilaiTitle").textContent = "🏆 Penilaian Tugas";
            document.getElementById("nilaiSub").textContent = "Periksa dan beri nilai pada tugas yang dikumpulkan mahasiswa.";

            const options = kelasList.filter(k => k.dosen === DOSEN_NAME).map(k => k.nama);
            const select = document.getElementById("nilaiKelasSelect");
            if (options.length === 0) {
                select.innerHTML = `<option value="">-- Pilih Kelas --</option>`;
                document.getElementById("nilaiContent").innerHTML =
                    `<div class="empty-state"><span class="empty-icon">📭</span>Kamu belum memiliki kelas untuk dinilai.</div>`;
                return;
            }
            if (!nilaiSelectedKelas || !options.includes(nilaiSelectedKelas)) nilaiSelectedKelas = options[0];
            select.innerHTML = `<option value="">-- Pilih Kelas --</option>` +
                options.map(k => `<option value="${k}" ${k===nilaiSelectedKelas?"selected":""}>${k}</option>`).join("");
            renderNilaiDosen();
        }

        function renderNilaiDosen() {
            const val = document.getElementById("nilaiKelasSelect").value;
            if (!val) {
                document.getElementById("nilaiContent").innerHTML =
                    `<div class="empty-state"><span class="empty-icon">👆</span>Pilih kelas terlebih dahulu.</div>`;
                return;
            }
            nilaiSelectedKelas = val;
            const list = assignmentsData[nilaiSelectedKelas] || [];
            const content = document.getElementById("nilaiContent");

            if (list.length === 0 || list.every(a => a.submissions.length === 0)) {
                content.innerHTML =
                    `<div class="empty-state"><span class="empty-icon">📭</span>Belum ada tugas terkumpul untuk kelas ini.</div>`;
                return;
            }

            content.innerHTML = list.map(a => {
                if (a.submissions.length === 0) return "";
                const rows = a.submissions.map((s, i) => {
                    const avColor = getAvatarColor(i);
                    const gradedBadge = s.nilai !== null ?
                        `<span class="graded-tag">✅ Nilai: ${s.nilai}</span>` : "";
                    return `
                        <div class="submission-mini">
                            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                                <div class="avatar" style="width:26px;height:26px;font-size:10px;background:${avColor};">${s.avatar}</div>
                                <span style="font-weight:500;">${s.studentName}</span>
                                <span style="color:#94a3b8;font-size:12px;">${s.fileName}</span>
                            </div>
                            <div class="grade-input-row">
                                <input type="number" min="0" max="100" placeholder="Nilai" id="gradeVal-${a.id}-${i}" value="${s.nilai ?? ''}" />
                                <input type="text" placeholder="Feedback" id="gradeFb-${a.id}-${i}" value="${s.feedback ?? ''}" />
                                <button class="save-grade-btn" onclick="saveGrade(${a.id}, ${i})">💾 Simpan</button>
                                ${gradedBadge}
                            </div>
                        </div>
                    `;
                }).join("");
                return `<div class="panel" style="margin-bottom:14px;"><div class="panel-title">📝 ${a.judul}</div>${rows}</div>`;
            }).join("");
        }

        function saveGrade(assignmentId, idx) {
            const a = (assignmentsData[nilaiSelectedKelas] || []).find(x => x.id === assignmentId);
            if (!a) return;
            const nilaiVal = document.getElementById(`gradeVal-${assignmentId}-${idx}`).value;
            const fbVal = document.getElementById(`gradeFb-${assignmentId}-${idx}`).value;
            if (nilaiVal === "" || isNaN(nilaiVal)) { showToast("⚠ Masukkan nilai yang valid", "#dc2626"); return; }
            a.submissions[idx].nilai = parseInt(nilaiVal);
            a.submissions[idx].feedback = fbVal || "-";
            showToast(`✅ Nilai ${a.submissions[idx].studentName} disimpan`, "#16a34a");
            renderNilaiDosen();
        }

        // ═══════════════════════════════════════════════════════════
        //  GLOBAL SEARCH
        // ═══════════════════════════════════════════════════════════

        function handleGlobalSearch() {
            const q = document.getElementById("globalSearch").value.toLowerCase().trim();
            if (!q) return;
            // Cari di kelas
            const foundKelas = kelasList.filter(k => k.nama.toLowerCase().includes(q) ||
                k.dosen.toLowerCase().includes(q) ||
                k.tag.toLowerCase().includes(q));
            if (foundKelas.length > 0) {
                navigate("kelola-matkul");
                showToast(`🔍 Ditemukan ${foundKelas.length} kelas`, "#7c3aed");
                return;
            }
            // Cari di mahasiswa (enrollments)
            const foundMhs = enrollments.filter(e => e.studentName.toLowerCase().includes(q) ||
                e.nim.includes(q) ||
                e.kelas.toLowerCase().includes(q));
            if (foundMhs.length > 0) {
                navigate("persetujuan");
                showToast(`🔍 Ditemukan ${foundMhs.length} pendaftaran`, "#7c3aed");
                return;
            }
            // Cari di materi
            for (const [kelas, items] of Object.entries(materialsData)) {
                const found = items.filter(m => m.judul.toLowerCase().includes(q) ||
                    m.deskripsi.toLowerCase().includes(q));
                if (found.length > 0) {
                    navigate("materi-tugas");
                    mtSelectedKelas = kelas;
                    renderMateriTugas();
                    showToast(`📄 Ditemukan ${found.length} materi di "${kelas}"`, "#7c3aed");
                    return;
                }
            }
            showToast(`🔍 Tidak ditemukan hasil untuk "${q}"`, "#f59e0b");
        }

        // ═══════════════════════════════════════════════════════════
        //  INIT
        // ═══════════════════════════════════════════════════════════

        function init() {
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