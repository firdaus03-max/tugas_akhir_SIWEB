<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f6f9;
        }

        .navbar {
            background-color: #007bff;
            color: white;
            padding: 15px;
        }

        .container {
            padding: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        a.logout {
            float: right;
            color: white;
            text-decoration: none;
        }

    </style>

</head>
<body>

<div class="navbar">

    Dashboard Admin Gudang

    <a href="{{ route('logout') }}" class="logout">
        Logout
    </a>

</div>

<div class="container">

    <div class="card">

        <h3>Selamat Datang</h3>

        <p>
            Halo,
            <strong>
                {{ auth()->user()->name ?? 'Admin' }}
            </strong>
        </p>

        <p>
            Sistem Manajemen Gudang Sederhana
        </p>

        <p>
            Anda dapat mengelola data produk dari menu berikut.
        </p>

        <a href="{{ route('products.index') }}">
            Kelola Produk
        </a>

    </div>

</div>

</body>
</html>