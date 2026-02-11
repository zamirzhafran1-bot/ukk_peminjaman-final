<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'petugas') {
    header("Location: ../auth/login.php");
    exit;
}

/* ===== HITUNG DATA ===== */
$pending = mysqli_fetch_assoc(mysqli_query($koneksi,
"SELECT COUNT(*) AS total FROM peminjaman WHERE status='menunggu_peminjaman'"
))['total'];

$dipinjam = mysqli_fetch_assoc(mysqli_query($koneksi,
"SELECT COUNT(*) AS total FROM peminjaman WHERE status='dipinjam'"
))['total'];

$title = "Dashboard Petugas";
include "../assets/layout.php";
?>

<h4 class="mb-4 fw-bold">👋 Dashboard Petugas</h4>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 rounded-4 text-center">
            <div class="card-body">
                <h6 class="text-muted">⏳ Menunggu Persetujuan</h6>
                <h2 class="fw-bold text-warning"><?= $pending ?></h2>
                <a href="peminjaman.php" class="btn btn-warning rounded-pill px-4 mt-2">
                    Lihat Pengajuan
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 rounded-4 text-center">
            <div class="card-body">
                <h6 class="text-muted">📦 Sedang Dipinjam</h6>
                <h2 class="fw-bold text-primary"><?= $dipinjam ?></h2>
                <a href="kembali.php" class="btn btn-primary rounded-pill px-4 mt-2">
                    Monitoring
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0 rounded-4 text-center">
            <div class="card-body">
                <h6 class="text-muted">🧾 Laporan</h6>
                <a href="laporan.php" class="btn btn-success rounded-pill px-4 mt-4">
                    Cetak Laporan
                </a>
            </div>
        </div>
    </div>
</div>

<?php include "../assets/layout_footer.php"; ?>
