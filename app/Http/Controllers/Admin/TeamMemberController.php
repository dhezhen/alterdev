<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesUploads;
use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    use HandlesUploads;

    public function index()
    {
        return view('admin.team.index', ['members' => TeamMember::ordered()->get()]);
    }

    public function create()
    {
        return view('admin.team.form', ['member' => new TeamMember(['is_active' => true])]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['photo'] = $this->storeUpload($request, 'photo', 'team');
        TeamMember::create($data);

        return redirect()->route('admin.team.index')->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function edit(TeamMember $member)
    {
        return view('admin.team.form', compact('member'));
    }

    public function update(Request $request, TeamMember $member)
    {
        $data = $this->validated($request);
        $data['photo'] = $this->storeUpload($request, 'photo', 'team', $member->photo);
        $member->update($data);

        return redirect()->route('admin.team.index')->with('success', 'Anggota tim berhasil diperbarui.');
    }

    public function destroy(TeamMember $member)
    {
        $this->deleteFile($member->photo);
        $member->delete();

        return back()->with('success', 'Anggota tim dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'position' => ['required', 'string', 'max:120'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'linkedin' => ['nullable', 'url:http,https', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'dimensions:max_width=6000,max_height=6000', 'max:1024'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [], ['name' => 'nama', 'position' => 'jabatan', 'photo' => 'foto']);

        unset($data['photo']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
