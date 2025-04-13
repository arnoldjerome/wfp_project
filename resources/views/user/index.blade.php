@extends('layouts.adminlte4')

@section('form-name')
<h3 class="mb-0">Customer List</h3>
@endsection


@section('content')

<table class="table table-bordered">
<thead>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
  </tr>
</thead>
<tbody>
  <tr class="align-middle">
    @foreach ($datas as $u)
    <td>{{ $u->id }}</td>
    <td>{{ $u->name }}</td>
    <td>{{ $u->email }}</td>
  </tr>
  @endforeach
  </tr>
</tbody>
</table>
@endsection
