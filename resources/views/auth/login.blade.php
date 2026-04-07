<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    @if(session('error'))
        <p style="color:red">{{ session('error') }}</p>
    @endif
    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <label>NIS:</label><br>
        <input type="text" name="nis" required><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
    <p>Belum punya akun? <a href="{{ route('register.form') }}">Registrasi Siswa</a></p>
</body>
</html>