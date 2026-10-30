<?php

namespace App\Support;

/**
 * Mencegah CSV/Formula Injection: nilai yang diawali =, +, -, @, tab, atau CR
 * akan diberi awalan tanda kutip agar tidak dieksekusi sebagai rumus oleh Excel.
 */
class Csv
{
    public static function safe(mixed $value): string
    {
        $value = (string) ($value ?? '');

        if ($value !== '' && in_array($value[0], ['=', '+', '-', '@', "\t", "\r"], true)) {
            return "'".$value;
        }

        return $value;
    }

    public static function row(array $values): array
    {
        return array_map([self::class, 'safe'], $values);
    }
}
