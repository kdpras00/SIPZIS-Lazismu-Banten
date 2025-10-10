<?php
// Simple script to check headers
$headers = getallheaders();
echo "<h1>Headers</h1>";
echo "<pre>";
print_r($headers);
echo "</pre>";

// Check if CSP header is present
if (isset($headers['Content-Security-Policy'])) {
    echo "<h2>Content-Security-Policy Header</h2>";
    echo "<pre>" . htmlspecialchars($headers['Content-Security-Policy']) . "</pre>";
} else {
    echo "<h2>No Content-Security-Policy Header Found</h2>";
}
