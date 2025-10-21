<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->boot();

use App\Models\User;

echo "📊 Existing Users in Database:\n";
echo "===============================\n\n";

$users = User::select('name', 'email', 'role', 'is_active')->get();

if ($users->count() > 0) {
    foreach ($users as $user) {
        $status = $user->is_active ? '✅ Active' : '❌ Inactive';
        $roleIcon = $user->role === 'admin' ? '🔑' : '👤';
        
        echo "{$roleIcon} {$user->name}\n";
        echo "   📧 Email: {$user->email}\n";
        echo "   🎭 Role: {$user->role}\n";
        echo "   📊 Status: {$status}\n";
        echo "   🔐 Password: password123 (default)\n\n";
    }
    
    echo "🌐 Login URL: http://127.0.0.1:8000/login\n";
    echo "📝 Register URL: http://127.0.0.1:8000/register\n";
} else {
    echo "❌ No users found in database.\n";
    echo "💡 You can register a new account at: http://127.0.0.1:8000/register\n";
}