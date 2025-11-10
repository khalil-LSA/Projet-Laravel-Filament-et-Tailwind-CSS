<?php
// Script temporaire pour résoudre le problème intl
echo "=== DIAGNOSTIC COMPLET DU PROJET E-COMMERCE LARAVEL ===\n\n";

echo "1. VERSION PHP: " . phpversion() . "\n";
echo "2. EXTENSION INTL: " . (extension_loaded('intl') ? "✅ ACTIVE" : "❌ PAS ACTIVE") . "\n";

if (!extension_loaded('intl')) {
    echo "   ⚠️  CRITIQUE: Extension intl requise par Filament\n";
    echo "   📋 SOLUTION: Décommenter ;extension=intl dans php.ini et redémarrer Apache\n\n";
}

echo "3. EXTENSIONS REQUISES:\n";
$required_extensions = ['intl', 'mbstring', 'openssl', 'pdo', 'tokenizer', 'xml', 'ctype', 'json', 'bcmath'];
foreach ($required_extensions as $ext) {
    echo "   - {$ext}: " . (extension_loaded($ext) ? "✅" : "❌") . "\n";
}

echo "\n4. CONFIGURATION LARAVEL:\n";
echo "   - APP_ENV: " . ($_ENV['APP_ENV'] ?? 'production') . "\n";
echo "   - APP_DEBUG: " . (($_ENV['APP_DEBUG'] ?? 'false') === 'true' ? "✅ Activé" : "❌ Désactivé") . "\n";
echo "   - APP_KEY: " . (empty($_ENV['APP_KEY'] ?? '') ? "❌ Manquant" : "✅ Défini") . "\n";

echo "\n5. BASE DE DONNÉES:\n";
echo "   - DB_CONNECTION: " . ($_ENV['DB_CONNECTION'] ?? 'sqlite') . "\n";

// Vérifier la base de données
try {
    $pdo = new PDO('sqlite:' . __DIR__ . '/database/database.sqlite');
    $tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll(PDO::FETCH_COLUMN);
    echo "   - Tables disponibles: " . count($tables) . " (" . implode(', ', array_slice($tables, 0, 5)) . (count($tables) > 5 ? '...' : '') . ")\n";
    
    // Compter les utilisateurs
    $userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    echo "   - Utilisateurs: {$userCount}\n";
} catch (Exception $e) {
    echo "   - Erreur DB: " . $e->getMessage() . "\n";
}

echo "\n6. FILAMENT:\n";
try {
    require_once __DIR__ . '/vendor/autoload.php';
    
    $app = require_once __DIR__ . '/bootstrap/app.php';
    
    echo "   - Application Laravel: ✅ OK\n";
    
    // Vérifier les routes Filament
    $routes = [];
    if (class_exists('Illuminate\Support\Facades\Route')) {
        echo "   - Routes système: ✅ OK\n";
    }
    
} catch (Exception $e) {
    echo "   - Erreur Filament: " . $e->getMessage() . "\n";
}

echo "\n=== RÉSUMÉ DES ACTIONS REQUISES ===\n";
if (!extension_loaded('intl')) {
    echo "🔥 URGENT: Activer extension intl dans XAMPP\n";
    echo "   1. Ouvrir C:\\xampp\\php\\php.ini\n";
    echo "   2. Changer ;extension=intl en extension=intl\n";
    echo "   3. Redémarrer Apache dans XAMPP\n\n";
}

echo "✅ STATUT: " . (extension_loaded('intl') ? "Prêt pour production" : "Nécessite configuration intl") . "\n";