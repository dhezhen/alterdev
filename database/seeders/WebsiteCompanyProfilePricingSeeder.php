<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class WebsiteCompanyProfilePricingSeeder extends Seeder
{
    public function run(): void
    {
        $service = Service::where('title', 'Website Company Profile')->first();

        if (! $service || $service->getRawOriginal('pricing_packages') !== null) {
            return;
        }

        $service->update(['pricing_packages' => [
            [
                'name' => 'Paket Standar',
                'summary' => 'Cocok untuk UMKM & bisnis kecil yang membutuhkan website untuk memperkenalkan bisnis dan layanan.',
                'price' => 1000000,
                'price_display' => 'Rp 1 juta',
                'price_kicker' => 'Start From:',
                'compare_price' => 1500000,
                'compare_price_display' => 'Rp 1.500.000,-',
                'discount_label' => '33% OFF',
                'price_note' => '(FREE domain & hosting)',
                'core_price' => null,
                'features' => [
                    'Free domain (.com/.my.id/.web.id)',
                    'SSL/HTTPS',
                    'Hosting & bandwidth 40GB',
                    'Desain responsif (standar)',
                    '5-7 Halaman',
                    '7 Email bisnis',
                    'Integrasi Sosmed (FB, IG, dll)',
                    'Live chat (Tawk.to / WhatsApp Chat)',
                    'Google Maps Embed',
                    'Desain logo (free)',
                    'SEO Basic',
                    'Support & Garansi 1 tahun',
                ],
                'excluded_features' => ['Blog / Artikel', 'Portfolio / Galeri', 'Form Inquiry', 'Custom Feature'],
                'services' => [],
                'renewal_label' => 'Perpanjang 500rb/tahun',
                'accent_color' => 'blue',
                'is_published' => true,
            ],
            [
                'name' => 'Paket Profesional',
                'summary' => 'Cocok untuk perusahaan yang membutuhkan website profesional untuk menampilkan bisnis dan produk.',
                'price' => 3000000,
                'price_display' => 'Rp 3 juta',
                'price_kicker' => 'Start From:',
                'compare_price' => 4000000,
                'compare_price_display' => 'Rp 4.000.000,-',
                'discount_label' => '25%OFF',
                'price_note' => '',
                'core_price' => null,
                'features' => [
                    'Free domain (.com /.my.id/.biz.id)',
                    'SSL/HTTPS',
                    'Hosting & bandwidth unmetered',
                    'Desain profesional',
                    '15-20 Halaman',
                    '25 Email bisnis',
                    'Integrasi Sosmed (FB, IG, dll)',
                    'Live chat (Tawk.to / WhatsApp Chat)',
                    'Google Maps Embed',
                    'Desain logo (free)',
                    'SEO Basic',
                    'Support & Garansi 1 tahun',
                    'Blog / Artikel',
                    'Portfolio / Galeri',
                    'Form Inquiry',
                ],
                'excluded_features' => ['Custom Feature'],
                'services' => [],
                'renewal_label' => 'Perpanjang 800rb/tahun',
                'accent_color' => 'teal',
                'is_published' => true,
            ],
            [
                'name' => 'Paket Custom Pro',
                'summary' => 'Cocok untuk perusahaan yang membutuhkan website untuk membangun citra, layanan & portofolio bisnis.',
                'price' => 6000000,
                'price_display' => 'Rp 6 juta',
                'price_kicker' => 'Start From:',
                'compare_price' => 8000000,
                'compare_price_display' => 'Rp 8.000.000,-',
                'discount_label' => '25% OFF',
                'price_note' => '(harga menyesuaikan kebutuhan & kompleksitas)',
                'core_price' => null,
                'features' => [
                    'Free domain (.com / .net / dll)',
                    'SSL/HTTPS',
                    'Hosting & bandwidth unlimited',
                    'Desain full custom',
                    'Halaman fleksibel',
                    'Unlimited Email bisnis',
                    'Integrasi Sosmed (FB, IG, dll)',
                    'Live chat (Tawk.to / WhatsApp Chat)',
                    'Google Maps Embed',
                    'Desain logo (free)',
                    'SEO Basic',
                    'Support & Garansi 1 tahun',
                    'Blog / Artikel',
                    'Portfolio / Galeri',
                    'Form Inquiry',
                    'Custom Feature',
                ],
                'excluded_features' => [],
                'services' => [],
                'renewal_label' => 'Perpanjang 2Jtan/tahun',
                'accent_color' => 'coral',
                'is_published' => true,
            ],
        ]]);
    }
}
