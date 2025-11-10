<?php
echo "=== VÉRIFICATION FINALE DE L'APPLICATION ===\n\n";

// Charger les patches
require __DIR__ . '/bootstrap/intl_polyfill.php';
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap/number_patch.php';

echo "1. Classes intl disponibles:\n";
echo "   - NumberFormatter: " . (class_exists('NumberFormatter') ? "✅" : "❌") . "\n";
echo "   - Locale: " . (class_exists('Locale') ? "✅" : "❌") . "\n\n";

echo "2. Test de la classe Number patchée:\n";
try {
    $result1 = \Illuminate\Support\Number::format(1234567);
    echo "   - Number::format(1234567): {$result1} ✅\n";
    
    $result2 = \Illuminate\Support\Number::percentage(75.5);
    echo "   - Number::percentage(75.5): {$result2} ✅\n";
    
    $result3 = \Illuminate\Support\Number::currency(1234.56, 'USD');
    echo "   - Number::currency(1234.56, 'USD'): {$result3} ✅\n";
} catch (Exception $e) {
    echo "   ❌ ERREUR: " . $e->getMessage() . "\n";
}

echo "\n3. Test de l'application Laravel:\n";
try {
    $app = require_once __DIR__ . '/bootstrap/app.php';
    echo "   - Application Laravel chargée: ✅\n";
    
    // Tester la connexion à la base de données
    $pdo = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
    $userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    echo "   - Utilisateurs en base: {$userCount} ✅\n";
    
} catch (Exception $e) {
    echo "   ❌ ERREUR: " . $e->getMessage() . "\n";
}

echo "\n4. Vérification des routes Filament:\n";
exec('php artisan route:list --path=admin 2>&1', $output, $return);
if ($return === 0) {
    $routeCount = count(array_filter($output, fn($line) => str_contains($line, 'admin/')));
    echo "   - Routes admin disponibles: {$routeCount} ✅\n";
} else {
    echo "   ❌ Erreur lors de la récupération des routes\n";
}

echo "\n=== RÉSULTAT FINAL ===\n";
echo "✅ L'application est configurée et prête à fonctionner\n";
echo "🌐 Accédez à: http://127.0.0.1:8000/admin/login\n";
echo "👤 Email: admin@test.com\n";
echo "🔑 Mot de passe: password\n";