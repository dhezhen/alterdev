<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Models\Training;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Konten awal yang diambil dari desain landing page.
 * Semua data dapat diubah dari panel admin.
 */
class ContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->services();
        $this->portfolios();
        $this->trainings();
        $this->testimonials();
        $this->faqs();
        $this->team();
        $this->posts();
    }

    private function services(): void
    {
        $items = [
            [
                'title' => 'Website Company Profile',
                'portfolio_category' => 'Website',
                'icon' => 'globe',
                'short_description' => 'Perkenalkan profil, layanan, dan informasi penting melalui website yang profesional dan nyaman diakses dari berbagai perangkat.',
                'features' => ['Profil, layanan, portofolio & kontak', 'Konten dapat diperbarui sendiri', 'Bantuan domain, hosting & SSL'],
                'description' => "Tampilkan profil, layanan, dan informasi penting Anda melalui website company profile yang mudah diakses.\n\nKami membuat website yang nyaman digunakan di ponsel maupun komputer, serta dapat Anda perbarui sendiri melalui panel admin.\n\n## Yang Anda dapatkan\n\n- Desain responsif untuk berbagai perangkat\n- Halaman profil, layanan, portofolio, berita, dan kontak\n- Panel admin untuk memperbarui konten\n- Bantuan pengaturan domain, hosting, dan SSL\n- Optimasi dasar mesin pencari (SEO)\n- Panduan singkat pengelolaan website",
            ],
            [
                'title' => 'Sistem Informasi',
                'portfolio_category' => 'Sistem Informasi',
                'icon' => 'grid',
                'short_description' => 'Kelola data dan proses kerja dalam sistem informasi berbasis mobile yang dirancang mengikuti kebutuhan Anda.',
                'features' => ['Data dan proses kerja terpusat', 'Akses melalui perangkat mobile', 'Laporan sesuai kebutuhan'],
                'description' => "Kelola data dan proses kerja melalui sistem informasi yang dirancang sesuai kebutuhan Anda.\n\nSistem dapat diakses melalui perangkat mobile dan membantu pengguna melihat informasi yang diperlukan dalam satu tempat. Fitur dan alurnya disusun bersama agar sesuai dengan cara kerja Anda.\n\n## Sistem dapat mencakup\n\n- Pencatatan dan pengelolaan data\n- Alur kerja dan persetujuan\n- Pengaturan akses pengguna\n- Laporan sesuai kebutuhan",
            ],
            [
                'title' => 'Pembuatan Aplikasi',
                'portfolio_category' => 'Aplikasi',
                'icon' => 'phone',
                'short_description' => 'Wujudkan layanan atau ide Anda menjadi aplikasi mobile dengan fitur yang dirancang sesuai kebutuhan penggunanya.',
                'features' => ['Aplikasi Android & iOS', 'Fitur sesuai kebutuhan pengguna', 'Dapat dikembangkan bertahap'],
                'description' => "Wujudkan layanan atau ide Anda menjadi aplikasi mobile dengan fitur yang dirancang untuk kebutuhan penggunanya.\n\nKami membantu merancang alur, mengembangkan aplikasi, dan menguji penggunaannya bersama Anda. Pengembangan dapat dilakukan bertahap, dimulai dari fitur yang paling dibutuhkan.\n\n## Tahapan pengerjaan\n\n1. Diskusi kebutuhan dan rancangan alur\n2. Desain tampilan\n3. Pengembangan dan uji coba bersama\n4. Peluncuran dan pendampingan",
            ],
            [
                'title' => 'Pelatihan IT',
                'portfolio_category' => 'Pelatihan IT',
                'icon' => 'cap',
                'short_description' => 'Teknologi baru terasa bermanfaat kalau timnya percaya diri memakainya. Kami latih dengan cara yang santai dan praktis.',
                'features' => ['Workshop & in-house training', 'Materi disesuaikan peserta', 'Langsung praktik'],
                'description' => "Pelatihan kami dirancang agar peserta langsung bisa mempraktikkan materi di pekerjaan sehari-hari.\n\nCocok untuk guru, staf administrasi, pelaku UMKM, mahasiswa, hingga aparatur desa. Pelatihan dapat diselenggarakan di lokasi Anda, secara daring, atau di tempat yang disepakati.\n\nLihat daftar program dan jadwal terdekat di halaman **Pelatihan**.",
            ],
        ];

        foreach ($items as $i => $item) {
            Service::updateOrCreate(['title' => $item['title']], $item + ['sort_order' => $i + 1]);
        }
    }

    private function portfolios(): void
    {
        $items = [
            [
                'title' => 'Sistem Informasi Administrasi Desa',
                'category' => 'Sistem Informasi',
                'summary' => 'Warga mengajukan surat sendiri lewat kiosk layanan mandiri, staf desa memvalidasi, lalu Kepala Desa menyetujui secara digital.',
                'challenge' => 'Warga harus datang dan menunggu lama untuk mengurus satu surat, sementara arsip masih tersimpan dalam bentuk kertas.',
                'solution' => 'Kiosk layanan mandiri untuk pengajuan surat, dilanjutkan validasi oleh staf desa dan persetujuan digital oleh Kepala Desa.',
                'result' => 'Antrean berkurang, status pengajuan dapat dipantau, dan arsip surat tersimpan rapi secara digital.',
                'tags' => ['Kiosk Mandiri', 'Alur Persetujuan', 'Arsip Digital'],
                'is_featured' => true,
            ],
            [
                'title' => 'AIELA — Asisten Belajar Kewirausahaan',
                'category' => 'Aplikasi',
                'summary' => 'Platform pembelajaran berbasis Laravel dengan asisten AI yang menemani mahasiswa menyusun ide dan rencana usaha.',
                'challenge' => 'Mahasiswa membutuhkan pendampingan yang konsisten saat menyusun ide dan rencana usaha.',
                'solution' => 'Platform pembelajaran dengan asisten AI yang memberi umpan balik, sekaligus menjadi instrumen penelitian.',
                'result' => 'Mahasiswa mendapat pendampingan kapan saja dan dosen memperoleh data proses belajar.',
                'tags' => ['Laravel', 'Generative AI', 'Edukasi'],
                'is_featured' => true,
            ],
            [
                'title' => 'Pelacakan Wajah Real-time',
                'category' => 'Aplikasi',
                'summary' => 'Riset dan purwarupa pelacakan banyak wajah dalam video yang tetap stabil meskipun kualitas gambar berubah-ubah.',
                'tags' => ['Computer Vision', 'Deep Learning', 'Riset'],
            ],
            [
                'title' => 'Aplikasi Penyusunan Buku',
                'category' => 'Aplikasi',
                'summary' => 'Alat bantu penulis untuk mengonversi PDF ke Word dan menyunting naskah dalam satu tempat.',
                'tags' => ['Aplikasi Web', 'Konversi Dokumen', 'Editor'],
            ],
            [
                'title' => 'Pelatihan AI untuk Perangkat Desa',
                'category' => 'Pelatihan IT',
                'summary' => 'Penyusunan materi dan pendampingan pemanfaatan AI untuk mempercepat pekerjaan administrasi aparatur desa.',
                'tags' => ['Pelatihan', 'Literasi AI', 'Pemerintahan Desa'],
            ],
        ];

        foreach ($items as $i => $item) {
            Portfolio::updateOrCreate(['title' => $item['title']], $item + ['sort_order' => $i + 1]);
        }
    }

    private function trainings(): void
    {
        $items = [
            ['Administrasi Perkantoran Digital', 'file', 'Pengolah kata, spreadsheet, dan kerja kolaboratif secara daring.', 'Staf administrasi, guru, aparatur desa', '2 hari'],
            ['Desain Grafis untuk Promosi', 'palette', 'Membuat poster, konten media sosial, dan materi publikasi.', 'UMKM, humas lembaga, pengurus OSIS', '2 hari'],
            ['Pengelolaan Website', 'globe', 'Memperbarui berita, halaman, dan galeri website secara mandiri.', 'Admin website lembaga', '1 hari'],
            ['Pemrograman Web', 'code', 'Dasar membangun website dan aplikasi web dari nol.', 'Mahasiswa, guru TIK, pemula', '4 hari'],
            ['Pemrograman Aplikasi Mobile', 'phone', 'Membuat aplikasi Android & iOS dengan Flutter.', 'Mahasiswa, pengembang pemula', '4 hari'],
            ['Pemanfaatan AI untuk Kerja', 'sparkle', 'Menggunakan AI secara bijak untuk menulis, merangkum, dan mengolah data.', 'Guru, staf, aparatur desa, UMKM', '1 hari'],
        ];

        foreach ($items as $i => [$title, $icon, $summary, $audience, $duration]) {
            Training::updateOrCreate(['title' => $title], [
                'icon' => $icon,
                'summary' => $summary,
                'audience' => $audience,
                'duration' => $duration,
                'description' => $summary."\n\nMateri disampaikan dengan pendekatan praktik langsung, sehingga peserta dapat segera menerapkannya dalam pekerjaan sehari-hari. Tingkat kesulitan disesuaikan dengan kemampuan peserta.",
                'outcomes' => ['Memahami konsep dasar', 'Praktik langsung dengan studi kasus', 'Mendapat materi dan sertifikat'],
                'sort_order' => $i + 1,
            ]);
        }
    }

    private function testimonials(): void
    {
        // CONTOH testimoni — ganti dengan ulasan asli klien (beserta izinnya) sebelum dipublikasikan.
        $items = [
            ['[Nama Klien]', 'Kepala Desa', '[Nama Desa]', 'Dulu warga harus bolak-balik ke kantor desa hanya untuk mengurus satu surat. Sekarang cukup lewat kiosk, staf tinggal memvalidasi. Pelayanan jadi jauh lebih cepat, dan tim alterdev.id sabar sekali melatih perangkat desa kami.'],
            ['[Nama Klien]', 'Kepala Sekolah', '[Nama Sekolah]', 'Pelatihannya santai tapi langsung praktik. Guru-guru kami yang awalnya canggung kini terbiasa mengolah nilai dan materi secara digital. Setelah pelatihan pun kami masih dibantu ketika ada yang bingung.'],
            ['[Nama Klien]', 'Pemilik Usaha', '[Nama UMKM]', 'Website usaha kami sekarang tampil rapi di HP dan pelanggan lebih mudah menghubungi kami. Setiap revisi ditanggapi dengan cepat dan ramah. Rasanya seperti punya tim IT sendiri.'],
        ];

        foreach ($items as $i => [$name, $position, $org, $content]) {
            Testimonial::updateOrCreate(['content' => $content], [
                'name' => $name, 'position' => $position, 'organization' => $org,
                'rating' => 5, 'sort_order' => $i + 1,
            ]);
        }
    }

    private function faqs(): void
    {
        $items = [
            ['Berapa lama proses pembuatannya?', 'Tergantung skala dan kerumitan proyek. Setelah konsultasi, kami berikan estimasi jadwal tertulis lengkap dengan tahapan-tahapannya, sehingga Anda tahu kapan setiap bagian selesai.'],
            ['Berapa biayanya?', 'Biaya disesuaikan dengan kebutuhan dan fitur yang Anda pilih. Kami akan menyusun penawaran yang rinci dan transparan, tanpa biaya tersembunyi. Website company profile mulai dari [HARGA MULAI].'],
            ['Saya tidak paham teknologi. Apakah tetap bisa dibantu?', 'Tentu. Justru itu peran kami. Anda cukup menceritakan masalah atau tujuan yang ingin dicapai, dan kami jelaskan pilihan solusinya dengan bahasa sehari-hari.'],
            ['Apakah melayani yayasan atau pesantren dengan anggaran terbatas?', 'Bisa. Kami terbuka menyesuaikan ruang lingkup dengan kemampuan lembaga. Sistem dapat dibangun bertahap, dimulai dari kebutuhan yang paling mendesak.'],
            ['Pelatihannya bisa diadakan di tempat kami?', 'Bisa. Pelatihan dapat diselenggarakan di lokasi Anda (in-house), secara daring, atau di tempat yang disepakati. Materi dan tingkat kesulitannya kami sesuaikan dengan kemampuan peserta.'],
            ['Apakah ada pelatihan dan dukungan setelah sistem selesai?', 'Ada. Kami melatih pengguna sampai terbiasa, menyiapkan panduan penggunaan, dan tetap bisa dihubungi jika ada kendala setelah sistem berjalan.'],
        ];

        foreach ($items as $i => [$q, $a]) {
            Faq::updateOrCreate(['question' => $q], ['answer' => $a, 'sort_order' => $i + 1]);
        }
    }

    private function team(): void
    {
        $items = [
            ['[Nama Anggota Tim]', 'Pendiri & Konsultan IT', 'Berpengalaman di bidang rekayasa perangkat lunak dan pelatihan teknologi.'],
            ['[Nama Anggota Tim]', 'Pengembang Web & Sistem Informasi', 'Membangun website dan sistem informasi yang rapi dan mudah dipakai.'],
            ['[Nama Anggota Tim]', 'Pengembang Aplikasi Mobile', 'Mengembangkan aplikasi Android dan iOS dengan Flutter.'],
        ];

        foreach ($items as $i => [$name, $position, $bio]) {
            TeamMember::updateOrCreate(['position' => $position], [
                'name' => $name, 'bio' => $bio, 'sort_order' => $i + 1,
            ]);
        }
    }

    private function posts(): void
    {
        Post::updateOrCreate(['title' => '5 Tanda Lembaga Anda Sudah Butuh Sistem Informasi'], [
            'user_id' => User::query()->value('id'),
            'category' => 'Tips',
            'excerpt' => 'Berkas menumpuk, laporan selalu terlambat, dan data sulit dicari? Bisa jadi sudah saatnya beralih ke sistem informasi.',
            'body' => "Banyak lembaga baru menyadari pentingnya sistem informasi ketika pekerjaan administrasi sudah terasa berat. Berikut beberapa tanda yang perlu Anda perhatikan.\n\n## 1. Data tersebar di banyak file\n\nSatu data siswa ada di beberapa file Excel dengan isi yang berbeda-beda.\n\n## 2. Laporan selalu dibuat mendadak\n\nSetiap akhir bulan, tim harus lembur hanya untuk menyusun laporan.\n\n## 3. Sulit melacak status pekerjaan\n\nTidak ada yang tahu pasti sebuah pengajuan sedang diproses siapa.\n\n## 4. Arsip mudah hilang\n\nBerkas kertas rusak, terselip, atau hilang saat dibutuhkan.\n\n## 5. Informasi untuk pimpinan selalu terlambat\n\nPimpinan baru mendapat gambaran kondisi lembaga setelah semuanya terlambat.\n\nJika beberapa tanda di atas terasa akrab, mari berdiskusi. Kami bantu memetakan kebutuhan lembaga Anda — konsultasi awal gratis.",
            'is_published' => true,
            'published_at' => now(),
        ]);
    }
}
