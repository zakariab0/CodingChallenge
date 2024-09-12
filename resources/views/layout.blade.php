<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Coding Challenge')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header {
            padding: 20px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: space-evenly;
        }
        .header p {
            margin: 0;
            font-size: 1.25rem;
        }
        .header .btn {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <p>Coding Challenge Software Engineer Application</p>
        <div>
            <a class="btn btn-primary" href="{{ route('products.index') }}">
                Main List
            </a>
            <a class="btn btn-success" href="{{ route('products.create') }}">
                Add Product
            </a>
        </div>
    </div>
    <div class="content container mt-4">
        @yield('content')
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
