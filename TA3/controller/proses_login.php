<?php
session_start();

// Cek apakah sudah login, jika ya redirect ke index
if (isset($_SESSION["user"])) {
    header("Location: ../index.php");
    exit;
}

// Cek apakah form dikirim dengan method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Ambil data dari form
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']) ? true : false;
    

    if ($username === 'firdaus' && $password === 'firdaus123') {
        
        // Set session login
        $_SESSION["user"] = $username;
        $_SESSION["login_time"] = date("Y-m-d H:i:s");
        
        // Jika remember me dicentang, set cookie
        if ($remember) {
            // Set cookie untuk 7 hari (7 * 24 * 60 * 60 detik)
            setcookie('username', $username, time() + (7 * 24 * 60 * 60), '/');
            setcookie('login_status', 'true', time() + (7 * 24 * 60 * 60), '/');
        } else {
            // Hapus cookie jika ada dan remember tidak dicentang
            if (isset($_COOKIE['username'])) {
                setcookie('username', '', time() - 3600, '/');
            }
            if (isset($_COOKIE['login_status'])) {
                setcookie('login_status', '', time() - 3600, '/');
            }
        }
        
        // Redirect ke halaman index
        header("Location: ../index.php");
        exit;
        
    } else {
        // Login gagal, redirect ke login dengan pesan error
        header("Location: ../login.php?error=1");
        exit;
    }
} else {
    // Jika bukan method POST, redirect ke login
    header("Location: ../login.php");
    exit;
}
?>