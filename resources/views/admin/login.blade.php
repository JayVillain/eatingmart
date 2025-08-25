<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
    <form method="POST" action="{{ route('admin.login') }}">
        @csrf
        @if ($errors->any())
            <div>{{ $errors->first() }}</div>
        @endif
        <input type="email" name="email" required placeholder="Email">
        <input type="password" name="password" required placeholder="Password">
        <button type="submit">Login</button>
    </form>
</body>
</html>