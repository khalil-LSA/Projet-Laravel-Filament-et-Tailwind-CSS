<?php
/**
 * Patch pour la classe Illuminate\Support\Number
 * Contourne la vérification de l'extension intl
 */

namespace Illuminate\Support;

// Sauvegarder la classe originale si elle existe
if (class_exists('\Illuminate\Support\Number', false)) {
    class_alias('\Illuminate\Support\Number', '\Illuminate\Support\NumberOriginal');
}

/**
 * Version patchée de la classe Number qui n'exige pas l'extension intl
 */
class Number
{
    /**
     * Format a number.
     */
    public static function format(
        int|float $number,
        ?int $precision = null,
        ?int $maxPrecision = null,
        ?string $locale = null
    ): string {
        // Utiliser number_format de PHP au lieu de NumberFormatter
        if ($precision !== null) {
            return number_format($number, $precision, '.', ',');
        }
        
        // Format automatique basé sur le nombre
        if (is_int($number) || floor($number) == $number) {
            return number_format($number, 0, '.', ',');
        }
        
        return number_format($number, 2, '.', ',');
    }

    /**
     * Format a number as a percentage.
     */
    public static function percentage(
        int|float $number,
        int $precision = 0,
        ?int $maxPrecision = null,
        ?string $locale = null
    ): string {
        return number_format($number, $precision, '.', ',') . '%';
    }

    /**
     * Format a number as a currency.
     */
    public static function currency(
        int|float $number,
        string $in = 'USD',
        ?string $locale = null
    ): string {
        $symbol = match($in) {
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            default => $in . ' ',
        };
        
        return $symbol . number_format($number, 2, '.', ',');
    }

    /**
     * Format a number for human readability.
     */
    public static function forHumans(
        int|float $number,
        int $precision = 0,
        ?int $maxPrecision = null,
        ?string $locale = null
    ): string {
        if ($number >= 1000000000) {
            return number_format($number / 1000000000, $precision) . 'B';
        }
        if ($number >= 1000000) {
            return number_format($number / 1000000, $precision) . 'M';
        }
        if ($number >= 1000) {
            return number_format($number / 1000, $precision) . 'K';
        }
        
        return (string) $number;
    }

    /**
     * Spell out a number.
     */
    public static function spell(
        int|float $number,
        ?string $locale = null,
        ?int $after = null,
        ?int $until = null
    ): string {
        // Simple conversion pour les nombres courants
        $ones = ['', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
        $teens = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
        $tens = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
        
        if ($number < 10) {
            return $ones[$number];
        }
        if ($number < 20) {
            return $teens[$number - 10];
        }
        if ($number < 100) {
            return $tens[(int)($number / 10)] . ($number % 10 ? '-' . $ones[$number % 10] : '');
        }
        
        return (string) $number;
    }

    /**
     * Convert a number to its ordinal form.
     */
    public static function ordinal(int|float $number, ?string $locale = null): string
    {
        $suffix = match ((int) $number % 100) {
            11, 12, 13 => 'th',
            default => match ((int) $number % 10) {
                1 => 'st',
                2 => 'nd',
                3 => 'rd',
                default => 'th',
            }
        };
        
        return $number . $suffix;
    }

    /**
     * Format a number using the current locale.
     */
    public static function useLocale(string $locale, callable $callback): mixed
    {
        return $callback();
    }

    /**
     * Ensure the intl extension is installed (patched to always pass).
     */
    protected static function ensureIntlExtensionIsInstalled(): void
    {
        // Ne rien faire - on contourne la vérification
        return;
    }

    /**
     * Get all available methods (for compatibility).
     */
    public static function __callStatic($method, $parameters)
    {
        // Fallback pour les méthodes non implémentées
        return number_format($parameters[0] ?? 0, 2, '.', ',');
    }
}