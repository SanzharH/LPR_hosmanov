<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

class ApiFormat
{
    public static function success(
        mixed $payload,
        int $status = 200,
        array $page = []
    ): JsonResponse {
        $body = [
            'code' => $status,
            'payload' => $payload,
        ];

        if ($page !== []) {
            $body['page'] = $page;
        }

        $body['timestamp'] = now()->toIso8601String();
        $body['sign'] = config('lab.slug') . '/' . config('lab.code');

        return response()->json($body, $status, [], JSON_UNESCAPED_UNICODE);
    }

    public static function error(
        string $message,
        int $status,
        array $invalid = []
    ): JsonResponse {
        $body = [
            'code' => $status,
            'payload' => null,
            'error' => $message,
        ];

        if ($status === 422 && $invalid !== []) {
            $body['invalid'] = $invalid;
        }

        $body['timestamp'] = now()->toIso8601String();
        $body['sign'] = config('lab.slug') . '/' . config('lab.code');

        return response()->json($body, $status, [], JSON_UNESCAPED_UNICODE);
    }
}