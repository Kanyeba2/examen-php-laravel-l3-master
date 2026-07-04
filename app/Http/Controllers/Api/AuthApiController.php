<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Concerns\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    use ApiResponse;

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'mot_de_passe' => ['required', 'string'],
            'token_name' => ['nullable', 'string', 'max:255'],
        ]);

        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['mot_de_passe'], $user->mot_de_passe)) {
            return $this->error('Identifiants invalides.', 401);
        }

        if (! $user->actif) {
            return $this->error('Compte inactif.', 403);
        }

        $tokenName = $credentials['token_name'] ?? 'api-token';
        $token = $user->createToken($tokenName)->plainTextToken;

        return $this->success('Connexion API réussie.', [
            'token' => $token,
            'token_type' => 'Bearer',
            'utilisateur' => [
                'id' => $user->id,
                'nom' => $user->nom,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return $this->success('Profil API récupéré.', $request->user());
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return $this->success('Token révoqué avec succès.', null);
    }
}
