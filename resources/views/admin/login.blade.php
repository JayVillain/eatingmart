<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        :root {
            --bg-color: #121212;
            --card-bg: #1e1e1e;
            --text-color: #e0e0e0;
            --input-bg: #2d2d2d;
            --input-border: #444;
            --placeholder-color: #aaa;
            --accent-color: #BB86FC; /* Warna lembut ungu */
            --error-color: #cf6679; /* Warna merah lembut untuk error */
            --font-family: 'Poppins', sans-serif;
            --shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
        }

        body {
            font-family: var(--font-family);
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            box-sizing: border-box;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
            background-color: var(--card-bg);
            padding: 40px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            text-align: center;
        }

        .login-container h1 {
            font-size: 2rem;
            margin-bottom: 24px;
            color: var(--accent-color);
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 8px;
            color: var(--text-color);
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
            box-sizing: border-box;
        }

        .form-control::placeholder {
            color: var(--placeholder-color);
        }

        .form-control:focus {
            border-color: var(--accent-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(187, 134, 252, 0.2);
        }

        .error-message {
            background-color: rgba(207, 102, 121, 0.2);
            color: var(--error-color);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: left;
            border: 1px solid var(--error-color);
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background-color: var(--accent-color);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .btn-submit:hover {
            background-color: #9c6cde;
            transform: translateY(-2px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Welcome Admin ✨</h1>
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            @if ($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="form-group">
                <input type="email" class="form-control" name="email" required placeholder="Email">
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name="password" required placeholder="Password">
            </div>
            
            <button type="submit" class="btn-submit">Login</button>
        </form>
    </div>
</body>
</html>