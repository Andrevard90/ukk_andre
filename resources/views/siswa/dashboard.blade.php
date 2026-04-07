<!DOCTYPE html>
<html>
<head>
    <title>Dashboard User</title>
</head>
<body>

    <h2>Selamat datang Di Dashboard Siswa</h2>

    <!-- FORM TAMBAH DATA -->
    <h3>Tambah Data</h3>
    <form method="POST" action="{{ route('aspirasi.store') }}" enctype="multipart/form-data">
        @csrf

        <label>NIS</label><br>
        <input type="text" name="nis" value="{{ Auth::user()->nis }}" readonly><br><br>

        <label>ID Kategori</label><br>
        <input type="text" name="id_kategori"><br><br>

        <label>Lokasi</label><br>
        <input type="text" name="lokasi"><br><br>

        <label>Keterangan</label><br>
        <textarea name="keterangan"></textarea><br><br>

        <!-- TAMBAH FOTO -->
        <label>Foto</label><br>
        <input type="file" name="foto"><br><br>

        <!-- TAMBAH TANGGAL -->
        <label>Tanggal</label><br>
        <input type="date" name="tanggal"><br><br>

        <button type="submit">Kirim</button>
    </form>

    <br><br>

    <!-- LOGOUT -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

</body>
</html>