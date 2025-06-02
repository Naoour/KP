<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Inventori Laravel 10</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container">
    <a class="navbar-brand" href="{{ route('dashboard') }}">Inventori</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">

        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('barang.*') ? 'active' : '' }}" href="{{ route('barang.index') }}">Barang</a>
        </li>

        @if(auth()->user()->role == 'admin')
        <li class="nav-item">
          <a class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}" href="{{ route('users.index') }}">Manajemen User</a>
        </li>
        @endif
      </ul>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-outline-light btn-sm" type="submit">Logout</button>
      </form>
    </div>
  </div>
</nav>

@yield('content')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
