<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Daftar pengaturan yang dapat diubah dari panel admin.
     * Format: key => [label, tipe input, nilai bawaan]
     */
    public const FIELDS = [
        'Identitas' => [
            'site_name' => ['Nama situs', 'text', 'alterdev.id'],
            'site_tagline' => ['Tagline', 'text', 'Your Digital Partner and IT Solution'],
            'site_description' => ['Deskripsi singkat (SEO)', 'textarea', 'Jasa pembuatan website company profile, sistem informasi, aplikasi, dan pelatihan IT untuk usaha, yayasan, pesantren, dan sekolah.'],
        ],
        'Beranda' => [
            'hero_title' => ['Judul hero', 'text', 'Urusan teknologi, biar kami yang bantu.'],
            'hero_highlight' => ['Bagian judul yang diberi warna', 'text', 'biar kami yang bantu'],
            'hero_subtitle' => ['Paragraf hero', 'textarea', 'Kami membuat website company profile, sistem informasi, dan aplikasi yang sederhana serta mudah digunakan — lengkap dengan pelatihan IT agar tim Anda percaya diri memakainya. Melayani usaha maupun lembaga pendidikan seperti yayasan, pesantren, dan sekolah.'],
        ],
        'Tentang Kami' => [
            'about_title' => ['Judul halaman tentang', 'text', 'Bukan sekadar vendor, tapi rekan kerja'],
            'about_body' => ['Isi halaman tentang (Markdown)', 'textarea', "alterdev.id lahir dari keyakinan sederhana: teknologi yang baik adalah teknologi yang benar-benar dipakai.\n\nKami membantu usaha kecil, yayasan, pondok pesantren, sekolah, hingga pemerintah desa membangun website, sistem informasi, dan aplikasi yang sesuai dengan cara kerja mereka — bukan sebaliknya.\n\nSelain membangun sistem, kami juga menyelenggarakan pelatihan IT agar tim Anda percaya diri memanfaatkan teknologi dalam pekerjaan sehari-hari."],
            'about_vision' => ['Visi', 'textarea', 'Menjadi mitra teknologi yang terpercaya bagi usaha dan lembaga pendidikan di Indonesia.'],
            'about_mission' => ['Misi (satu baris satu poin)', 'textarea', "Membangun solusi digital yang sederhana dan tepat guna\nMendampingi klien sampai sistem benar-benar digunakan\nMeningkatkan literasi digital melalui pelatihan yang praktis"],
        ],
        'Kontak' => [
            'contact_whatsapp' => ['Nomor WhatsApp (format 62xxx)', 'text', '[NO. WHATSAPP]'],
            'contact_email' => ['Email', 'text', '[EMAIL]@alterdev.id'],
            'contact_address' => ['Alamat kantor', 'textarea', '[ALAMAT KANTOR]'],
            'contact_hours' => ['Jam layanan', 'text', 'Senin – Jumat, 08.00 – 17.00 WIB'],
            'social_instagram' => ['URL Instagram', 'text', ''],
            'social_linkedin' => ['URL LinkedIn', 'text', ''],
            'social_youtube' => ['URL YouTube', 'text', ''],
        ],
    ];

    public static function defaults(): array
    {
        $defaults = [];
        foreach (self::FIELDS as $group) {
            foreach ($group as $key => [$label, $type, $default]) {
                $defaults[$key] = $default;
            }
        }

        return $defaults;
    }

    /** Ambil semua pengaturan (dengan cache) digabung nilai bawaan. */
    public static function allValues(): array
    {
        return Cache::rememberForever('site_settings', function () {
            $stored = static::query()->pluck('value', 'key')->all();

            return array_merge(static::defaults(), array_filter($stored, fn ($v) => $v !== null));
        });
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        return static::allValues()[$key] ?? $default;
    }

    public static function setMany(array $values): void
    {
        foreach ($values as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        Cache::forget('site_settings');
    }
}
