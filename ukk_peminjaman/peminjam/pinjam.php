<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'peminjam') {
    header("Location: ../auth/login.php");
    exit;
}

$alat = mysqli_query($koneksi,
    "SELECT alat.*, kategori.nama_kategori
     FROM alat
     JOIN kategori ON alat.kategori_id = kategori.id
     WHERE alat.status='aktif' AND alat.stok > 0"
);

$title = "Pinjam Alat";
include "../assets/layout.php";
?>

<h4 class="mb-3 fw-bold">📦 Pinjam Alat</h4>

<?php if (isset($_GET['success'])): ?>
<div class="alert alert-success rounded-4 shadow-sm">
    ✅ Pengajuan peminjaman berhasil dikirim
</div>
<?php endif; ?>

<div class="row g-4">
<?php while($a = mysqli_fetch_assoc($alat)): ?>
    <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100 rounded-4">
            <div class="card-body d-flex flex-column">
                <span class="badge bg-primary mb-2"><?= $a['nama_kategori'] ?></span>
                <h5 class="fw-semibold"><?= $a['nama_alat'] ?></h5>
                <p class="text-muted mb-3">Stok tersedia: 
                    <span class="fw-bold"><?= $a['stok'] ?></span>
                </p>

                <button class="btn btn-primary rounded-pill mt-auto"
                        data-bs-toggle="modal"
                        data-bs-target="#pinjam<?= $a['id'] ?>">
                    📥 Pinjam
                </button>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="pinjam<?= $a['id'] ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form method="post" action="proses_pinjam.php" class="modal-content rounded-4 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Pinjam <?= $a['nama_alat'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="alat_id" value="<?= $a['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <input type="number" name="jumlah"
                               class="form-control rounded-pill"
                               min="1" max="<?= $a['stok'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="tgl_pinjam"
                               class="form-control rounded-pill" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Kembali</label>
                        <input type="date" name="tgl_kembali"
                               class="form-control rounded-pill" required>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button class="btn btn-primary rounded-pill px-4">Ajukan</button>
                    <button type="button" class="btn btn-secondary rounded-pill px-4"
                            data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
<?php endwhile; ?>
</div>

<?php include "../assets/layout_footer.php"; ?>
