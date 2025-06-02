<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>LOGIN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #ffffff;
            height: 100vh;
        }
        .login-card {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            animation: fadeIn 0.8s ease;
            background-color: #ffffff;
            border: 2px solid #a8d5ba;
            overflow: hidden;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .login-title {
            font-weight: bold;
            color: #28a745;
        }
        .btn-primary {
            background-color: #28a745;
            border: none;
        }
        .btn-primary:hover {
            background-color: #218838;
        }
        .form-label {
            color: #2e7d32;
        }
        .logo-header {
            padding: 20px 0 10px;
            text-align: center;
        }
        .logo-header img {
            max-height: 80px;
        }

        @media (max-width: 768px) {
            .card.login-card {
                margin: 20px 10px;
                padding: 10px;
            }
            .logo-header img {
                max-height: 60px;
            }
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center h-100">
    <div class="col-md-5">
        <div class="card login-card">
            <div class="logo-header">
                <img src="{{ asset('images/logo-hiperkes.jpg') }}" alt="Logo HIPERKES">
            </div>
            <div class="p-4">
                <h3 class="text-center login-title mb-4">LOGIN</h3>

                @if(session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.process') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               required
                               autofocus>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               required>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox"
                               class="form-check-input"
                               name="remember"
                               id="remember"
                               {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Ingat Saya</label>
                    </div>

                    <button class="btn btn-primary w-100" type="submit">Masuk</button>

                    @if (Route::has('password.request'))
                        <div class="text-center mt-3">
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                Lupa Kata Sandi?
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
