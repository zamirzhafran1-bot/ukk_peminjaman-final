<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id='$id'"));

$title = "Edit User";
include "../assets/layout.php";

if (isset($_POST['update'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $role     = $_POST['role'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        mysqli_query($koneksi,
            "UPDATE users SET
                username='$username',
                password='$password',
                nama='$nama',
                role='$role'
             WHERE id='$id'"
        );
    } else {
        mysqli_query($koneksi,
            "UPDATE users SET
                username='$username',
                nama='$nama',
                role='$role'
             WHERE id='$id'"
        );
    }

    header("Location: user.php");
    exit;
}
?>

<h4 class="mb-4">✏ Edit User</h4>

<div class="card shadow-sm border-0 col-md-6">
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input name="username" value="<?= htmlspecialchars($data['username']) ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password Baru (opsional)</label>
                <input name="password" type="password" class="form-control" placeholder="Kosongkan jika tidak diganti">
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input name="nama" value="<?= htmlspecialchars($data['nama']) ?>" class="form-control" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="admin" <?= $data['role']=='admin'?'selected':'' ?>>Admin</option>
                    <option value="petugas" <?= $data['role']=='petugas'?'selected':'' ?>>Petugas</option>
                    <option value="peminjam" <?= $data['role']=='peminjam'?'selected':'' ?>>Peminjam</option>
                </select>
            </div>

            <button name="update" class="btn btn-warning rounded-pill px-4">💾 Update</button>
            <a href="user.php" class="btn btn-secondary rounded-pill px-4">↩ Kembali</a>
        </form>
    </div>
</div>

<?php include "../assets/layout_footer.php"; ?>
