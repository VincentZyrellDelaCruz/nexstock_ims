<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise 3: Single-Action Controller</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h3 class="mb-0 text-white">Exercise 3: Single-Action Controller</h3>
                    <small class="text-white">__invoke() - Welcome, {{ $name }}!</small>
                </div>
                <div class="card-body">
                    <div class="alert alert-primary" role="alert">
                        <h4 class="alert-heading">Welcome, {{ $name }}!</h4>
                        <p class="mb-0">This is a single-action controller using the __invoke() method.</p>
                        <hr>
                        <p class="mb-0">
                            <small>
                                Try different names in the URL: <br>
                                <code>/welcome?name=Alice</code> or <code>/welcome?name=Bob</code>
                            </small>
                        </p>
                    </div>
                    <div class="mt-3">
                        <a href="/" class="btn btn-secondary">Back to Home</a>
                        <a href="/welcome?name=Student" class="btn btn-primary">Try with Different Name</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

