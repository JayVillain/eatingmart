<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        :root {
            --bg-color: #0c0d10;
            --card-bg: #1a1c20;
            --text-color: #e0e0e0;
            --accent-color: #B29B7F; /* Aksen Emas Lembut */
            --link-hover-color: #d1b28e;
            --btn-logout-bg: #333;
            --btn-logout-hover: #555;
            --font-family: 'Roboto', sans-serif;
            --shadow: 0 8px 24px rgba(0, 0, 0, 0.5);
        }

        body {
            font-family: var(--font-family);
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            padding: 40px;
            box-sizing: border-box;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background-color: var(--card-bg);
            padding: 50px;
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--accent-color);
            margin: 0;
        }

        .header .logout-form {
            margin: 0;
        }

        .header .logout-btn {
            background-color: var(--btn-logout-bg);
            color: var(--text-color);
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .header .logout-btn:hover {
            background-color: var(--btn-logout-hover);
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .card {
            background-color: var(--input-bg); /* Menggunakan warna yang sama dengan input field */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
            text-decoration: none;
            display: block; /* Menjadikan a sebagai block untuk padding */
            color: var(--text-color);
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.3);
        }

        .card h2 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 1.5rem;
            color: var(--accent-color);
        }

        .card p {
            margin: 0;
            color: #aaa;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Halo, {{ Auth::user()->name }}</h1>
            <form class="logout-form" method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>

        <div class="card-container">
            <a href="{{ route('admin.menus.index') }}" class="card">
                <h2>Manajemen Menu</h2>
                <p>Kelola daftar menu, tambah, edit, atau hapus menu.</p>
            </a>
            
            <a href="{{ route('admin.orders.index') }}" class="card">
                <h2>Manajemen Pesanan</h2>
                <p>Lihat dan kelola semua pesanan yang masuk.</p>
            </a>
        </div>
    </div>
</body>
</html>