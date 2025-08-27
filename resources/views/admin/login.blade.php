<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --bg-color: #f5f7f9;
            --card-bg: #ffffff;
            --text-color: #333333;
            --primary-color: #5a5f7d;
            --accent-color: #dc3545;
            --input-bg: #f5f5f5;
            --input-border: #e0e0e0;
            --placeholder-color: #999;
            --error-color: #dc3545;
            --font-family: 'Poppins', sans-serif;
            --shadow-medium: 0 10px 15px rgba(0, 0, 0, 0.1);
            --button-text-color: #ffffff;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--bg-color);
            color: var(--text-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background-color: var(--card-bg);
            padding: 40px;
            border-radius: 12px;
            box-shadow: var(--shadow-medium);
            text-align: center;
            border: 1px solid var(--input-border);
        }

        .login-container h1 {
            font-size: 2rem;
            margin-bottom: 8px;
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .login-container p {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 14px 15px;
            background-color: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 8px;
            color: var(--text-color);
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control::placeholder {
            color: var(--placeholder-color);
        }

        .form-control:focus {
            border-color: var(--accent-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.25);
        }

        .error-message {
            background-color: #ffe8e8;
            color: var(--error-color);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: left;
            border: 1px solid #f8d7da;
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background-color: var(--accent-color);
            color: var(--button-text-color);
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s, box-shadow 0.3s;
        }

        .btn-submit:hover {
            background-color: #b02a37;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-submit:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Admin Portal</h1>
        <p>Sign in to continue to your dashboard.</p>
        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            @if ($errors->any())
                <div class="error-message">
                    {{ $errors->first() }}
                </div>
            @endif
            <div class="form-group">
                <input type="email" class="form-control" name="email" required placeholder="Email Address">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" required placeholder="Password">
            </div>
            <button type="submit" class="btn-submit">Login</button>
        </form>
    </div>
</body>
</html>