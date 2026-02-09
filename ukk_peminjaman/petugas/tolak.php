<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'petugas') {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];

/* Ambil data alat dan jumlah */
$q = mysqli_query($koneksi,
"SELECT alat_id, jumlah 
 FROM detail_peminjaman 
 WHERE peminjaman_id='$id'"
);
$d = mysqli_fetch_assoc($q);

$alat_id = $d['alat_id'];
$jumlah = $d['jumlah'];

/* Kembalikan stok */
mysqli_query($koneksi,
"UPDATE alat 
 SET stok = stok + $jumlah 
 WHERE id='$alat_id'"
);

/* Update status */
mysqli_query($koneksi,
"UPDATE peminjaman 
 SET status='ditolak' 
 WHERE id='$id'"
);

header("Location: peminjaman.php");
exit;
