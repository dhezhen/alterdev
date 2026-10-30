<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Support\Notifier;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'contact' => ['required', 'string', 'max:150'],
            'institution' => ['nullable', 'string', 'max:150'],
            'service' => ['nullable', Rule::in(Message::SERVICES)],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
            'website' => ['prohibited'], // honeypot anti-spam
        ], [
            'message.min' => 'Ceritakan kebutuhan Anda minimal 10 karakter.',
        ], [
            'name' => 'nama', 'contact' => 'WhatsApp / email', 'message' => 'pesan',
        ]);

        // Kolom "contact" bisa berisi email atau nomor WhatsApp
        $isEmail = filter_var($data['contact'], FILTER_VALIDATE_EMAIL) !== false;

        $message = Message::create([
            'name' => $data['name'],
            'email' => $isEmail ? $data['contact'] : null,
            'phone' => $isEmail ? null : $data['contact'],
            'institution' => $data['institution'] ?? null,
            'service' => $data['service'] ?? null,
            'message' => $data['message'],
            'ip_address' => $request->ip(),
        ]);

        Notifier::newMessage($message);

        return back()->with('success', 'Terima kasih, '.$message->name.'! Pesan Anda sudah kami terima. Kami akan menghubungi Anda secepatnya.');
    }
}
