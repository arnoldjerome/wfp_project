@extends('layouts.adminlte4')

@section('form-name')
<h3 class="mb-0">Report A</h3>
@endsection


@section('content')

<table class="table table-bordered">
<thead>
  <tr>
    <th>ID</th>
    <th>A</th>
    <th>Date</th>
  </tr>
</thead>
<tbody>
  <tr class="align-middle">
    @foreach ($datas as $o)
    <td>{{ $o->id }}</td>
    <td>{{ $o->a }}</td>
    <td>{{ $o->date }}</td>
  </tr>
  @endforeach
  </tr>
</tbody>
</table>
@endsection
