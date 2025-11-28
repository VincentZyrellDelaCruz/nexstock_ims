<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise 2: Resource Controller - Show</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h3 class="mb-0">Exercise 2: Resource Controller</h3>
                    <small>show({{ $id }}) - Showing product with ID: {{ $id }}</small>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning" role="alert">
                        <h4 class="alert-heading">Product Details</h4>
                        <p class="mb-0">Showing product with ID: {{ $id }}</p>
                    </div>
                    <div class="mt-3">
                        <a href="/products" class="btn btn-secondary">Back to Products</a>
                        <a href="/products/{{ $id }}/edit" class="btn btn-primary">Edit Product</a>
                        <a href="/" class="btn btn-secondary">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

