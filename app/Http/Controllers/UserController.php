<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('ruangan')->get();
        $ruangan = Ruangan::all();
        $usersJs = $users->map(function ($u) {
            return [
                'id' => $u->id,
                'username' => $u->username,
                'ruangan' => $u->ruangan->nama_ruangan ?? null,
                'id_ruangan' => $u->id_ruangan,
            ];
        });
        return view('master-data.user.index', compact('users', 'ruangan', 'usersJs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id_ruangan',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'id_ruangan' => $request->id_ruangan,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('master-data.user.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'id_ruangan' => 'required|exists:ruangan,id_ruangan',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'id_ruangan' => $request->id_ruangan,
            'username' => $request->username,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('master-data.user.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('master-data.user.index')
                ->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('master-data.user.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
