<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings', [
            'groups' => Setting::FIELDS,
            'values' => Setting::allValues(),
        ]);
    }

    public function update(Request $request)
    {
        $rules = [];
        foreach (Setting::FIELDS as $fields) {
            foreach ($fields as $key => [$label, $type]) {
                $rules[$key] = str_starts_with($key, 'social_')
                    ? ['nullable', 'url:http,https', 'max:255']
                    : ['nullable', 'string', $type === 'textarea' ? 'max:5000' : 'max:255'];
            }
        }
        $rules['site_name'] = ['required', 'string', 'max:80'];

        $data = $request->validate($rules);
        Setting::setMany($data);

        return back()->with('success', 'Pengaturan situs berhasil disimpan.');
    }
}
