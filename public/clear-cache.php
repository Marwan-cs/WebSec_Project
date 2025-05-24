<?php
// Load Laravel environment
require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "<h1>Clearing Laravel Cache</h1>";

try {
    // Clear application cache
    $kernel->call('cache:clear');
    echo "<p>✅ Application cache cleared</p>";
} catch (Exception $e) {
    echo "<p>❌ Error clearing application cache: " . $e->getMessage() . "</p>";
}

try {
    // Clear route cache
    $kernel->call('route:clear');
    echo "<p>✅ Route cache cleared</p>";
} catch (Exception $e) {
    echo "<p>❌ Error clearing route cache: " . $e->getMessage() . "</p>";
}

try {
    // Clear config cache
    $kernel->call('config:clear');
    echo "<p>✅ Config cache cleared</p>";
} catch (Exception $e) {
    echo "<p>❌ Error clearing config cache: " . $e->getMessage() . "</p>";
}

try {
    // Clear view cache
    $kernel->call('view:clear');
    echo "<p>✅ View cache cleared</p>";
} catch (Exception $e) {
    echo "<p>❌ Error clearing view cache: " . $e->getMessage() . "</p>";
}

echo "<p>Done! <a href='/'>Return to home</a></p>"; 