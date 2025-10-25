<!DOCTYPE html>
<html>

<head>
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
</head>

<body>
    <h1>Test JavaScript Request</h1>
    <button id="testBtn">Test Send OTP</button>
    <div id="result"></div>

    <script>
        document.getElementById('testBtn').addEventListener('click', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log('CSRF Token:', csrfToken);

            fetch('/send-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        phone: '628123456789'
                    })
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', [...response.headers.entries()]);

                    // Check if the response is OK (status code 200-299)
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.status);
                    }
                    // Check if the response is JSON
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        throw new Error('Response is not JSON');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Success:', data);
                    document.getElementById('result').innerHTML = '<p>Success: ' + JSON.stringify(data) + '</p>';
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('result').innerHTML = '<p>Error: ' + error.message + '</p>';
                });
        });
    </script>
</body>

</html>