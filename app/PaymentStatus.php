<?php

namespace App;

enum PaymentStatus: int
{
    case UNPAID = 1;
    case PAID = 2;
    case EXPIRED = 3;

    public function label(): string
    {
        return match ($this) {
            self::UNPAID => 'Unpaid',
            self::PAID => 'Paid',
            self::EXPIRED => 'Expired',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::UNPAID => 'warning',
            self::PAID => 'success',
            self::EXPIRED => 'danger',
        };
    }
}
