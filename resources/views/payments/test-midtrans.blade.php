<!DOCTYPE html>
<html>
<head>
    <title>Midtrans Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Add Content Security Policy to allow required scripts -->
    @if (app()->environment('local'))
    <meta http-equiv="Content-Security-Policy" content="script-src 'self' 'unsafe-eval' 'unsafe-inline' http://localhost:5173 http://127.0.0.1:5173 http://[::1]:5173 https://localhost:5173 https://127.0.0.1:5173 https://[::1]:5173 https://app.stg.midtrans.com https://app.midtrans.com https://snap-assets.al-pc-id-s.cdn.gtflabs.io https://api.stg.midtrans.com https://pay.google.com https://js-agent.newrelic.com https://bam.nr-data.net https://integration-gwk.gopayapi.com/sdk/stable/gp-container.min.js; object-src 'none';">
    @else
    <meta http-equiv="Content-Security-Policy" content="script-src 'self' 'unsafe-eval' 'unsafe-inline' https://app.stg.midtrans.com https://app.midtrans.com https://snap-assets.al-pc-id-s.cdn.gtflabs.io https://api.stg.midtrans.com https://pay.google.com https://js-agent.newrelic.com https://bam.nr-data.net https://integration-gwk.gopayapi.com/sdk/stable/gp-container.min.js; object-src 'none';">
    @endif
</head>
<body>
    <h1>Midtrans Configuration Test</h1>
    
    <div id="result">
        <p>Checking Midtrans configuration...</p>
    </div>

    <!-- Midtrans Snap.js -->
    <script type="text/javascript"
        src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.stg.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resultDiv = document.getElementById('result');
            
            // Check if Midtrans is loaded
            if (typeof snap !== 'undefined') {
                resultDiv.innerHTML = '<p style="color: green;">✓ Midtrans Snap.js loaded successfully</p>';
                resultDiv.innerHTML += '<p>Client Key: {{ config('midtrans.client_key') ? '✓ Configured' : '✗ Not configured' }}</p>';
                resultDiv.innerHTML += '<p>Server Key: {{ config('midtrans.server_key') ? '✓ Configured' : '✗ Not configured' }}</p>';
                resultDiv.innerHTML += '<p>Environment: {{ config('midtrans.is_production') ? 'Production' : 'Sandbox' }}</p>';
            } else {
                resultDiv.innerHTML = '<p style="color: red;">✗ Midtrans Snap.js failed to load</p>';
                resultDiv.innerHTML += '<p>Please check your Midtrans configuration in the .env file</p>';
            }
            
            // Try to make a simple request to test the API
            fetch('/guest/payment', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    test: true
                })
            })
            .then(response => {
                if (response.status === 419) {
                    resultDiv.innerHTML += '<p style="color: orange;">⚠ CSRF token may have expired. Refresh the page and try again.</p>';
                } else {
                    resultDiv.innerHTML += '<p style="color: green;">✓ Server connection successful</p>';
                }
            })
            .catch(error => {
                resultDiv.innerHTML += '<p style="color: red;">✗ Server connection failed: ' + error.message + '</p>';
            });
        });
    </script>
</body>
</html>