<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pengaturan umum situs (nama, tagline, kontak, teks hero, dll.)
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Layanan
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon', 40)->default('globe');
            $table->string('short_description', 255);
            $table->longText('description')->nullable();
            $table->json('features')->nullable();
            $table->string('price_label')->nullable();
            $table->string('portfolio_category', 60)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Portofolio / proyek
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category', 60);
            $table->string('client')->nullable();
            $table->string('year', 10)->nullable();
            $table->string('summary', 300);
            $table->longText('challenge')->nullable();
            $table->longText('solution')->nullable();
            $table->longText('result')->nullable();
            $table->json('tags')->nullable();
            $table->string('image')->nullable();
            $table->string('url')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Testimoni
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position')->nullable();
            $table->string('organization')->nullable();
            $table->text('content');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->string('photo')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // FAQ
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->text('answer');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Anggota tim
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->string('linkedin')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Program pelatihan
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('icon', 40)->default('book');
            $table->string('summary', 255);
            $table->longText('description')->nullable();
            $table->string('audience')->nullable();
            $table->string('duration')->nullable();
            $table->json('outcomes')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Jadwal pelatihan
        Schema::create('training_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained()->cascadeOnDelete();
            $table->string('batch_name');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('time_info')->nullable();
            $table->enum('mode', ['offline', 'online', 'hybrid'])->default('offline');
            $table->string('location')->nullable();
            $table->unsignedInteger('quota')->default(20);
            $table->unsignedBigInteger('price')->default(0);
            $table->date('registration_deadline')->nullable();
            $table->enum('status', ['open', 'closed', 'finished'])->default('open');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Pendaftaran pelatihan
        Schema::create('training_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_schedule_id')->constrained()->cascadeOnDelete();
            $table->string('code', 20)->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone', 30);
            $table->string('institution')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'attended'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });

        // Pesan masuk / leads
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('institution')->nullable();
            $table->string('service')->nullable();
            $table->text('message');
            $table->enum('status', ['new', 'in_progress', 'done', 'archived'])->default('new');
            $table->text('admin_notes')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });

        // Artikel / blog
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category', 60)->nullable();
            $table->string('excerpt', 300)->nullable();
            $table->longText('body');
            $table->string('cover_image')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('training_registrations');
        Schema::dropIfExists('training_schedules');
        Schema::dropIfExists('trainings');
        Schema::dropIfExists('team_members');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('testimonials');
        Schema::dropIfExists('portfolios');
        Schema::dropIfExists('services');
        Schema::dropIfExists('settings');
    }
};
