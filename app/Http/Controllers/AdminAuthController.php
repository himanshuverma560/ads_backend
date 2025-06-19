<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{
    private function base64UrlEncode(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    private function generateToken(User $user): string
    {
        $header = $this->base64UrlEncode(json_encode(['alg' => 'HS256', 'typ' => 'JWT']));
        $payload = $this->base64UrlEncode(json_encode([
            'sub' => $user->id,
            'iat' => time(),
        ]));
        $signature = hash_hmac('sha256', "$header.$payload", env('JWT_SECRET', 'secret'), true);
        $signature = $this->base64UrlEncode($signature);
        return "$header.$payload.$signature";
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $credentials = $validator->validated();

            $user = User::where('email', $credentials['email'])
                ->where('is_admin', true)
                ->first();

            if (! $user || ! Hash::check($credentials['password'], $user->password)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            return response()->json([
                'token' => $this->generateToken($user),
                'name' => $user->name,
                'email' => $user->email,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }
}
