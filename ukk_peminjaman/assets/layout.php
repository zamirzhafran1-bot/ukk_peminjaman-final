<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Dashboard' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/theme-dark.css">
    <style>
        body {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, #020617, #020617);
            border-right: 1px solid #1e293b;
            transition: 0.3s;
        }
        .sidebar.collapsed {
            width: 80px;
        }
        .sidebar.collapsed .menu-text {
            display: none;
        }
        .sidebar.collapsed .user-box h6,
        .sidebar.collapsed .user-box small {
            display: none;
        }
        .sidebar.collapsed .nav-link {
            text-align: center;
        }

        .sidebar .nav-link {
            color: #cbd5f5;
            padding: 12px 20px;
            border-radius: 10px;
            margin: 4px 10px;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: linear-gradient(90deg, #2563eb, #7c3aed);
            color: white;
        }

        .content {
            flex: 1;
            padding: 25px;
            transition: 0.3s;
        }

        .user-box {
            background: rgba(255,255,255,0.03);
            border-radius: 12px;
            padding: 15px;
            margin: 15px;
            text-align: center;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: #38bdf8;
            font-size: 20px;
            margin-left: auto;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="d-flex align-items-center px-3 pt-3">
        <img src="../assets/logo.png" width="40">
        <span class="ms-2 fw-bold menu-text">UKK APP</span>
        <button class="toggle-btn ms-auto" onclick="toggleSidebar()">☰</button>
    </div>

    <div class="user-box">
        <img src="../assets/logo.png" width="60" class="mb-2">
        <h6 class="mb-0"><?= $_SESSION['nama'] ?? 'User' ?></h6>
        <small class="text-secondary text-uppercase"><?= $_SESSION['role'] ?? '' ?></small>
    </div>

    <nav class="nav flex-column px-2">

        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="dashboard.php" class="nav-link <?= $currentPage=='dashboard.php'?'active':'' ?>">
                🏠 <span class="menu-text">Dashboard</span>
            </a>
            <a href="user.php" class="nav-link <?= $currentPage=='user.php'?'active':'' ?>">
                👤 <span class="menu-text">Kelola User</span>
            </a>
            <a href="alat.php" class="nav-link <?= $currentPage=='alat.php'?'active':'' ?>">
                🛠 <span class="menu-text">Kelola Alat</span>
            </a>
            <a href="kategori.php" class="nav-link <?= $currentPage=='kategori.php'?'active':'' ?>">
                📁 <span class="menu-text">Kelola Kategori</span>
            </a>
            <a href="peminjaman_admin.php" class="nav-link <?= $currentPage=='peminjaman_admin.php'?'active':'' ?>">
                📤 <span class="menu-text">Peminjaman</span>
            </a>
            <a href="pengembalian_admin.php" class="nav-link <?= $currentPage=='pengembalian_admin.php'?'active':'' ?>">
                📥 <span class="menu-text">Pengembalian</span>
            </a>
            <a href="log.php" class="nav-link <?= $currentPage=='log.php'?'active':'' ?>">
                🧾 <span class="menu-text">Log Aktivitas</span>
            </a>

        <?php elseif ($_SESSION['role'] == 'petugas'): ?>
            <a href="dashboard.php" class="nav-link <?= $currentPage=='dashboard.php'?'active':'' ?>">
                🏠 <span class="menu-text">Dashboard</span>
            </a>
            <a href="peminjaman.php" class="nav-link <?= $currentPage=='peminjaman.php'?'active':'' ?>">
                ✅ <span class="menu-text">Persetujuan</span>
            </a>
            <a href="kembali.php" class="nav-link <?= $currentPage=='kembali.php'?'active':'' ?>">
                📥 <span class="menu-text">Pengembalian</span>
            </a>
            <a href="laporan.php" class="nav-link <?= $currentPage=='laporan.php'?'active':'' ?>">
                🧾 <span class="menu-text">Laporan</span>
            </a>

        <?php elseif ($_SESSION['role'] == 'peminjam'): ?>
            <a href="dashboard.php" class="nav-link <?= $currentPage=='dashboard.php'?'active':'' ?>">
                🏠 <span class="menu-text">Dashboard</span>
            </a>
            <a href="pinjam.php" class="nav-link <?= $currentPage=='pinjam.php'?'active':'' ?>">
                📤 <span class="menu-text">Pinjam Alat</span>
            </a>
            <a href="riwayat.php" class="nav-link <?= $currentPage=='riwayat.php'?'active':'' ?>">
                📜 <span class="menu-text">Riwayat</span>
            </a>
            <a href="kembali.php" class="nav-link <?= $currentPage=='kembali.php'?'active':'' ?>">
                📥 <span class="menu-text">Pengembalian</span>
            </a>
        <?php endif; ?>

        <hr class="border-secondary mx-3">

        <a href="../auth/logout.php" class="nav-link text-danger">
            🚪 <span class="menu-text">Logout</span>
        </a>
    </nav>
</div>

<!-- CONTENT -->
<div class="content">
