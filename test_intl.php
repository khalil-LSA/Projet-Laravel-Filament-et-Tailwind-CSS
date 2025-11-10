<?php
// Test du polyfill intl
echo "=== TEST DU POLYFILL INTL ===\n\n";

require __DIR__ . '/bootstrap/intl_polyfill.php';

echo "1. Classes chargées:\n";
echo "   - NumberFormatter: " . (class_exists('NumberFormatter') ? "✅" : "❌") . "\n";
echo "   - Locale: " . (class_exists('Locale') ? "✅" : "❌") . "\n";
echo "   - IntlDateFormatter: " . (class_exists('IntlDateFormatter') ? "✅" : "❌") . "\n\n";

echo "2. Test NumberFormatter:\n";
try {
    $formatter = new NumberFormatter('en_US', NumberFormatter::DECIMAL);
    echo "   - Création: ✅\n";
    $result = $formatter->format(1234567);
    echo "   - Format nombre: {$result} ✅\n";
} catch (Exception $e) {
    echo "   - ERREUR: " . $e->getMessage() . "\n";
}

echo "\n3. Test Locale:\n";
try {
    $locale = Locale::getDefault();
    echo "   - Locale par défaut: {$locale} ✅\n";
} catch (Exception $e) {
    echo "   - ERREUR: " . $e->getMessage() . "\n";
}

echo "\n4. Test avec Laravel Number:\n";
require __DIR__ . '/vendor/autoload.php';
try {
    $app = require_once __DIR__ . '/bootstrap/app.php';
    echo "   - Application Laravel: ✅\n";
    
    // Tester la classe Number de Laravel
    $formatted = \Illuminate\Support\Number::format(1234567);
    echo "   - Number::format(1234567): {$formatted} ✅\n";
    
} catch (Exception $e) {
    echo "   - ERREUR: " . $e->getMessage() . "\n";
    echo "   - Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== TEST TERMINÉ ===\n";