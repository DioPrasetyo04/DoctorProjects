<?php

namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'photo' => $data['photo'] ?? null,
            'gender' => $data['gender'],
            'password' => Hash::make($data['password'])
        ]);

        // menambahkan default user ke role customer menggunakan assign role package bawaan laravel spatie
        $user->assignRole('customer');

        // digunakan untuk check roles user load data roles check autentikasi permission (izin aksees) user via website
        return $user->load('roles');
    }

    public function login(array $data)
    {
        // menyiapkan credential input yang akan diinput oleh user melalui form frontend untuk divalidasi ke logical backend
        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];

        // check autentikasi apakah data email dan password tersedia dan sesuai dengan data di database melalui library auth bawaan laravel
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'The provided credentials do not match our records',
            ], 401);
        }

        // refresh generate ulang session autentikasi jika session tersedia pada request
        if (request()->hasSession()) {
            request()->session()->regenerate();
        }

        // proses autentikasi user menggunakan laravel sanctum
        /** @var User $user */
        $user = Auth::user();

        return response()->json([
            'message' => 'Login Successfully',
            'user' => new UserResource($user->load('roles')),
        ]);
    }

    public function tokenLogin(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'The provided credentials do not match our records',
            ], 401);
        }

        // generate token auth login via laravel sanctum
        $token = $user->createToken('AUTH_TOKEN')->plainTextToken;

        return response()->json([
            'message' => 'Login Successfully',
            'token' => $token,
            'user' => new UserResource($user->load('roles')),
        ]);
    }
}
