<?php
if (session_status() == PHP_SESSION_NONE) session_start();
$active = $active ?? '';
$title = $title ?? 'Dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?> | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
        }
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background: #111827;
            color: #fff;
            position: fixed;
            left: 0;
            top: 0;
            transition: 0.3s;
            z-index: 1040;
        }
        .sidebar.collapsed {
            width: 80px;
        }
        .sidebar .brand {
            font-size: 1.2rem;
            font-weight: 700;
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }
        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: rgba(255,255,255,.08);
            color: #fff;
        }
        .sidebar .nav-link {
            padding: .7rem 1rem;
            border-radius: .5rem;
            margin: .15rem .5rem;
            display: flex;
            align-items: center;
            gap: .75rem;
            white-space: nowrap;
        }
        .sidebar .nav-link.active {
            background: #2563eb;
            color: #fff;
        }
        .sidebar.collapsed .text-menu {
            display: none;
        }
        .sidebar.collapsed .brand span {
            display: none;
        }

        .main {
            margin-left: 250px;
            transition: 0.3s;
            padding: 1.5rem;
        }
        .main.collapsed {
            margin-left: 80px;
        }

        .topbar {
            background: #fff;
            padding: .75rem 1.25rem;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,.04);
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }
            .sidebar.show {
                left: 0;
            }
            .main {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div id="sidebar" class="sidebar">
    <div class="brand">
        <i class="bi bi-box-seam"></i>
        <span> Inventaris</span>
    </div>

    <div class="mt-3">
        <a href="../admin/dashboard.php" class="nav-link <?= $active=='dashboard'?'active':'' ?>">
            <i class="bi bi-speedometer2"></i>
            <span class="text-menu">Dashboard</span>
        </a>

        <a href="../admin/user.php" class="nav-link <?= $active=='user'?'active':'' ?>">
            <i class="bi bi-people"></i>
            <span class="text-menu">User</span>
        </a>

        <a href="../admin/alat.php" class="nav-link <?= $active=='alat'?'active':'' ?>">
            <i class="bi bi-tools"></i>
            <span class="text-menu">Alat</span>
        </a>

        <a href="../admin/kategori.php" class="nav-link <?= $active=='kategori'?'active':'' ?>">
            <i class="bi bi-folder2-open"></i>
            <span class="text-menu">Kategori</span>
        </a>

        <a href="../admin/peminjaman_admin.php" class="nav-link <?= $active=='peminjaman'?'active':'' ?>">
            <i class="bi bi-arrow-up-right-square"></i>
            <span class="text-menu">Peminjaman</span>
        </a>

        <a href="../admin/pengembalian_admin.php" class="nav-link <?= $active=='pengembalian'?'active':'' ?>">
            <i class="bi bi-arrow-down-left-square"></i>
            <span class="text-menu">Pengembalian</span>
        </a>

        <a href="../admin/log.php" class="nav-link <?= $active=='log'?'active':'' ?>">
            <i class="bi bi-journal-text"></i>
            <span class="text-menu">Log Aktivitas</span>
        </a>

        <hr class="border-secondary mx-3">

        <a href="../auth/logout.php" class="nav-link text-danger">
            <i class="bi bi-box-arrow-right"></i>
            <span class="text-menu">Logout</span>
        </a>
    </div>
</div>

<!-- MAIN -->
<div id="main" class="main">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="d-flex align-items-center gap-2">
            <button id="btnToggle" class="btn btn-light btn-sm d-none d-md-inline">
                <i class="bi bi-list"></i>
            </button>

            <button id="btnMobile" class="btn btn-light btn-sm d-md-none">
                <i class="bi bi-list"></i>
            </button>

            <strong><?= $title ?></strong>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary rounded-pill">
                <?= $_SESSION['role'] ?? 'admin' ?>
            </span>
        </div>
    </div>
