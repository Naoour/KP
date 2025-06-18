@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Selamat datang, {{ auth()->user()->name }}</h2>
    <p>Ini adalah dashboard inventori.</p>
</div>
@endsection
