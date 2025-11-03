<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Jejak Layar</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom, #fde68a, #f5f5f5);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background-color: white;
            width: 380px;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
            padding: 2.5rem 2rem;
            position: relative;
        }

        .login-container img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background-color: #fef3c7;
            position: absolute;
            top: -45px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px;
        }

        .login-container form {
            margin-top: 60px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .login-container label {
            text-align: left;
            font-size: 14px;
            color: #4b5563;
            font-weight: 500;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            outline: none;
            font-size: 14px;
        }

        .login-container input:focus {
            border-color: #fbbf24;
            box-shadow: 0 0 0 3px rgba(251,191,36,0.2);
        }

        .login-container button {
            background-color: #f4b400;
            color: white;
            font-weight: 600;
            padding: 10px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-container button:hover {
            background-color: #d9a300;
        }

        .error-message {
            color: red;
            font-size: 13px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <img src="{{ asset('images/Logo Header.png') }}" alt="Jejak Layar">
        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf
            <div>
                <label for="email">Email :</label>
                <input type="email" name="email" id="email" placeholder="Masukkan email" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="password">Password :</label>
                <input type="password" name="password" id="password" placeholder="Masukkan password" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
