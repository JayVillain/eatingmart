<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>
</head>
<body>
    <h1>Selamat Datang, {{ Auth::user()->name }}</h1>
    <a href="{{ route('admin.menus.index') }}">Manajemen Menu</a>
    <a href="{{ route('admin.orders.index') }}">Manajemen Pesanan</a>
    <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>