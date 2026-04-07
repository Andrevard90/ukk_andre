<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Buat user admin baru untuk sistem';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('╔════════════════════════════════════════╗');
        $this->info('║   BUAT USER ADMIN BARU                 ║');
        $this->info('╚════════════════════════════════════════╝');
        $this->newLine();

        $nik = $this->ask('Masukkan NIK (16 digit)');
        
        if (strlen($nik) !== 16 || !ctype_digit($nik)) {
            $this->error('❌ NIK harus 16 digit angka!');
            return 1;
        }

        if (User::where('nik', $nik)->exists()) {
            $this->error('❌ NIK sudah terdaftar!');
            return 1;
        }

        $name = $this->ask('Masukkan nama lengkap');
        
        if (empty($name)) {
            $this->error('❌ Nama tidak boleh kosong!');
            return 1;
        }

        $username = $this->ask('Masukkan username');
        
        if (User::where('username', $username)->exists()) {
            $this->error('❌ Username sudah digunakan!');
            return 1;
        }

        $email = $this->ask('Masukkan email');
        
        if (User::where('email', $email)->exists()) {
            $this->error('❌ Email sudah terdaftar!');
            return 1;
        }

        $telp = $this->ask('Masukkan nomor telepon');
        
        if (empty($telp)) {
            $this->error('❌ Nomor telepon tidak boleh kosong!');
            return 1;
        }

        $password = $this->secret('Masukkan password (minimal 6 karakter)');
        
        if (strlen($password) < 6) {
            $this->error('❌ Password minimal 6 karakter!');
            return 1;
        }

        $passwordConfirm = $this->secret('Konfirmasi password');
        
        if ($password !== $passwordConfirm) {
            $this->error('❌ Konfirmasi password tidak cocok!');
            return 1;
        }

        try {
            User::create([
                'nik' => $nik,
                'name' => $name,
                'username' => $username,
                'email' => $email,
                'telp' => $telp,
                'password' => Hash::make($password),
                'level' => 'admin',
            ]);

            $this->newLine();
            $this->info('✅ User admin berhasil dibuat!');
            $this->newLine();
            $this->table(
                ['Data', 'Nilai'],
                [
                    ['NIK', $nik],
                    ['Nama', $name],
                    ['Username', $username],
                    ['Email', $email],
                    ['Telepon', $telp],
                    ['Level', 'admin'],
                ]
            );
            $this->newLine();
            $this->info('📌 Anda dapat login di: http://yoursite.com/admin-login');
            
            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }
    }
}
