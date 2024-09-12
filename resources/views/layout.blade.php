<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="header">
        <p>Coding Challenge Software Engineer application</p>
        <div>
            <button>
                <a href="{{ route('products.index') }}">
                    Main List
                </a>
            </button>
            <button>
                <a href="{{ route('products.create') }}">
                    Add Product
                </a>
            </button>
        </div>
    </div>
    <div class="content">
        @yield('content')
    </div>
</body>
</html>
