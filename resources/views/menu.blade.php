<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Daftar Menu - {{ ucfirst($type) }}</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nasi Goreng</td>
                    <td>Rp 25.000</td>
                    <td><button class="btn btn-primary">Pesan</button></td>
                </tr>
                <tr>
                    <td>Mie Ayam</td>
                    <td>Rp 20.000</td>
                    <td><button class="btn btn-primary">Pesan</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>