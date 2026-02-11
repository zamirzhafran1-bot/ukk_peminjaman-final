<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: user.php");
    exit;
}

mysqli_begin_transaction($koneksi);

try {
    // Ambil username untuk log
    $u = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT username FROM users WHERE id='$id'"));
    $username = $u['username'] ?? 'Unknown';

    // 1. Hapus detail peminjaman
    mysqli_query($koneksi,
        "DELETE dp FROM detail_peminjaman dp
         JOIN peminjaman p ON dp.peminjaman_id = p.id
         WHERE p.user_id='$id'"
    );

    // 2. Hapus pengembalian
    mysqli_query($koneksi,
        "DELETE pg FROM pengembalian pg
         JOIN peminjaman p ON pg.peminjaman_id = p.id
         WHERE p.user_id='$id'"
    );

    // 3. Hapus peminjaman
    mysqli_query($koneksi,
        "DELETE FROM peminjaman WHERE user_id='$id'"
    );

    // 4. Hapus user
    mysqli_query($koneksi,
        "DELETE FROM users WHERE id='$id'"
    );

    // 5. Simpan log aktivitas
    $admin_id = $_SESSION['user_id'] ?? null;
    $aktivitas = "Menghapus user: $username";
    mysqli_query($koneksi,
        "INSERT INTO log_aktivitas (user_id, aktivitas, waktu)
         VALUES ('$admin_id', '$aktivitas', NOW())"
    );

    mysqli_commit($koneksi);
    header("Location: user.php?msg=deleted");
    exit;

} catch (Exception $e) {
    mysqli_rollback($koneksi);
    echo "❌ Gagal menghapus user: " . $e->getMessage();
}
