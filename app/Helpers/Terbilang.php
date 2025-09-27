<?php

namespace App\Helpers;

class Terbilang
{
    private static $satuan = [
        '', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan',
        'sepuluh', 'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas',
        'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas'
    ];

    private static $puluhan = [
        '', '', 'dua puluh', 'tiga puluh', 'empat puluh', 'lima puluh',
        'enam puluh', 'tujuh puluh', 'delapan puluh', 'sembilan puluh'
    ];

    /**
     * Convert number to Indonesian words
     *
     * @param int $number
     * @return string
     */
    public static function convert($number)
    {
        if ($number == 0) {
            return 'nol';
        }

        if ($number < 0) {
            return 'minus ' . self::convert(abs($number));
        }

        $result = '';

        // Triliun
        if ($number >= 1000000000000) {
            $triliun = intval($number / 1000000000000);
            $result .= self::convertHundreds($triliun) . ' triliun ';
            $number %= 1000000000000;
        }

        // Miliaran
        if ($number >= 1000000000) {
            $miliaran = intval($number / 1000000000);
            $result .= self::convertHundreds($miliaran) . ' miliaran ';
            $number %= 1000000000;
        }

        // Jutaan
        if ($number >= 1000000) {
            $jutaan = intval($number / 1000000);
            $result .= self::convertHundreds($jutaan) . ' juta ';
            $number %= 1000000;
        }

        // Ribuan
        if ($number >= 1000) {
            $ribuan = intval($number / 1000);
            if ($ribuan == 1) {
                $result .= 'seribu ';
            } else {
                $result .= self::convertHundreds($ribuan) . ' ribu ';
            }
            $number %= 1000;
        }

        // Ratusan, puluhan, dan satuan
        if ($number > 0) {
            $result .= self::convertHundreds($number);
        }

        return trim($result);
    }

    /**
     * Convert numbers under 1000 to words
     *
     * @param int $number
     * @return string
     */
    private static function convertHundreds($number)
    {
        $result = '';

        // Ratusan
        if ($number >= 100) {
            $ratusan = intval($number / 100);
            if ($ratusan == 1) {
                $result .= 'seratus ';
            } else {
                $result .= self::$satuan[$ratusan] . ' ratus ';
            }
            $number %= 100;
        }

        // Puluhan dan satuan
        if ($number >= 20) {
            $puluhan = intval($number / 10);
            $result .= self::$puluhan[$puluhan] . ' ';
            $number %= 10;
            if ($number > 0) {
                $result .= self::$satuan[$number] . ' ';
            }
        } elseif ($number > 0) {
            $result .= self::$satuan[$number] . ' ';
        }

        return trim($result);
    }

    /**
     * Convert currency to Indonesian words with "rupiah" suffix
     *
     * @param int $amount
     * @return string
     */
    public static function currency($amount)
    {
        return self::convert($amount) . ' rupiah';
    }

    /**
     * Convert currency with proper capitalization
     *
     * @param int $amount
     * @return string
     */
    public static function currencyCapitalized($amount)
    {
        return ucfirst(self::currency($amount));
    }
}