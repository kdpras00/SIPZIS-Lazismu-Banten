<!DOCTYPE html>
<html>

<head>
    <title>Specific Postal Code Validation Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Specific Postal Code Validation Test</h1>

        <div class="mb-3">
            <label for="district" class="form-label">District Name</label>
            <input type="text" class="form-control" id="district" value="Jatiuwung">
        </div>

        <div class="mb-3">
            <label for="village" class="form-label">Village Name</label>
            <input type="text" class="form-control" id="village" value="Alam Jaya">
        </div>

        <button id="validateBtn" class="btn btn-primary">Validate Postal Code</button>

        <div id="result" class="mt-3"></div>
    </div>

    <script>
        document.getElementById('validateBtn').addEventListener('click', function() {
            const district = document.getElementById('district').value;
            const village = document.getElementById('village').value;

            fetch('/regions/validate-postal-code', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        district: district,
                        village: village
                    })
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('result').innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
                })
                .catch(err => {
                    document.getElementById('result').innerHTML = '<div class="alert alert-danger">Error: ' + err.message + '</div>';
                });
        });
    </script>
</body>

</html>