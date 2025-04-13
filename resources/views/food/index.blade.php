@extends('layouts.adminlte4')

@section('form-name')
<h3 class="mb-0">Food List</h3>
@endsection


@section('content')

<table class="table table-bordered">
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
  <tr class="align-middle">
    @foreach ($foods as $f)
    <td>{{ $f->id }}</td>
    <td>{{ $f->name }}</td>
    <td>{{ $f->category_id }}</td>
    <td>{{ $f->description }}</td>
    <td>{{ $f->nutrition_fact }}</td>
    <td>{{ $f->price }}</td>
    <td>{{ $f->category->name }}</td>
  </tr>
  @endforeach
  </tr>
</tbody>
</table>
@endsection
