<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Statistics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        /* Styles for the page and modal */
        body {
            font-family: 'Arial', "sans-serif";
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .card-content {
            font-size: 16px;
            color: #555;
        }

        h1 {
            color: #333;
        }

        /* Styles for the modal */
        /* Modal styles */

        /* Modal Content/Box */



        /* Style for the form fields */
        /* label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        } */
    </style>
</head>

<body>
    <div class="container">
        <h1>Email Statistics</h1>
        <div class="card">
            <div class="card-title">Total Email Addresses</div>
            <div class="card-content">{{ $emailCount }}</div>
        </div>
        <div class="card">
            <div class="card-title">Total SMTP Servers</div>
            <div class="card-content">{{ $smtpCount }}</div>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#SMTPServer">
            Add SMTP Server
        </button>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#EmailAddress">
            Add verified GOOGLEDATA
        </button>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="SMTPServer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add SMTP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="smtpForm">
                        <div class="mb-3">
                            <label for="host" class="form-label">Host</label>
                            <input type="text" class="form-control" id="host" required>
                        </div>
                        <div class="mb-3">
                            <label for="port" class="form-label">Port</label>
                            <input type="text" class="form-control" id="port" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="from" class="form-label">from</label>
                            <input type="text" class="form-control" id="from" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="addSmtpBtn">Add</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="EmailAddress" tabindex="-1" aria-labelledby="EmailAddress" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EmailAddress">Import verified GOOGLEDATA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="emailAddressForm">
                        <div class="mb-3">
                            <label for="emailFile" class="form-label">Select File</label>
                            <input type="file" class="form-control" id="emailFile" accept=".csv,.txt" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="importEmailAddresses">Import</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('addSmtpBtn').addEventListener('click', function() {
            // Get form data
            const host = document.getElementById('host').value;
            const port = document.getElementById('port').value;
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const from = document.getElementById('from').value;

            // Create SMTP data object
            const data = {
                host: host,
                port: port,
                username: username,
                password: password,
                from: from
            };

            console.log(JSON.stringify(data));

            // Send POST request to add SMTP
            fetch('/add-smtp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Add CSRF token for Laravel
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    location.reload(); // Refresh page after adding SMTP
                })
                .catch(error => console.error('Error:', error));
        });

        document.getElementById('importEmailAddresses').addEventListener('click', function() {
            const fileInput = document.getElementById('emailFile');
            const file = fileInput.files[0];

            if (file) {
                const formData = new FormData();
                formData.append('file', file);

                fetch('/import-email-addresses', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        $('#EmailAddress').modal('hide');
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                alert('Please select a file.');
            }
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
