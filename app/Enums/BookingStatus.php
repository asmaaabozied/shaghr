<?php

namespace App\Enums;

enum BookingStatus:string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Canceled = 'canceled';

    /**
     * Get the label for each status.
     */
    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending Approval',
            self::Confirmed => 'Confirmed',
            self::Canceled => 'Canceled',
        };
    }
}
