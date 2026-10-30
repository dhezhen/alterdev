<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Support\Csv;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.messages.index', [
            'messages' => $this->filtered($request)->latest()->paginate(25)->withQueryString(),
            'status' => $request->query('status'),
            'search' => trim((string) $request->query('q')),
            'counts' => Message::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
        ]);
    }

    public function show(Message $message)
    {
        if (! $message->read_at) {
            $message->forceFill(['read_at' => now()])->save();
        }

        return view('admin.messages.show', compact('message'));
    }

    public function update(Request $request, Message $message)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(Message::STATUSES))],
            'admin_notes' => ['nullable', 'string', 'max:3000'],
        ]);
        $message->update($data);

        return back()->with('success', 'Pesan diperbarui.');
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Pesan dihapus.');
    }

    public function export(Request $request): StreamedResponse
    {
        $messages = $this->filtered($request)->latest()->get();

        return response()->streamDownload(function () use ($messages) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['Tanggal', 'Nama', 'Email', 'HP/WA', 'Instansi', 'Layanan', 'Pesan', 'Status', 'Catatan admin'], ';');
            foreach ($messages as $m) {
                fputcsv($out, Csv::row([
                    $m->created_at->format('d/m/Y H:i'), $m->name, $m->email, $m->phone, $m->institution,
                    $m->service, $m->message, $m->statusLabel(), $m->admin_notes,
                ]), ';');
            }
            fclose($out);
        }, 'pesan-masuk-'.now()->format('Ymd').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function filtered(Request $request)
    {
        $search = trim((string) $request->query('q'));

        return Message::query()
            ->when($request->query('status'), fn ($q, $s) => $q->where('status', $s))
            ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('institution', 'like', "%{$search}%")
                ->orWhere('message', 'like', "%{$search}%")));
    }
}
