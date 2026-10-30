<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\TrainingRegistration;
use App\Models\TrainingSchedule;
use App\Support\Csv;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $when = $request->query('waktu', 'mendatang');

        return view('admin.schedules.index', [
            'schedules' => TrainingSchedule::with('training')
                ->withCount(['registrations' => fn ($q) => $q->where('status', '!=', 'cancelled')])
                ->when($when === 'mendatang', fn ($q) => $q->whereDate('start_date', '>=', today())->orderBy('start_date'))
                ->when($when === 'lampau', fn ($q) => $q->whereDate('start_date', '<', today())->orderByDesc('start_date'))
                ->paginate(20)->withQueryString(),
            'when' => $when,
        ]);
    }

    public function create(Training $training)
    {
        return view('admin.schedules.form', [
            'training' => $training,
            'schedule' => new TrainingSchedule(['mode' => 'offline', 'status' => 'open', 'quota' => 20, 'price' => 0]),
        ]);
    }

    public function store(Request $request, Training $training)
    {
        $schedule = $training->schedules()->create($this->validated($request));

        return redirect()->route('admin.schedules.show', $schedule)->with('success', 'Jadwal pelatihan berhasil ditambahkan.');
    }

    public function show(Request $request, TrainingSchedule $schedule)
    {
        $schedule->load('training');

        return view('admin.schedules.show', [
            'schedule' => $schedule,
            'registrations' => $schedule->registrations()
                ->when($request->query('status'), fn ($q, $s) => $q->where('status', $s))
                ->oldest()->get(),
            'counts' => $schedule->registrations()->selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
        ]);
    }

    public function edit(TrainingSchedule $schedule)
    {
        return view('admin.schedules.form', ['training' => $schedule->training, 'schedule' => $schedule]);
    }

    public function update(Request $request, TrainingSchedule $schedule)
    {
        $schedule->update($this->validated($request));

        return redirect()->route('admin.schedules.show', $schedule)->with('success', 'Jadwal pelatihan berhasil diperbarui.');
    }

    public function destroy(TrainingSchedule $schedule)
    {
        if ($schedule->registrations()->exists()) {
            return back()->with('error', 'Jadwal ini sudah memiliki pendaftar. Ubah statusnya menjadi "Pendaftaran ditutup" atau "Selesai" agar data tetap tersimpan.');
        }
        $training = $schedule->training;
        $schedule->delete();

        return redirect()->route('admin.trainings.edit', $training)->with('success', 'Jadwal dihapus.');
    }

    /** Unduh daftar peserta dalam format CSV (bisa dibuka di Excel). */
    public function export(TrainingSchedule $schedule): StreamedResponse
    {
        $schedule->load('training');
        $filename = 'peserta-'.$schedule->training->slug.'-'.$schedule->start_date->format('Ymd').'.csv';

        return response()->streamDownload(function () use ($schedule) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // BOM agar karakter terbaca benar di Excel
            fputcsv($out, ['No', 'Kode', 'Nama', 'Email', 'HP/WA', 'Instansi', 'Status', 'Catatan', 'Tanggal daftar'], ';');
            foreach ($schedule->registrations()->oldest()->get() as $i => $r) {
                fputcsv($out, Csv::row([
                    $i + 1, $r->code, $r->name, $r->email, $r->phone, $r->institution,
                    TrainingRegistration::STATUSES[$r->status] ?? $r->status, $r->notes,
                    $r->created_at->format('d/m/Y H:i'),
                ]), ';');
            }
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'batch_name' => ['required', 'string', 'max:150'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'time_info' => ['nullable', 'string', 'max:100'],
            'mode' => ['required', Rule::in(array_keys(TrainingSchedule::MODES))],
            'location' => ['nullable', 'string', 'max:255'],
            'quota' => ['required', 'integer', 'min:1', 'max:10000'],
            'price' => ['required', 'integer', 'min:0'],
            'registration_deadline' => ['nullable', 'date', 'before_or_equal:start_date'],
            'status' => ['required', Rule::in(array_keys(TrainingSchedule::STATUSES))],
            'notes' => ['nullable', 'string', 'max:1000'],
        ], [], [
            'batch_name' => 'nama angkatan', 'start_date' => 'tanggal mulai', 'end_date' => 'tanggal selesai',
            'quota' => 'kuota', 'price' => 'biaya', 'registration_deadline' => 'batas pendaftaran',
        ]);
    }
}
