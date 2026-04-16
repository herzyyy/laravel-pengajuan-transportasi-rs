<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Parse nama lengkap menjadi first_name, last_name, dan username.
     * - Ambil kata ke-1 dan ke-2 untuk username (nama1.nama2 lowercase)
     * - Jika hanya 1 kata, username = kata itu
     * - Contoh: "M. Rangga Aditya" → username = "m.rangga"
     */
    private function parseNama(string $namaLengkap): array
    {
        $parts = preg_split('/\s+/', trim($namaLengkap));

        $firstName = $parts[0] ?? '';
        $lastName  = count($parts) >= 2
            ? implode(' ', array_slice($parts, 1))
            : '';

        // Username: kata ke-1 dan ke-2, strip non-alphanumeric kecuali titik di akhir kata ke-1
        $w1 = strtolower($parts[0] ?? '');
        $w2 = isset($parts[1]) ? strtolower($parts[1]) : null;

        // Bersihkan karakter selain huruf, angka, dan titik
        $w1 = preg_replace('/[^a-z0-9.]/', '', $w1);

        // Jika kata ke-2 mengandung titik (gelar/singkatan), abaikan — username hanya kata ke-1
        if ($w2 !== null && strpos($w2, '.') !== false) {
            $w2 = null;
        } else {
            $w2 = $w2 !== null ? preg_replace('/[^a-z0-9]/', '', $w2) : null;
        }

        $username = ($w2 !== null && $w2 !== '')
            ? rtrim($w1, '.') . '.' . $w2
            : rtrim($w1, '.');

        return compact('firstName', 'lastName', 'username');
    }

    public function index(Request $request)
    {
        $query = User::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('unit_kerja', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return redirect()->route('admin.users.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nip' => ['nullable', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:8'],
            'unit_kerja' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'in:user,admin,driver'],
            'priority_level' => ['nullable', 'integer', 'in:0,1'],
        ]);

        $parsed = $this->parseNama($data['nama_lengkap']);

        // Pastikan username unik, tambah angka jika perlu
        $baseUsername = $parsed['username'];
        $username = $baseUsername;
        $i = 1;
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $i++;
        }

        User::create([
            'first_name'     => $parsed['firstName'],
            'last_name'      => $parsed['lastName'],
            'username'       => $username,
            'nip'            => $data['nip'] ?? null,
            'password'       => Hash::make($data['password']),
            'unit_kerja'     => $data['unit_kerja'] ?? null,
            'role'           => $data['role'],
            'priority_level' => $data['priority_level'] ?? 0,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return redirect()->route('admin.users.index');
    }

    public function update(Request $request, User $user)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nip' => ['nullable', 'string', 'max:50'],
            'password' => ['nullable', 'string', 'min:8'],
            'unit_kerja' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'in:user,admin,driver'],
            'priority_level' => ['nullable', 'integer', 'in:0,1'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.users.index')
                ->withErrors($validator)
                ->withInput()
                ->with('edit_id', $user->id)
                ->with('edit_nama_lengkap', $request->input('nama_lengkap'));
        }

        $data = $validator->validated();
        $parsed = $this->parseNama($data['nama_lengkap']);

        // Pastikan username unik, kecuali milik user ini sendiri
        $baseUsername = $parsed['username'];
        $username = $baseUsername;
        $i = 1;
        while (User::where('username', $username)->where('id', '!=', $user->id)->exists()) {
            $username = $baseUsername . $i++;
        }

        $updateData = [
            'first_name'     => $parsed['firstName'],
            'last_name'      => $parsed['lastName'],
            'username'       => $username,
            'nip'            => $data['nip'] ?? null,
            'unit_kerja'     => $data['unit_kerja'] ?? null,
            'role'           => $data['role'],
            'priority_level' => $data['priority_level'] ?? 0,
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
