<!DOCTYPE html>
<html>
<head>
    <title>Registrasi Siswa</title>
</head>
<body>
    <h2>Registrasi Siswa</h2>
    @if($errors->any())
        <ul style="color:red">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    @endif
    <form action="{{ route('register.post') }}" method="POST">
        @csrf
        <label>NIS:</label><br>
        <input type="text" name="nis" required><br>
        <label>Kelas:</label><br>
        <input type="text" name="kelas" required><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br>
        <label>Konfirmasi Password:</label><br>
        <input type="password" name="password_confirmation" required><br><br>
        <button type="submit">Registrasi</button>
    </form>
    <p>Sudah punya akun? <a href="{{ route('login.form') }}">Login</a></p>
</body>
</html>