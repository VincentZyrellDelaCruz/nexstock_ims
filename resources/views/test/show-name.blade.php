<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise 1: Basic Controller - Name Parameter</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">Exercise 1: Basic Controller - Challenge</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info" role="alert">
                        <h4 class="alert-heading">Hello, {{ $name }}!</h4>
                        <p class="mb-0">This demonstrates the use of URL parameters in a basic controller method.</p>
                    </div>
                    <div class="mt-3">
                        <a href="/" class="btn btn-secondary">Back to Home</a>
                        <a href="/basic" class="btn btn-primary">Back to Basic</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

