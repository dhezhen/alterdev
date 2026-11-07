<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@alterdev.id');

        // Admin yang sudah ada tidak diubah agar password-nya tidak tertimpa saat seeding ulang
        if (! User::where('email', $email)->exists()) {
            $password = (string) env('ADMIN_PASSWORD', '');
            $generated = false;

            // Tolak password kosong, bawaan, atau terlalu pendek: buat password acak yang kuat
            if (strlen($password) < 10 || $password === 'ubah-password-ini') {
                $password = Str::password(16, symbols: false);
                $generated = true;
            }

            User::create([
                'name' => env('ADMIN_NAME', 'Administrator'),
                'email' => $email,
                'password' => $password,
            ]);

            if ($generated && $this->command) {
                $this->command->warn('Akun admin dibuat dengan password acak (ADMIN_PASSWORD di .env kosong/lemah):');
                $this->command->line("  Email   : {$email}");
                $this->command->line("  Password: {$password}");
                $this->command->warn('Simpan password ini sekarang — tidak akan ditampilkan lagi.');
            }
        }

        $this->call(ContentSeeder::class);
        $this->call(WebsiteCompanyProfilePricingSeeder::class);
    }
}
