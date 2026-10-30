<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\TrainingRegistration;
use App\Models\TrainingSchedule;
use App\Support\Notifier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingController extends Controller
{
    public function index()
    {
        $schedules = TrainingSchedule::with('training')
            ->where('status', 'open')
            ->whereDate('start_date', '>=', now()->toDateString())
            ->whereHas('training', fn ($q) => $q->where('is_active', true))
            ->orderBy('start_date')
            ->get();

        return view('trainings.index', [
            'trainings' => Training::active()->ordered()->withCount('upcomingSchedules')->get(),
            'schedules' => $schedules,
        ]);
    }

    public function show(Training $training)
    {
        abort_unless($training->is_active, 404);

        return view('trainings.show', [
            'training' => $training,
            'schedules' => $training->schedules()
                ->whereIn('status', ['open', 'closed'])
                ->whereDate('start_date', '>=', now()->toDateString())
                ->get(),
            'others' => Training::active()->ordered()->whereKeyNot($training->id)->take(3)->get(),
        ]);
    }

    public function register(Request $request, TrainingSchedule $schedule)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+\-\s()]{8,}$/'],
            'institution' => ['nullable', 'string', 'max:150'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'website' => ['prohibited'], // honeypot anti-spam
        ], [
            'phone.regex' => 'Nomor HP/WhatsApp tidak valid.',
        ], [
            'name' => 'nama', 'email' => 'email', 'phone' => 'nomor HP/WhatsApp', 'institution' => 'instansi',
        ]);

        // Kunci baris jadwal agar kuota tidak terlampaui saat pendaftaran bersamaan
        $registration = DB::transaction(function () use ($schedule, $data) {
            $schedule = TrainingSchedule::whereKey($schedule->id)->lockForUpdate()->firstOrFail();

            if (! $schedule->isOpenForRegistration()) {
                return null;
            }

            $alreadyRegistered = $schedule->registrations()
                ->where('email', $data['email'])
                ->where('status', '!=', 'cancelled')
                ->exists();
            if ($alreadyRegistered) {
                return 'duplicate';
            }

            unset($data['website']);

            return $schedule->registrations()->create($data);
        });

        if ($registration === 'duplicate') {
            return back()->withInput()->with('error', 'Email ini sudah terdaftar pada jadwal tersebut. Silakan cek email/WhatsApp Anda atau hubungi kami.');
        }

        if (! $registration) {
            return back()->withInput()->with('error', 'Maaf, pendaftaran untuk jadwal ini sudah ditutup atau kuota telah penuh.');
        }

        Notifier::newRegistration($registration);

        return redirect()->route('trainings.registered', $registration->code);
    }

    public function registered(string $code)
    {
        $registration = TrainingRegistration::with('schedule.training')->where('code', $code)->firstOrFail();

        return view('trainings.registered', compact('registration'));
    }
}
