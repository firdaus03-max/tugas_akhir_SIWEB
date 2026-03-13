<?php
session_start();

// Hapus semua session
session_unset();
session_destroy();

// Hapus cookie login_status jika ada
if (isset($_COOKIE['login_status'])) {
    setcookie('login_status', '', time() - 3600, '/');
}

// Note: Cookie username tidak dihapus karena untuk fitur remember me di form login

// Redirect ke halaman login
header("Location: ../login.php");
exit;
?>