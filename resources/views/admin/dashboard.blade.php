<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --bg-color: #f5f7f9;
            --card-bg: #ffffff;
            --text-color: #333333;
            --primary-color: #5a5f7d;
            --accent-color: #dc3545;
            --hover-color: #e9ecef;
            --border-color: #e0e0e0;
            --shadow-light: 0 4px 6px rgba(0, 0, 0, 0.05);
            --shadow-medium: 0 10px 15px rgba(0, 0, 0, 0.1);
            --button-text-color: #ffffff;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
        }

        .main-container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: var(--card-bg);
            box-shadow: var(--shadow-light);
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .logo {
            text-align: center;
            margin-bottom: 40px;
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item a, .nav-item button {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin-bottom: 10px;
            text-decoration: none;
            color: var(--text-color);
            font-weight: 500;
            border-radius: 8px;
            transition: background-color 0.3s, color 0.3s;
            background: none;
            border: none;
            width: 100%;
            cursor: pointer;
            text-align: left;
        }

        .nav-item a:hover,
        .nav-item button:hover,
        .nav-item a.active {
            background-color: var(--accent-color);
            color: var(--button-text-color);
        }
        
        .nav-item i {
            margin-right: 10px;
        }

        .content-area {
            flex-grow: 1;
            padding: 40px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 2rem;
            color: var(--primary-color);
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <aside class="sidebar">
            <div class="logo">Admin Panel</div>
            <ul class="nav-menu">
                <li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="active">Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('admin.menus.index') }}">Manajemen Menu</a></li>
                <li class="nav-item"><a href="{{ route('admin.orders.index') }}">Manajemen Pesanan</a></li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </li>
            </ul>
        </aside>
        
        <div class="content-area">
            <div class="page-header">
                <h1>Selamat Datang, {{ Auth::user()->name }}</h1>
            </div>
            
            </div>
    </div>
</body>
</html>