<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingRegistration;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q'));

        return view('admin.registrations.index', [
            'registrations' => TrainingRegistration::with('schedule.training')
                ->when($request->query('status'), fn ($q, $s) => $q->where('status', $s))
                ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('institution', 'like', "%{$search}%")))
                ->latest()->paginate(25)->withQueryString(),
            'status' => $request->query('status'),
            'search' => $search,
        ]);
    }

    public function show(TrainingRegistration $registration)
    {
        $registration->load('schedule.training');

        return view('admin.registrations.show', compact('registration'));
    }

    public function update(Request $request, TrainingRegistration $registration)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(TrainingRegistration::STATUSES))],
            'admin_notes' => ['nullable', 'string', 'max:2000'],
        ]);
        $registration->update($data);

        return back()->with('success', 'Status pendaftar diperbarui menjadi "'.$registration->statusLabel().'".');
    }

    public function destroy(TrainingRegistration $registration)
    {
        $schedule = $registration->schedule;
        $registration->delete();

        return redirect()->route('admin.schedules.show', $schedule)->with('success', 'Data pendaftar dihapus.');
    }
}
