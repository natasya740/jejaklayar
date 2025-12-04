<?php
/**
 * Check Folder Structure
 * Akses: http://127.0.0.1:8000/check-folders.php
 * HAPUS SETELAH SELESAI!
 */

function checkPath($path, $label) {
    echo "<div style='margin: 10px 0; padding: 10px; border: 1px solid #ccc; border-radius: 5px;'>";
    echo "<strong>$label</strong><br>";
    echo "Path: <code>$path</code><br>";
    
    if (file_exists($path)) {
        echo "Status: <span style='color: green; font-weight: bold;'>✅ EXISTS</span><br>";
        
        if (is_dir($path)) {
            echo "Type: 📁 Directory<br>";
            
            // Check if it's a symlink
            if (is_link($path)) {
                echo "Link: 🔗 Symlink → " . readlink($path) . "<br>";
            }
            
            // Check permissions
            echo "Writable: " . (is_writable($path) ? '✅ YES' : '❌ NO') . "<br>";
            
            // List contents
            $contents = scandir($path);
            $files = array_filter($contents, function($item) { return $item !== '.' && $item !== '..'; });
            echo "Contents: " . count($files) . " item(s)<br>";
            
            if (count($files) > 0) {
                echo "<ul style='margin: 5px 0; padding-left: 20px;'>";
                foreach ($files as $file) {
                    $fullPath = $path . '/' . $file;
                    $type = is_dir($fullPath) ? '📁' : '📄';
                    $size = is_file($fullPath) ? ' (' . number_format(filesize($fullPath) / 1024, 2) . ' KB)' : '';
                    echo "<li>$type $file$size</li>";
                }
                echo "</ul>";
            }
        } else {
            echo "Type: 📄 File<br>";
        }
    } else {
        echo "Status: <span style='color: red; font-weight: bold;'>❌ NOT FOUND</span><br>";
        echo "Action: <code>mkdir -p " . str_replace(__DIR__ . '/', '', $path) . "</code><br>";
    }
    
    echo "</div>";
}

echo "<h1>📁 Folder Structure Checker</h1>";
echo "<hr>";

// Check required paths
$paths = [
    'public/storage' => __DIR__ . '/storage',
    'public/storage/profile' => __DIR__ . '/storage/profile',
    'storage/app/public' => dirname(__DIR__) . '/storage/app/public',
    'storage/app/public/profile' => dirname(__DIR__) . '/storage/app/public/profile',
];

foreach ($paths as $label => $path) {
    checkPath($path, $label);
}

echo "<hr>";
echo "<h2>📋 Summary:</h2>";

$allGood = true;
$messages = [];

if (!file_exists(__DIR__ . '/storage')) {
    $messages[] = "❌ Symlink <code>public/storage</code> belum dibuat. Jalankan: <code>php artisan storage:link</code>";
    $allGood = false;
}

if (!file_exists(dirname(__DIR__) . '/storage/app/public')) {
    $messages[] = "❌ Folder <code>storage/app/public</code> belum ada. Buat dengan: <code>mkdir -p storage/app/public</code>";
    $allGood = false;
}

if (!file_exists(dirname(__DIR__) . '/storage/app/public/profile')) {
    $messages[] = "❌ Folder <code>storage/app/public/profile</code> belum ada. Buat dengan: <code>mkdir -p storage/app/public/profile</code>";
    $allGood = false;
}

if ($allGood) {
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px;'>";
    echo "<strong>✅ Semua folder sudah OK!</strong><br>";
    echo "Silakan upload foto dari form edit profil.";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px;'>";
    echo "<strong>⚠️ Ada masalah yang perlu diperbaiki:</strong><br><ul style='margin: 10px 0;'>";
    foreach ($messages as $msg) {
        echo "<li>$msg</li>";
    }
    echo "</ul></div>";
}

echo "<hr>";
echo "<h2>🔧 Quick Fix Commands:</h2>";
echo "<pre style='background: #f5f5f5; padding: 15px; border-radius: 5px; overflow-x: auto;'>";
echo "# Windows PowerShell (Run as Administrator)\n";
echo "mkdir storage\\app\\public\\profile -Force\n";
echo "Remove-Item public\\storage -Force -ErrorAction SilentlyContinue\n";
echo "New-Item -ItemType SymbolicLink -Path \"public\\storage\" -Target \"storage\\app\\public\"\n\n";

echo "# Or using Laravel Artisan\n";
echo "php artisan storage:link --force\n";
echo "</pre>";

echo "<hr>";
echo "<p style='color: red; font-weight: bold;'>⚠️ HAPUS FILE INI SETELAH SELESAI!</p>";
?>