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
        <button id="addSmtpBtn" type="button" class="btn btn-primary" data-bs-toggle="modal"
            data-bs-target="#exampleModal">Add SMTP Server</button>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add SMTP</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="host" class="form-label">host</label>
                            <input type="text" class="form-control" id="host" required>
                        </div>
                        <div class="mb-3">
                            <label for="port" class="form-label">port</label>
                            <input type="text" class="form-control" id="port" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">username</label>
                            <input type="text" class="form-control" id="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">password</label>
                            <input type="text" class="form-control" id="password" required>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal for adding SMTP server -->
    {{-- <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="smtpForm">
                <label for="host">Host:</label>
                <input type="text" id="host" name="host" required><br><br>
                <label for="port">Port:</label>
                <input type="text" id="port" name="port" required><br><br>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br><br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>
                <label for="from">From:</label>
                <input type="text" id="from" name="from" required><br><br>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div> --}}

    <!-- JavaScript to handle modal display -->
    {{-- <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var btn = document.getElementById("addSmtpBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on the button, open the modal
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
