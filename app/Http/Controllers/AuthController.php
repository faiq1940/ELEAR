<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|in:mahasiswa,dosen',
        ]);

        $user = User::where(function ($query) use ($request) {
                $query->where('name', $request->name)
                    ->orWhere('nama', $request->name);
            })
            ->where('role', $request->role)
            ->first();

        $passwordMatches = $user && (Hash::check($request->password, $user->password) || $user->password === $request->password);

        if ($passwordMatches) {
            if ($user->password !== $request->password && Hash::needsRehash($user->password)) {
                $user->password = Hash::make($request->password);
                $user->save();
            }

            Session::put('user', [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
            ]);

            return redirect()->route($request->role === 'dosen' ? 'dashboard.dosen' : 'dashboard.mahasiswa')
                ->with('success', 'Login berhasil');
        }

        return redirect('/')->with('error', 'Login gagal. Nama, password, atau role salah.');
    }

    public function mahasiswaDashboard()
    {
        if (!Session::get('user') || Session::get('user.role') !== 'mahasiswa') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses.');
        }

        return view('dashboard.mahasiswa');
    }

    public function dosenDashboard()
    {
        if (!Session::get('user') || Session::get('user.role') !== 'dosen') {
            return redirect('/')->with('error', 'Anda tidak memiliki akses.');
        }

        return view('dashboard.dosen');
    }

    public function logout()
    {
        Session::forget('user');

        return redirect('/')->with('success', 'Berhasil logout');
    }
}
