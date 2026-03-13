<?php
session_start();

// Cek apakah sudah login, jika ya redirect ke index.php
if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MotorSport Showroom</title>
    
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Google Fonts untuk font lebih keren -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('assets/default_motor.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }
        
        /* Efek overlay gradient dinamis */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 30% 50%, rgba(220, 53, 69, 0.2) 0%, transparent 50%);
            pointer-events: none;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 30px;
            box-shadow: 0 30px 70px rgba(220, 53, 69, 0.3);
            padding: 50px;
            max-width: 550px;
            width: 100%;
            animation: fadeInUp 0.8s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 10;
            transition: transform 0.3s ease;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .login-header i {
            font-size: 85px;
            color: #dc3545;
            background: rgba(220, 53, 69, 0.1);
            padding: 20px;
            border-radius: 50%;
            display: inline-block;
            margin-bottom: 15px;
            box-shadow: 0 10px 25px rgba(220, 53, 69, 0.2);
        }
        
        .login-header h1 {
            color: #333;
            font-weight: 800;
            margin-top: 10px;
            font-size: 2.5rem;
            letter-spacing: -0.5px;
        }
        
        .login-header p {
            color: #6c757d;
            font-size: 1.1rem;
            font-weight: 300;
        }
        
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 1rem;
            letter-spacing: 0.5px;
        }
        
        .input-group {
            margin-bottom: 5px;
        }
        
        .input-group-text {
            background: white;
            border: 2px solid #e0e0e0;
            border-right: none;
            border-radius: 15px 0 0 15px;
            color: #dc3545;
            padding: 15px 18px;
            font-size: 1.2rem;
        }
        
        .form-control {
            border-radius: 15px;
            padding: 15px 18px;
            border: 2px solid #e0e0e0;
            transition: all 0.3s ease;
            font-size: 1rem;
            height: auto;
        }
        
        .input-group .form-control {
            border-left: none;
            border-radius: 0 15px 15px 0;
            padding: 15px 18px 15px 5px;
        }
        
        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.15);
        }
        
        .form-check {
            padding-left: 2rem;
            margin: 25px 0;
        }
        
        .form-check-input {
            width: 1.2rem;
            height: 1.2rem;
            margin-top: 0.15rem;
            margin-left: -2rem;
            border: 2px solid #e0e0e0;
            cursor: pointer;
        }
        
        .form-check-input:checked {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        
        .form-check-label {
            color: #555;
            font-weight: 500;
            cursor: pointer;
            font-size: 1rem;
        }
        
        .btn-login {
            background: #dc3545;
            border: none;
            border-radius: 15px;
            padding: 16px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
            font-size: 1.2rem;
            letter-spacing: 0.5px;
            margin-top: 10px;
            position: relative;
            overflow: hidden;
        }
        
        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .btn-login:hover::before {
            left: 100%;
        }
        
        .btn-login:hover {
            background: #bb2d3b;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(220, 53, 69, 0.4);
        }
        
        .btn-login i {
            margin-right: 8px;
        }
        
        .back-link {
            color: #dc3545;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            display: inline-block;
            padding: 10px 20px;
            border-radius: 50px;
            background: rgba(220, 53, 69, 0.05);
            font-size: 1rem;
        }
        
        .back-link:hover {
            color: #bb2d3b;
            background: rgba(220, 53, 69, 0.1);
            text-decoration: none;
            transform: translateX(-5px);
        }
        
        .back-link i {
            margin-right: 5px;
        }
        
        .alert-danger {
            background-color: #fff2f4;
            border-color: #ffd7da;
            color: #842029;
            border-radius: 15px;
            padding: 15px 20px;
            margin-bottom: 30px;
            font-weight: 500;
            border-left: 5px solid #dc3545;
        }
        
        .text-muted {
            color: #6c757d !important;
        }
        
        /* Efek dekoratif */
        .login-decoration {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 1;
        }
        
        .decoration-circle {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(220, 53, 69, 0.1);
            top: -100px;
            right: -100px;
            z-index: 0;
        }
        
        .decoration-circle2 {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(220, 53, 69, 0.05);
            bottom: -50px;
            left: -50px;
            z-index: 0;
        }
        
        /* Responsive */
        @media (max-width: 576px) {
            .login-card {
                padding: 30px 20px;
            }
            
            .login-header h1 {
                font-size: 2rem;
            }
            
            .login-header i {
                font-size: 60px;
                padding: 15px;
            }
            
            .input-group-text {
                padding: 12px 15px;
            }
            
            .form-control {
                padding: 12px 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Elemen dekoratif -->
    <div class="login-decoration">
        <div class="decoration-circle"></div>
        <div class="decoration-circle2"></div>
    </div>
    
    <div class="login-card">
        <div class="login-header">
            <i class="bi bi-speedometer2"></i>
            <h1>MotorSport</h1>
            <p class="text-muted">Selamat datang kembali! Silakan login ke akun Anda</p>
        </div>
        
        <!-- Tampilkan pesan error jika ada -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> 
                <?php 
                    if ($_GET['error'] == 1) echo "Username atau password salah!";
                    else echo "Terjadi kesalahan. Silakan coba lagi.";
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- Form Login -->
        <form method="POST" action="controller/proses_login.php">
            <div class="mb-4">
                <label class="form-label">
                    <i class="bi bi-person-fill me-1" style="color: #dc3545;"></i> Username
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" 
                           name="username" 
                           class="form-control" 
                           placeholder="Masukkan username"
                           value="<?php echo isset($_COOKIE['username']) ? $_COOKIE['username'] : ''; ?>" 
                           required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">
                    <i class="bi bi-lock-fill me-1" style="color: #dc3545;"></i> Password
                </label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" 
                           name="password" 
                           class="form-control" 
                           placeholder="Masukkan password"
                           required>
                </div>
            </div>

            <div class="form-check">
                <input type="checkbox" 
                       name="remember" 
                       class="form-check-input" 
                       id="rememberCheck"
                       <?php echo isset($_COOKIE['username']) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="rememberCheck">
                    <i class="bi bi-check-circle me-1"></i> Remember Me
                </label>
            </div>

            <button type="submit" class="btn btn-login w-100">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </button>

            <div class="text-center mt-4">
                <a href="index.php" class="back-link">
                    <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
        </form>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>