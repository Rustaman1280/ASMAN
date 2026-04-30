<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('ruangans')->latest()->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $ruangans = Ruangan::all();
        $roles = [
            'admin' => 'Administrator',
            'pj_ruangan' => 'Penanggung Jawab Ruangan',
            'wakil_kepsek' => 'Wakil Kepala Sekolah',
            'kepala_sekolah' => 'Kepala Sekolah',
            'bendahara' => 'Bendahara',
        ];
        return view('users.create', compact('ruangans', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,pj_ruangan,wakil_kepsek,kepala_sekolah,bendahara',
            'ruangans' => 'nullable|array|required_if:role,pj_ruangan',
            'ruangans.*' => 'exists:ruangans,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->role === 'pj_ruangan' && $request->has('ruangans')) {
            $user->ruangans()->sync($request->ruangans);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $ruangans = Ruangan::all();
        $roles = [
            'admin' => 'Administrator',
            'pj_ruangan' => 'Penanggung Jawab Ruangan',
            'wakil_kepsek' => 'Wakil Kepala Sekolah',
            'kepala_sekolah' => 'Kepala Sekolah',
            'bendahara' => 'Bendahara',
        ];
        return view('users.edit', compact('user', 'ruangans', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,pj_ruangan,wakil_kepsek,kepala_sekolah,bendahara',
            'ruangans' => 'nullable|array|required_if:role,pj_ruangan',
            'ruangans.*' => 'exists:ruangans,id',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        if ($request->role === 'pj_ruangan') {
            $user->ruangans()->sync($request->ruangans ?? []);
        } else {
            $user->ruangans()->sync([]);
        }

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
