@extends('layouts.adminlte4')
@section('content')

<h2>Food</h2>

<table>
<thead>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Category</th>
    <th>Description</th>
    <th>Nutrition Facts</th>
    <th>Price</th>
    <th>Category</th>

  </tr>
</thead>
<tbody>
    @foreach ($foods as $f)
  <tr>
    <td>{{ $f->id }}</td>
    <td>{{ $f->name }}</td>
    <td>{{ $f->category_id }}</td>
    <td>{{ $f->description }}</td>
    <td>{{ $f->nutrition_fact }}</td>
    <td>{{ $f->price }}</td>
    <td>{{ $f->category->name }}</td>
  </tr>
  @endforeach
</tbody>
</table>
@endsection
