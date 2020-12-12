<?php


namespace App\Service;


class NumberFormatService
{
    public static function format_number(float $digit): string
    {
        return number_format($digit, 2, '.', '');
    }
}
