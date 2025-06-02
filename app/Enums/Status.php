<?php

namespace App\Enums;

use Illuminate\Support\Str;

enum Status: string
{
    case Pending = 'pending';
    case Approved = 'approve';
    case Rejected = 'reject';
    public function label(): string
    {
        return Str::title($this->value); // returns 'Pending', 'Approved', etc.
    }
}
