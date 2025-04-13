@extends('layouts.adminlte4')

@section('form-name')
<h3 class="mb-0">Category List</h3>
@endsection


@section('content')

<table class="table table-bordered">
<thead>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Total Foods</th>
  </tr>
</thead>
<tbody>
  <tr class="align-middle">
    @foreach ($category as $c)
    <td>{{ $c->id }}</td>
    <td>{{ $c->name }}</td>
    <td>{{ $c->TotalFood }}</td>
  </tr>
  @endforeach
  </tr>
</tbody>
</table>
@endsection
