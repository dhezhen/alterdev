<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Service;
use App\Models\TrainingRegistration;
use App\Models\TrainingSchedule;
use App\Models\WebsiteVisit;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $today = today();
        $visitorPeriod = (int) request()->query('period', 30);
        if (! in_array($visitorPeriod, [7, 30, 90], true)) {
            $visitorPeriod = 30;
        }

        $startDate = $today->copy()->subDays($visitorPeriod - 1)->toDateString();
        $visitorsByDate = WebsiteVisit::query()
            ->whereBetween('visit_date', [$startDate, $today->toDateString()])
            ->selectRaw('visit_date, COUNT(*) as total')
            ->groupBy('visit_date')
            ->pluck('total', 'visit_date');
        $visitorDays = collect(range($visitorPeriod - 1, 0))->map(function (int $daysAgo) use ($today, $visitorsByDate) {
            $date = $today->copy()->subDays($daysAgo);

            return [
                'date' => $date->toDateString(),
                'label' => $date->translatedFormat('j M'),
                'count' => (int) $visitorsByDate->get($date->toDateString(), 0),
            ];
        });

        return view('admin.dashboard', [
            'visitorDays' => $visitorDays,
            'visitorPeriod' => $visitorPeriod,
            'visitorTotal' => $visitorDays->sum('count'),
            'visitorsToday' => (int) $visitorsByDate->get($today->toDateString(), 0),
            'visitorChartMax' => max(1, $visitorDays->max('count')),
            'stats' => [
                ['Pesan baru', Message::where('status', 'new')->count(), 'inbox', route('admin.messages.index', ['status' => 'new'])],
                ['Pendaftar menunggu', TrainingRegistration::where('status', 'pending')->count(), 'user-plus', route('admin.registrations.index', ['status' => 'pending'])],
                ['Jadwal dibuka', TrainingSchedule::where('status', 'open')->whereDate('start_date', '>=', today())->count(), 'calendar', route('admin.schedules.index')],
                ['Artikel terbit', Post::published()->count(), 'pen', route('admin.posts.index')],
                ['Layanan aktif', Service::active()->count(), 'grid', route('admin.services.index')],
                ['Portofolio', Portfolio::count(), 'briefcase', route('admin.portfolios.index')],
            ],
            'messages' => Message::latest()->take(6)->get(),
            'registrations' => TrainingRegistration::with('schedule.training')->latest()->take(6)->get(),
            'upcoming' => TrainingSchedule::with('training')->withCount(['registrations' => fn ($q) => $q->where('status', '!=', 'cancelled')])
                ->whereDate('start_date', '>=', today())->orderBy('start_date')->take(5)->get(),
            'messagesPerMonth' => $this->messagesPerMonth(),
        ]);
    }

    /** Jumlah pesan masuk 6 bulan terakhir (untuk grafik sederhana). */
    private function messagesPerMonth(): array
    {
        $result = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->startOfMonth()->subMonths($i);
            $result[] = [
                'label' => $month->translatedFormat('M'),
                'count' => Message::whereBetween('created_at', [$month, $month->copy()->endOfMonth()])->count(),
            ];
        }

        return $result;
    }
}
