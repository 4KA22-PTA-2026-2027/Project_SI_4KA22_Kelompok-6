<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\KolProfile;
use App\Models\BrandProfile;

class AuthController extends Controller
{
    public function showRoleSelect()
    {
        return view('auth.register-select');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['email' => 'Email atau kata sandi tidak sesuai.'])->onlyInput('email');
    }

    public function showRegister(Request $request)
    {
        $role = $request->input('role', 'kol');
        return view('auth.register', compact('role'));
    }

    public function register(Request $request)
    {
        $role = $request->input('role', 'kol');
        
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
        ];

        if ($role === 'brand') {
            $rules['invitation_code'] = 'required|string';
        }

        $request->validate($rules);

        if ($role === 'brand' && !in_array(strtoupper(trim($request->invitation_code)), ['ABCD', 'BRAND2024'])) {
            return back()->withErrors(['invitation_code' => 'Kode tidak valid'])->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $role,
            'invitation_code' => $request->invitation_code,
        ]);

        if ($role === 'kol') {
            $categoryId = null;
            if ($request->filled('niche')) {
                $cat = \App\Models\TalentCategory::where('name', 'like', $request->niche)->first();
                if ($cat) {
                    $categoryId = $cat->id;
                }
            }
            $platform = strtolower($request->input('social_platform', ''));
            $kolData = [
                'user_id' => $user->id,
                'talent_category_id' => $categoryId,
            ];
            if (str_contains($platform, 'tiktok')) {
                $kolData['tiktok'] = '@' . strtolower(str_replace(' ', '', $user->name));
            } elseif (str_contains($platform, 'youtube')) {
                $kolData['youtube'] = $user->name;
            } else {
                $kolData['instagram'] = '@' . strtolower(str_replace(' ', '', $user->name));
            }
            KolProfile::create($kolData);
        } elseif ($role === 'brand') {
            BrandProfile::create([
                'user_id' => $user->id,
                'company_name' => $request->name,
            ]);
        }

        Auth::login($user);
        return redirect()->route('dashboard');
    }

    public function showForgotPassword(Request $request)
    {
        $step = (int) $request->input('step', 1);
        return view('auth.forgot-password', compact('step'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        return redirect()->route('login')->with('success', 'Kata sandi berhasil diperbarui. Silakan masuk.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
