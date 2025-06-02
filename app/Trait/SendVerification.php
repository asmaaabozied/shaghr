<?php

namespace App\Trait;

use App\Models\PhoneVerification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait SendVerification
{
    /**
     * @param string $phoneNumber
     * @return array
     */
    private function send(string $phoneNumber): array
    {
        try {
            return [
                'id' => (string)Str::uuid(),
                'driver' => 'sms driver',
            ];
        } catch (\Throwable $exception) {
            Log::error('otp integration', [$exception->getMessage()]);
            return [
                'id' => (string)Str::uuid(),
                'driver' => 'sms driver',
            ];
        }
    }

    /**
     * @param string $phoneNumber
     * @return false
     */
    private function check(string $phoneNumber, int $code)
    {
        try {
            return PhoneVerification::where([
                'phone' => $phoneNumber,
                'code' => $code
            ])->where('created_at', '>', now()->subMinutes(5))->exists();
        } catch (\Throwable $exception) {
            return false;
        }
    }
}
