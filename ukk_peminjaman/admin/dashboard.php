<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$title = "Dashboard Admin";
include "../assets/layout.php";

// Hitung statistik
$jumlah_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) total FROM users"))['total'];
$jumlah_alat = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) total FROM alat"))['total'];
$jumlah_kategori = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) total FROM kategori"))['total'];
$dipinjam = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) total FROM peminjaman WHERE status='dipinjam'"))['total'];
$kembali = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) total FROM peminjaman WHERE status='kembali'"))['total'];
?>

<h4 class="mb-4">Dashboard Administrator</h4>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card p-3 text-center shadow-sm border-0 bg-gradient-primary text-white">
            <h6>👤 Total User</h6>
            <h2><?= $jumlah_user ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 text-center shadow-sm border-0 bg-gradient-success text-white">
            <h6>🛠 Total Alat</h6>
            <h2><?= $jumlah_alat ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 text-center shadow-sm border-0 bg-gradient-warning text-dark">
            <h6>📁 Kategori</h6>
            <h2><?= $jumlah_kategori ?></h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card p-3 text-center shadow-sm border-0 bg-gradient-danger text-white">
            <h6>📤 Dipinjam</h6>
            <h2><?= $dipinjam ?></h2>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card dashboard-card text-center p-3 shadow-sm border-0">
            <h5>👤 User</h5>
            <p class="text-secondary">Manajemen akun</p>
            <a href="user.php" class="btn btn-primary btn-sm rounded-pill">Kelola</a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card dashboard-card text-center p-3 shadow-sm border-0">
            <h5>🛠 Alat</h5>
            <p class="text-secondary">Inventaris alat</p>
            <a href="alat.php" class="btn btn-primary btn-sm rounded-pill">Kelola</a>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card dashboard-card text-center p-3 shadow-sm border-0">
            <h5>📁 Kategori</h5>
            <p class="text-secondary">Data kategori</p>
            <a href="kategori.php" class="btn btn-primary btn-sm rounded-pill">Kelola</a>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card dashboard-card text-center p-3 shadow-sm border-0">
            <h5>📤 Peminjaman</h5>
            <p class="text-secondary">Monitoring transaksi</p>
            <a href="peminjaman_admin.php" class="btn btn-success btn-sm rounded-pill">Buka</a>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card dashboard-card text-center p-3 shadow-sm border-0">
            <h5>📥 Pengembalian</h5>
            <p class="text-secondary">Status alat kembali</p>
            <a href="pengembalian_admin.php" class="btn btn-warning btn-sm rounded-pill">Buka</a>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card dashboard-card text-center p-3 shadow-sm border-0 bg-dark text-info">
            <h5>🧾 Log Aktivitas</h5>
            <a href="log.php" class="btn btn-secondary btn-sm rounded-pill">Lihat</a>
        </div>
    </div>
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(45deg, #3b82f6, #6366f1);
}
.bg-gradient-success {
    background: linear-gradient(45deg, #22c55e, #16a34a);
}
.bg-gradient-warning {
    background: linear-gradient(45deg, #facc15, #eab308);
}
.bg-gradient-danger {
    background: linear-gradient(45deg, #ef4444, #dc2626);
}
.dashboard-card {
    transition: 0.25s;
}
.dashboard-card:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 10px 30px rgba(0,0,0,0.25);
}
</style>

<?php include "../assets/layout_footer.php"; ?>
