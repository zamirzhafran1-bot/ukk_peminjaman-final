<?php
session_start();
if (isset($_SESSION['role'])) {
    header("Location: ../".$_SESSION['role']."/dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | UKK Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/theme-dark.css">
</head>
<body class="d-flex align-items-center justify-content-center">

<div class="col-md-4">
    <div class="card shadow-lg border-0 rounded-4 p-3">
        <div class="text-center mb-3">
            <img src="../assets/logo.png" width="70">
            <h4 class="mt-2 text-info fw-bold">UKK PEMINJAMAN</h4>
            <small class="text-secondary">Silakan login untuk melanjutkan</small>
        </div>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger text-center">Username atau Password salah</div>
        <?php endif; ?>

        <form method="post" action="proses_login.php">
            <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button class="btn btn-primary w-100 rounded-pill">Login</button>
        </form>
    </div>
</div>

</body>
</html>
