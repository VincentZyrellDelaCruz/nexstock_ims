<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Controllers Laboratory Exercises</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white">
                    <h2 class="mb-0">Laravel Controllers Laboratory Exercises</h2>
                    <small>Web Development with Laravel - Topic: Controllers</small>
                </div>
                <div class="card-body">
                    <div class="alert alert-info" role="alert">
                        <h5 class="alert-heading">Welcome to the Controllers Lab!</h5>
                        <p class="mb-0">This exercise demonstrates Basic, Resource, and Single-Action Controllers in Laravel with Bootstrap styling.</p>
                    </div>

                    <div class="row">
                        <!-- Exercise 1 -->
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Exercise 1</h5>
                                    <small>Basic Controllers</small>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Learn how to create and use standard Laravel controllers.</p>
                                    <div class="d-grid gap-2">
                                        <a href="/basic" class="btn btn-primary">View Exercise 1</a>
                                        <a href="/basic/John" class="btn btn-outline-primary btn-sm">With Parameter</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Exercise 2 -->
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">Exercise 2</h5>
                                    <small>Resource Controllers</small>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Learn RESTful resource controllers for CRUD operations.</p>
                                    <div class="d-grid gap-2">
                                        <a href="/products" class="btn btn-success">View Exercise 2</a>
                                        <a href="/products/1" class="btn btn-outline-success btn-sm">View Product</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Exercise 3 -->
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-info">
                                <div class="card-header bg-gradient text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <h5 class="mb-0">Exercise 3</h5>
                                    <small>Single-Action Controller</small>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Learn controllers that handle a single action.</p>
                                    <div class="d-grid gap-2">
                                        <a href="/welcome" class="btn btn-primary">View Exercise 3</a>
                                        <a href="/welcome?name=Student" class="btn btn-outline-primary btn-sm">With Name</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="mt-4">
                        <h5>Quick Links</h5>
                        <div class="list-group">
                            <a href="/basic" class="list-group-item list-group-item-action">
                                <strong>GET /basic</strong> - Basic Controller Message
                            </a>
                            <a href="/basic/Alice" class="list-group-item list-group-item-action">
                                <strong>GET /basic/{name}</strong> - Basic Controller with Parameter
                            </a>
                            <a href="/products" class="list-group-item list-group-item-action">
                                <strong>GET /products</strong> - List Products (index)
                            </a>
                            <a href="/products/create" class="list-group-item list-group-item-action">
                                <strong>GET /products/create</strong> - Create Form (create)
                            </a>
                            <a href="/products/1" class="list-group-item list-group-item-action">
                                <strong>GET /products/{id}</strong> - Show Product (show)
                            </a>
                            <a href="/products/1/edit" class="list-group-item list-group-item-action">
                                <strong>GET /products/{id}/edit</strong> - Edit Form (edit)
                            </a>
                            <a href="/welcome" class="list-group-item list-group-item-action">
                                <strong>GET /welcome</strong> - Single-Action Controller
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

