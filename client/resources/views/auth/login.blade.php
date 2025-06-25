<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EventPro - Login</title>
    <style>
        :root {
            --primary: #4a00e0;
            --secondary: #8e2de2;
            --accent: #ff6b6b;
            --light: #f8f9fa;
            --dark: #212529;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            text-align: center;
        }

        .logo {
            width: 80px;
            margin-bottom: 1.5rem;
        }

        h1 {
            color: var(--dark);
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--dark);
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            transition: border 0.3s;
        }

        input:focus {
            border-color: var(--primary);
            outline: none;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, var(--primary), var(--secondary));
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .btn-login:hover {
            opacity: 0.9;
        }

        .links {
            margin-top: 1.5rem;
            display: flex;
            justify-content: space-between;
        }

        .links a {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
        }

        .links a:hover {
            text-decoration: underline;
        }

        .divider {
            margin: 1.5rem 0;
            height: 1px;
            background-color: #eee;
            position: relative;
        }

        .divider::after {
            content: "or";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 0 10px;
            color: #777;
            font-size: 0.9rem;
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.3s;
        }

        .social-btn:hover {
            background-color: #f5f5f5;
        }

        .social-btn img {
            width: 20px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <img src="https://lakemacfamilylife.com.au/wp-content/uploads/2024/09/event-cinemas-glendale-main.jpg"
            alt="EventPro Logo" class="logo">
        <h1>Sign In</h1>

        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>

            <button type="submit" class="btn-login">Login</button>
        </form>

        <div class="links">
            <a href="/forgot-password">Lupa password?</a>
            <a href="/signup">Buat akun</a>
        </div>

    </div>

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let errorMessages = `
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
                `;
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    html: errorMessages,
                    showConfirmButton: true,
                    confirmButtonColor: '#EF4444'
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Akses Ditolak!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#EF4444'
                });
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '{{ session('success') }}',
                    showConfirmButton: true,
                    confirmButtonColor: '#4a00e0'
                });
            });
        </script>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>