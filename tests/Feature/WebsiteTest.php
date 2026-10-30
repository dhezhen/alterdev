<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Service;
use App\Models\Training;
use App\Models\TrainingRegistration;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Uji cepat seluruh halaman. Jalankan dengan: php artisan test
 */
class WebsiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_public_pages_load(): void
    {
        $service = Service::first();
        $portfolio = Portfolio::first();
        $training = Training::first();
        $post = Post::first();

        foreach ([
            '/', '/layanan', '/portofolio', '/pelatihan', '/blog', '/tentang-kami', '/kontak', '/sitemap.xml',
            route('services.show', $service), route('portfolios.show', $portfolio),
            route('trainings.show', $training), route('blog.show', $post),
            '/?kategori=Aplikasi', '/portofolio?kategori=Aplikasi', '/blog?cari=sistem',
        ] as $url) {
            $this->get($url)->assertOk();
        }
    }

    public function test_unknown_page_returns_404(): void
    {
        $this->get('/layanan/tidak-ada')->assertNotFound();
    }

    public function test_contact_form_stores_message(): void
    {
        $this->post('/kontak', [
            'name' => 'Budi',
            'contact' => '081234567890',
            'service' => 'Sistem Informasi',
            'message' => 'Kami ingin membuat sistem informasi keuangan sekolah.',
        ])->assertSessionHas('success');

        $this->assertDatabaseHas('messages', ['name' => 'Budi', 'phone' => '081234567890', 'status' => 'new']);
    }

    public function test_contact_form_rejects_spam_honeypot(): void
    {
        $this->post('/kontak', [
            'name' => 'Bot', 'contact' => 'bot@example.com',
            'message' => 'Pesan otomatis dari bot spam.', 'website' => 'http://spam.test',
        ])->assertSessionHasErrors('website');

        $this->assertDatabaseCount('messages', 0);
    }

    public function test_training_registration_and_quota(): void
    {
        $training = Training::first();
        $schedule = $training->schedules()->create([
            'batch_name' => 'Angkatan Uji', 'start_date' => now()->addDays(10), 'mode' => 'offline',
            'quota' => 1, 'price' => 0, 'status' => 'open',
        ]);

        $this->post(route('trainings.register', $schedule), [
            'name' => 'Siti', 'email' => 'siti@example.com', 'phone' => '081298765432',
        ])->assertRedirect();

        $registration = TrainingRegistration::first();
        $this->assertNotNull($registration);
        $this->get(route('trainings.registered', $registration->code))->assertOk()->assertSee($registration->code);

        // Kuota 1 sudah terisi, pendaftar berikutnya ditolak
        $this->post(route('trainings.register', $schedule), [
            'name' => 'Ani', 'email' => 'ani@example.com', 'phone' => '081211112222',
        ])->assertSessionHas('error');

        $this->assertDatabaseCount('training_registrations', 1);
    }

    public function test_admin_requires_login(): void
    {
        $this->get('/admin')->assertRedirect(route('login'));
    }

    public function test_admin_pages_load(): void
    {
        $user = User::first();
        $training = Training::first();
        $schedule = $training->schedules()->create([
            'batch_name' => 'Angkatan Admin', 'start_date' => now()->addDays(5), 'mode' => 'online',
            'quota' => 10, 'price' => 150000, 'status' => 'open',
        ]);
        $registration = $schedule->registrations()->create(['name' => 'Rina', 'email' => 'rina@example.com', 'phone' => '0812']);
        $message = Message::create(['name' => 'Joko', 'phone' => '0813', 'message' => 'Halo, saya ingin konsultasi.']);

        $this->actingAs($user);

        foreach ([
            route('admin.dashboard'),
            route('admin.services.index'), route('admin.services.create'), route('admin.services.edit', Service::first()),
            route('admin.portfolios.index'), route('admin.portfolios.create'), route('admin.portfolios.edit', Portfolio::first()),
            route('admin.testimonials.index'), route('admin.testimonials.create'),
            route('admin.faqs.index'), route('admin.faqs.create'),
            route('admin.team.index'), route('admin.team.create'),
            route('admin.trainings.index'), route('admin.trainings.create'), route('admin.trainings.edit', $training),
            route('admin.schedules.index'), route('admin.schedules.create', $training),
            route('admin.schedules.show', $schedule), route('admin.schedules.edit', $schedule),
            route('admin.registrations.index'), route('admin.registrations.show', $registration),
            route('admin.messages.index'), route('admin.messages.show', $message),
            route('admin.posts.index'), route('admin.posts.create'), route('admin.posts.edit', Post::first()),
            route('admin.settings.edit'), route('admin.account.edit'),
            route('admin.users.index'), route('admin.users.create'),
        ] as $url) {
            $this->get($url)->assertOk();
        }

        $this->get(route('admin.schedules.export', $schedule))->assertOk();
        $this->get(route('admin.messages.export'))->assertOk();
    }

    public function test_admin_can_create_service_and_update_settings(): void
    {
        $this->actingAs(User::first());

        $this->post(route('admin.services.store'), [
            'title' => 'Maintenance Website', 'icon' => 'tool',
            'short_description' => 'Perawatan rutin website.', 'features_text' => "Backup\nUpdate",
            'is_active' => '1',
        ])->assertRedirect(route('admin.services.index'));

        $this->assertDatabaseHas('services', ['slug' => 'maintenance-website']);
        $this->get('/layanan/maintenance-website')->assertOk()->assertSee('Perawatan rutin website.');

        $this->put(route('admin.settings.update'), ['site_name' => 'alterdev.id', 'contact_whatsapp' => '6281234567890'])
            ->assertSessionHas('success');
        $this->get('/')->assertSee('wa.me/6281234567890');
    }

    public function test_security_headers_are_sent(): void
    {
        $this->get('/')
            ->assertHeader('X-Frame-Options', 'DENY')
            ->assertHeader('X-Content-Type-Options', 'nosniff')
            ->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');

        $this->assertStringContainsString("script-src 'self'", $this->get('/')->headers->get('Content-Security-Policy'));

        $this->actingAs(User::first());
        $this->assertStringContainsString('no-store', $this->get(route('admin.dashboard'))->headers->get('Cache-Control'));
    }

    public function test_login_is_locked_after_repeated_failures(): void
    {
        $email = User::first()->email;

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('login.attempt'), ['email' => $email, 'password' => 'salah-'.$i]);
        }

        $this->post(route('login.attempt'), ['email' => $email, 'password' => 'salah-lagi'])
            ->assertSessionHasErrors(['email' => 'Terlalu banyak percobaan masuk. Coba lagi dalam 5 menit.']);
        $this->assertGuest();
    }

    public function test_javascript_urls_are_rejected(): void
    {
        $this->actingAs(User::first());

        $this->put(route('admin.settings.update'), ['site_name' => 'alterdev.id', 'social_instagram' => 'javascript:alert(1)'])
            ->assertSessionHasErrors('social_instagram');
    }

    public function test_markdown_strips_raw_html(): void
    {
        $post = Post::first();
        $post->update(['body' => "Halo\n\n<script>alert('x')</script>\n\n[klik](javascript:alert(1))"]);

        $this->get(route('blog.show', $post))
            ->assertDontSee("<script>alert('x')</script>", false)
            ->assertDontSee('javascript:alert(1)', false);
    }

    public function test_csv_export_neutralises_formulas(): void
    {
        $this->assertSame("'=HYPERLINK(\"x\")", \App\Support\Csv::safe('=HYPERLINK("x")'));
        $this->assertSame('Budi', \App\Support\Csv::safe('Budi'));
    }
}
