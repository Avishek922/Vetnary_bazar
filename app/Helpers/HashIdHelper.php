<?php

namespace App\Helpers;

class HashIdHelper
{
    private static $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    private static $salt = 'VetBazaar_Secret_Salt_2024';
    private static $minLength = 8;

    /**
     * Encode an integer ID into an obfuscated string.
     */
    public static function encode(int $id): string
    {
        $hash = "";
        $n = $id + 100000; // Add offset to avoid small IDs looking simple
        $base = strlen(self::$alphabet);

        while ($n > 0) {
            $hash = self::$alphabet[$n % $base] . $hash;
            $n = intval($n / $base);
        }

        // Add some "salt" logic - simple but effective for masking
        $checkSum = self::getCheckSum($id);
        return str_pad($hash, self::$minLength, 'v', STR_PAD_LEFT) . self::$alphabet[$checkSum % $base];
    }

    /**
     * Decode an obfuscated string back into an integer ID.
     */
    public static function decode(string $hash): ?int
    {
        // If it's a numeric string, it might be a raw ID from an old link or dev environment
        if (is_numeric($hash) && intval($hash) > 0) {
            return intval($hash);
        }

        if (strlen($hash) < self::$minLength + 1) return null;

        $checkSumChar = substr($hash, -1);
        $content = ltrim(substr($hash, 0, -1), 'v');
        
        $base = strlen(self::$alphabet);
        $n = 0;
        
        for ($i = 0; $i < strlen($content); $i++) {
            $pos = strpos(self::$alphabet, $content[$i]);
            if ($pos === false) return null;
            $n = $n * $base + $pos;
        }

        $id = $n - 100000;
        
        // Verify checksum
        if (self::$alphabet[self::getCheckSum($id) % $base] !== $checkSumChar) {
            return null;
        }

        return $id > 0 ? $id : null;
    }

    private static function getCheckSum(int $id): int
    {
        $s = self::$salt . $id;
        $hash = md5($s);
        return hexdec(substr($hash, 0, 4));
    }
}
