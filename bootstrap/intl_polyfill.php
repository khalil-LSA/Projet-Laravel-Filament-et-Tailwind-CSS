<?php
/**
 * Polyfill intl - À charger avant l'autoloader Laravel
 * Ce fichier crée les classes intl si elles n'existent pas
 */

if (!extension_loaded('intl')) {
    if (!class_exists('NumberFormatter', false)) {
        class NumberFormatter {
            const DECIMAL = 1;
            const CURRENCY = 2;
            const PERCENT = 3;
            const SCIENTIFIC = 4;
            const SPELLOUT = 5;
            const ORDINAL = 6;
            const DURATION = 7;
            const PATTERN_DECIMAL = 0;
            const PATTERN_RULEBASED = 9;
            const CURRENCY_CODE = 0;
            
            private $locale;
            private $style;
            private $pattern;
            
            public function __construct($locale, $style, $pattern = null) {
                $this->locale = $locale;
                $this->style = $style;
                $this->pattern = $pattern;
            }
            
            public static function create($locale, $style, $pattern = null) {
                return new self($locale, $style, $pattern);
            }
            
            public function format($number, $type = null) {
                if ($this->style === self::PERCENT) {
                    return number_format($number * 100, 2) . '%';
                }
                if ($this->style === self::CURRENCY) {
                    return '$' . number_format($number, 2, '.', ',');
                }
                return number_format($number, 0, '.', ',');
            }
            
            public function formatCurrency($number, $currency) {
                return $currency . ' ' . number_format($number, 2, '.', ',');
            }
            
            public function setAttribute($attr, $value) { return true; }
            public function setTextAttribute($attr, $value) { return true; }
            public function setSymbol($attr, $value) { return true; }
            public function getErrorCode() { return 0; }
            public function getErrorMessage() { return ''; }
        }
    }
    
    if (!class_exists('Locale', false)) {
        class Locale {
            const DEFAULT_LOCALE = 'en_US_POSIX';
            
            public static function getDefault() {
                return 'en_US';
            }
            
            public static function setDefault($locale) {
                return true;
            }
            
            public static function acceptFromHttp($header) {
                return 'en_US';
            }
            
            public static function canonicalize($locale) {
                return $locale;
            }
            
            public static function getDisplayLanguage($locale, $in_locale = null) {
                return 'English';
            }
        }
    }
    
    if (!class_exists('IntlDateFormatter', false)) {
        class IntlDateFormatter {
            const FULL = 0;
            const LONG = 1;
            const MEDIUM = 2;
            const SHORT = 3;
            const NONE = -1;
            const GREGORIAN = 1;
            
            private $locale;
            private $datetype;
            private $timetype;
            
            public function __construct($locale, $datetype, $timetype, $timezone = null, $calendar = null, $pattern = null) {
                $this->locale = $locale;
                $this->datetype = $datetype;
                $this->timetype = $timetype;
            }
            
            public static function create($locale, $datetype, $timetype, $timezone = null, $calendar = null, $pattern = null) {
                return new self($locale, $datetype, $timetype, $timezone, $calendar, $pattern);
            }
            
            public function format($value) {
                if (is_int($value)) {
                    return date('Y-m-d H:i:s', $value);
                }
                if ($value instanceof DateTime) {
                    return $value->format('Y-m-d H:i:s');
                }
                return date('Y-m-d H:i:s');
            }
        }
    }
}
