<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Number;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Patch temporaire pour contourner le problème de l'extension intl
        if (!extension_loaded('intl')) {
            // Créer les classes intl manquantes
            if (!class_exists('NumberFormatter')) {
                eval('
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
                        
                        private $locale;
                        private $style;
                        
                        public function __construct($locale, $style) {
                            $this->locale = $locale;
                            $this->style = $style;
                        }
                        
                        public static function create($locale, $style) {
                            return new self($locale, $style);
                        }
                        
                        public function format($number, $type = null) {
                            if ($this->style === self::PERCENT) {
                                return number_format($number * 100, 2) . "%";
                            }
                            if ($this->style === self::CURRENCY) {
                                return "$" . number_format($number, 2);
                            }
                            return number_format($number, 0, ".", ",");
                        }
                        
                        public function formatCurrency($number, $currency) {
                            return $currency . " " . number_format($number, 2);
                        }
                        
                        public function setAttribute($attr, $value) {}
                        public function setTextAttribute($attr, $value) {}
                        public function setSymbol($attr, $value) {}
                    }
                ');
            }
            
            if (!class_exists('Locale')) {
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

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
