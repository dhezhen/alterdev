<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Support\Icons;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TrainingController extends Controller
{
    use HandlesUploads;

    public function index()
    {
        return view('admin.trainings.index', [
            'trainings' => Training::ordered()->withCount(['schedules', 'upcomingSchedules'])->get(),
        ]);
    }

    public function create()
    {
        return view('admin.trainings.form', ['training' => new Training(['is_active' => true, 'icon' => 'cap'])]);
    }

    public function store(Request $request)
    {
        $training = Training::create($this->validated($request));

        return redirect()->route('admin.trainings.edit', $training)->with('success', 'Program pelatihan ditambahkan. Silakan tambahkan jadwalnya.');
    }

    public function edit(Training $training)
    {
        $training->load(['schedules' => fn ($q) => $q->withCount(['registrations' => fn ($r) => $r->where('status', '!=', 'cancelled')])->reorder()->orderByDesc('start_date')]);

        return view('admin.trainings.form', compact('training'));
    }

    public function update(Request $request, Training $training)
    {
        $training->update($this->validated($request, $training));

        return redirect()->route('admin.trainings.edit', $training)->with('success', 'Program pelatihan berhasil diperbarui.');
    }

    public function destroy(Training $training)
    {
        if ($training->schedules()->whereHas('registrations')->exists()) {
            return back()->with('error', 'Program ini memiliki jadwal dengan pendaftar. Nonaktifkan saja agar data pendaftar tetap tersimpan.');
        }
        $training->delete();

        return redirect()->route('admin.trainings.index')->with('success', 'Program pelatihan dihapus.');
    }

    private function validated(Request $request, ?Training $training = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:160', 'alpha_dash', Rule::unique('trainings', 'slug')->ignore($training)],
            'icon' => ['required', Rule::in(array_keys(Icons::OPTIONS))],
            'summary' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'audience' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:100'],
            'outcomes_text' => ['nullable', 'string', 'max:2000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [], ['title' => 'judul', 'summary' => 'ringkasan']);

        $data['outcomes'] = $this->linesToArray($data['outcomes_text'] ?? '');
        unset($data['outcomes_text']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
