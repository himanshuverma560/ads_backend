<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class VerifyJwt
{
    private function base64UrlDecode(string $input): string
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $input .= str_repeat('=', 4 - $remainder);
        }
        return base64_decode(strtr($input, '-_', '+/')) ?: '';
    }

    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Authorization');
        if (!$header || !preg_match('/Bearer\s+(.*)/', $header, $matches)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $token = $matches[1];
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            return response()->json(['message' => 'Invalid token'], 401);
        }
        [$headerB64, $payloadB64, $signature] = $parts;

        $expected = rtrim(strtr(base64_encode(hash_hmac('sha256', "$headerB64.$payloadB64", env('JWT_SECRET', 'secret'), true)), '+/', '-_'), '=');
        if (!hash_equals($expected, $signature)) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        $payload = json_decode($this->base64UrlDecode($payloadB64), true);
        if (!$payload || !isset($payload['sub'])) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        $user = User::find($payload['sub']);
        if (!$user || !$user->is_admin) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}
