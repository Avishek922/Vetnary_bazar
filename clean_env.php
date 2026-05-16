<?php
$envPath = '.env';
if (file_exists($envPath)) {
    $content = file_get_contents($envPath);
    // Remove Google-related lines and comments
    $newContent = preg_replace('/# Google Social Login\s*/', '', $content);
    $newContent = preg_replace('/GOOGLE_CLIENT_ID=.*\n?/', '', $newContent);
    $newContent = preg_replace('/GOOGLE_CLIENT_SECRET=.*\n?/', '', $newContent);
    $newContent = preg_replace('/GOOGLE_REDIRECT_URI=.*\n?/', '', $newContent);
    
    // Clean up extra newlines at the end
    $newContent = rtrim($newContent) . "\n";
    
    file_put_contents($envPath, $newContent);
    echo "Successfully cleaned .env";
} else {
    echo ".env file not found";
}
