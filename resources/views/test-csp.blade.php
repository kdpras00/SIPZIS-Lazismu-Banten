<!DOCTYPE html>
<html>

<head>
    <title>CSP Test</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <h1>CSP Test Page</h1>
    <p>This is a simple test page to check CSP headers.</p>

    <script>
        // Simple test script that doesn't use eval
        console.log('Test script loaded');
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded');
        });
    </script>
</body>

</html>