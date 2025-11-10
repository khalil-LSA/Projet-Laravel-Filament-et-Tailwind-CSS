<?php

namespace App\Polyfills;

/**
 * Polyfill temporaire pour l'extension intl manquante
 * ATTENTION: Cette solution est temporaire. L'extension intl doit être activée.
 */
class IntlPolyfill
{
    public static function register()
    {
        if (!extension_loaded('intl') && !class_exists('NumberFormatter')) {
            // Créer une classe NumberFormatter basique
            eval('
                class NumberFormatter {
                    const DECIMAL = 1;
                    const CURRENCY = 2;
                    const PERCENT = 3;
                    
                    private $locale;
                    private $style;
                    
                    public function __construct($locale, $style) {
                        $this->locale = $locale;
                        $this->style = $style;
                    }
                    
                    public static function create($locale, $style) {
                        return new self($locale, $style);
                    }
                    
                    public function format($number) {
                        if ($this->style === self::PERCENT) {
                            return number_format($number * 100, 2) . "%";
                        }
                        if ($this->style === self::CURRENCY) {
                            return "$" . number_format($number, 2);
                        }
                        return number_format($number, 2);
                    }
                    
                    public function formatCurrency($number, $currency) {
                        return $currency . " " . number_format($number, 2);
                    }
                }
            ');
        }
        
        if (!extension_loaded('intl') && !class_exists('Locale')) {
            eval('
                class Locale {
                    public static function getDefault() {
                        return "en_US";
                    }
                    
                    public static function setDefault($locale) {
                        return true;
                    }
                }
            ');
        }
    }
}