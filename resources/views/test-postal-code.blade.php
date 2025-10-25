<!DOCTYPE html>
<html>

<head>
    <title>Postal Code Validation Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Postal Code Validation Test</h1>

        <div class="row">
            <div class="col-md-6">
                <h3>District Only Validation</h3>
                <div class="mb-3">
                    <label for="district" class="form-label">District Name</label>
                    <input type="text" class="form-control" id="district" value="Jatiuwung">
                </div>

                <button id="validateDistrictBtn" class="btn btn-primary">Validate District Only</button>
            </div>

            <div class="col-md-6">
                <h3>District + Village Validation</h3>
                <div class="mb-3">
                    <label for="district2" class="form-label">District Name</label>
                    <input type="text" class="form-control" id="district2" value="Jatiuwung">
                </div>

                <div class="mb-3">
                    <label for="village" class="form-label">Village Name</label>
                    <input type="text" class="form-control" id="village" value="Alam Jaya">
                </div>

                <button id="validateDistrictVillageBtn" class="btn btn-primary">Validate District + Village</button>
            </div>
        </div>

        <div id="result" class="mt-3"></div>
    </div>

    <script>
        document.getElementById('validateDistrictBtn').addEventListener('click', function() {
            const district = document.getElementById('district').value;

            fetch('/regions/validate-postal-code', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        district: district
                    })
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('result').innerHTML = '<h4>District Only Result:</h4><pre>' + JSON.stringify(data, null, 2) + '</pre>';
                })
                .catch(err => {
                    document.getElementById('result').innerHTML = '<div class="alert alert-danger">Error: ' + err.message + '</div>';
                });
        });

        document.getElementById('validateDistrictVillageBtn').addEventListener('click', function() {
            const district = document.getElementById('district2').value;
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
                    document.getElementById('result').innerHTML += '<h4>District + Village Result:</h4><pre>' + JSON.stringify(data, null, 2) + '</pre>';
                })
                .catch(err => {
                    document.getElementById('result').innerHTML += '<div class="alert alert-danger">Error: ' + err.message + '</div>';
                });
        });
    </script>
</body>

</html>