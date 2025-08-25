<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');

        :root {
            --bg-color: #f0f2f5; /* Latar belakang abu-abu terang */
            --card-bg: #ffffff; /* Latar belakang kartu putih */
            --text-color: #333333; /* Warna teks utama gelap */
            --input-bg: #f5f5f5; /* Latar belakang input abu-abu sangat terang */
            --input-border: #dddddd; /* Warna border input */
            --placeholder-color: #999;
            --accent-color: #007bff; /* Warna aksen biru, umum untuk profesional */
            --error-color: #dc3545; /* Merah untuk pesan error */
            --font-family: 'Roboto', sans-serif;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
            max-width: 420px;
            background-color: var(--card-bg);
            padding: 40px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            text-align: center;
            border: 1px solid var(--input-border);
        }

        .login-container h1 {
            font-size: 2.2rem;
            margin-bottom: 8px;
            color: var(--accent-color);
            font-weight: 700;
            letter-spacing: 1px;
        }

        .login-container p {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 14px 18px;
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
            font-style: italic;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            outline: none;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
        }

        .error-message {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--error-color);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
            text-align: left;
            border: 1px solid rgba(220, 53, 69, 0.2);
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background-color: var(--accent-color);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s, box-shadow 0.3s;
        }

        .btn-submit:hover {
            background-color: #0056b3;
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