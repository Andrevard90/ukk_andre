<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    protected $signature = 'admin:create';

    protected $description = 'Buat user admin baru untuk sistem';

    public function handle()
    {
        $this->info('╔════════════════════════════════════════╗');
        $this->info('║   BUAT USER ADMIN BARU                 ║');
        $this->info('╚════════════════════════════════════════╝');
        $this->newLine();

        $username = $this->ask('Masukkan username');
        
        if (empty($username) || strlen($username) < 3) {
            $this->error('❌ Username minimal 3 karakter!');
            return 1;
        }

        if (User::where('username', $username)->exists()) {
            $this->error('❌ Username sudah digunakan!');
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
                'username' => $username,
                'password' => Hash::make($password),
                'role' => 'admin',
            ]);

            $this->newLine();
            $this->info('✅ Admin berhasil dibuat!');
            $this->newLine();
            $this->table(
                ['Field', 'Value'],
                [
                    ['Username', $username],
                    ['Password', '(terenkripsi)'],
                    ['Role', 'admin'],
                ]
            );
            $this->newLine();
            $this->info('📌 Login di: http://localhost/login (Tab: Login Admin)');
            
            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }
    }
}

