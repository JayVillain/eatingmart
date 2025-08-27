<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        :root {
            --bg-color: #f0f2f5;
            --card-bg: #ffffff;
            --text-color: #333333;
            --input-bg: #f5f5f5;
            --input-border: #dddddd;
            --placeholder-color: #999;
            --accent-color: #dc3545;
            --error-color: #dc3545;
            --font-family: 'Roboto', sans-serif;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: var(--font-family);
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background-color: var(--card-bg);
            padding: 40px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            text-align: center;
        }

        h1 {
            color: var(--accent-color);
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-color);
            font-weight: 500;
            padding: 10px 15px;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .nav-links a:hover {
            background-color: var(--input-bg);
        }

        .logout-btn {
            background-color: var(--accent-color);
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selamat Datang, {{ Auth::user()->name }}</h1>
        <div class="nav-links">
            <a href="{{ route('admin.menus.index') }}">Manajemen Menu</a>
            <a href="{{ route('admin.orders.index') }}">Manajemen Pesanan</a>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>