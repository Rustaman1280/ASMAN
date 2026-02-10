<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('jurusan')->latest()->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $jurusans = Jurusan::all();
        $roles = [
            'admin' => 'Administrator',
            'guru_jurusan' => 'Guru Jurusan',
            'wakil_kepsek' => 'Wakil Kepala Sekolah',
            'kepala_sekolah' => 'Kepala Sekolah',
            'bendahara' => 'Bendahara',
        ];
        return view('users.create', compact('jurusans', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,guru_jurusan,wakil_kepsek,kepala_sekolah,bendahara',
            'jurusan_id' => 'nullable|exists:jurusans,id|required_if:role,guru_jurusan',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'jurusan_id' => $request->role === 'guru_jurusan' ? $request->jurusan_id : null,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $jurusans = Jurusan::all();
        $roles = [
            'admin' => 'Administrator',
            'guru_jurusan' => 'Guru Jurusan',
            'wakil_kepsek' => 'Wakil Kepala Sekolah',
            'kepala_sekolah' => 'Kepala Sekolah',
            'bendahara' => 'Bendahara',
        ];
        return view('users.edit', compact('user', 'jurusans', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,guru_jurusan,wakil_kepsek,kepala_sekolah,bendahara',
            'jurusan_id' => 'nullable|exists:jurusans,id|required_if:role,guru_jurusan',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'jurusan_id' => $request->role === 'guru_jurusan' ? $request->jurusan_id : null,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

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
