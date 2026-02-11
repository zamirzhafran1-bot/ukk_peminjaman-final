<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'petugas') {
    header("Location: ../auth/login.php");
    exit;
}

$dari   = $_GET['dari'] ?? '';
$sampai = $_GET['sampai'] ?? '';
$status = $_GET['status'] ?? '';

$where = [];
if ($dari && $sampai) {
    $where[] = "p.tgl_pinjam BETWEEN '$dari' AND '$sampai'";
}
if ($status) {
    $where[] = "p.status = '$status'";
}

$where_sql = $where ? "WHERE " . implode(" AND ", $where) : "";

$data = mysqli_query($koneksi,
"SELECT 
    p.id AS peminjaman_id,
    u.username,
    a.nama_alat,
    d.jumlah,
    p.tgl_pinjam,
    p.tgl_kembali,
    p.status
 FROM peminjaman p
 JOIN users u ON p.user_id = u.id
 JOIN detail_peminjaman d ON p.id = d.peminjaman_id
 JOIN alat a ON d.alat_id = a.id
 $where_sql
 ORDER BY p.id DESC"
);

$title = "Laporan Peminjaman";
include "../assets/layout.php";
?>

<h4 class="mb-3 fw-bold">🧾 Laporan Peminjaman</h4>

<!-- FILTER -->
<div class="card shadow-sm border-0 rounded-4 mb-4">
    <div class="card-body">
        <form method="get" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Dari</label>
                <input type="date" name="dari" value="<?= $dari ?>" class="form-control rounded-pill" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Sampai</label>
                <input type="date" name="sampai" value="<?= $sampai ?>" class="form-control rounded-pill" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select rounded-pill">
                    <option value="">-- Semua Status --</option>
                    <option value="menunggu_peminjaman" <?= $status=='menunggu_peminjaman'?'selected':'' ?>>Menunggu</option>
                    <option value="dipinjam" <?= $status=='dipinjam'?'selected':'' ?>>Dipinjam</option>
                    <option value="menunggu_pengembalian" <?= $status=='menunggu_pengembalian'?'selected':'' ?>>Menunggu Kembali</option>
                    <option value="selesai" <?= $status=='selesai'?'selected':'' ?>>Selesai</option>
                    <option value="ditolak" <?= $status=='ditolak'?'selected':'' ?>>Ditolak</option>
                </select>
            </div>
            <div class="col-md-3 d-grid gap-2">
                <button class="btn btn-primary rounded-pill">Filter</button>
                <a href="laporan.php" class="btn btn-secondary rounded-pill">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- TABLE -->
<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <div>
                <button onclick="window.print()" class="btn btn-success rounded-pill">🖨 Cetak</button>
                <a href="dashboard.php" class="btn btn-secondary rounded-pill">← Kembali</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Alat</th>
                        <th>Jumlah</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(mysqli_num_rows($data)==0): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">Data laporan kosong</td>
                    </tr>
                <?php endif; ?>

                <?php $no=1; while($l=mysqli_fetch_assoc($data)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($l['username']) ?></td>
                        <td><?= htmlspecialchars($l['nama_alat']) ?></td>
                        <td><?= $l['jumlah'] ?></td>
                        <td><?= $l['tgl_pinjam'] ?></td>
                        <td><?= $l['tgl_kembali'] ?: '-' ?></td>
                        <td>
                            <?php
                            $badge = match($l['status']) {
                                'menunggu_peminjaman' => 'warning',
                                'dipinjam' => 'primary',
                                'menunggu_pengembalian' => 'info',
                                'selesai' => 'success',
                                'ditolak' => 'danger',
                                default => 'secondary'
                            };
                            ?>
                            <span class="badge rounded-pill bg-<?= $badge ?>">
                                <?= str_replace('_',' ', $l['status']) ?>
                            </span>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include "../assets/layout_footer.php"; ?>
