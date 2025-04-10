<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container text-center mt-5">
        <img src="{{ asset('Loobang.png') }}" alt="Food Ordering Logo" class="img-fluid mb-3" style="max-width: 200px;">
        <h1>Food Ordering Kiosk</h1>
        <p>Aplikasi pemesanan makanan yang cepat dan mudah</p>
        <a href="{{ url('/before_order') }}" class="btn btn-primary">Start Order</a>
    </div>
</body>
</html>