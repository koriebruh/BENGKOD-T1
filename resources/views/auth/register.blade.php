<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .register-container {
            max-width: 500px;
            margin: 80px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .form-title {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .btn-register {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="register-container">
        <h2 class="form-title">Register</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ url('/register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                       value="{{ old('name') }}" required autofocus>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                       value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label for="no_hp" class="form-label">no_hp</label>
                <input type="no_hp" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp"
                       value="{{ old('no_hp') }}" required>
            </div>


            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                       name="password" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                       required>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Daftar Sebagai</label>
                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role">
                    <option value="pasien" selected>Pasien</option>
                    <option value="dokter">Dokter</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="alamat" class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                       name="alamat" required>
            </div>


            <button type="submit" class="btn btn-primary btn-register">Register</button>
        </form>

        <div class="login-link">
            <p>Sudah punya akun? <a href="{{ url('/login') }}">Login disini</a></p>
        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
