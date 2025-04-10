<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Metode Pemesanan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container text-center mt-5">
        <h2>Pilih Metode Pemesanan</h2>
        <a href="{{ url('/menu/dinein') }}" class="btn btn-success">Dine-In</a>
        <a href="{{ url('/menu/takeaway') }}" class="btn btn-warning">Take Away</a>
    </div>
</body>
</html>