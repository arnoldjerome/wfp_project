<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>Categories</h2>

<table>
<thead>
  <tr>
    <th>Name</th>
    <th>Total Food</th>

  </tr>
</thead>
<tbody>
    @foreach ($report as $r)
  <tr>
    <td>{{ $r->name }}</td>
    <td>{{ $r->TotalFood }}</td>
  </tr>
  @endforeach
</tbody>
</table>

</body>
</html>
