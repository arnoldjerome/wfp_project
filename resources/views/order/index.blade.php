@extends('layouts.adminlte4')

@section('form-name')
<h3 class="mb-0">Order List</h3>
@endsection


@section('content')

<table class="table table-bordered">
<thead>
  <tr>
    <th>ID</th>
    <th>Customer</th>
    <th>Order ID</th>
    <th>Order Status</th>
    <th>Payment Method</th>
    <th>Payment Status</th>
    <th>Discount</th>
    <th>Discount Amount</th>
    <th>Total Price</th>
    <th>Final Price</th>
    <th>Order Date</th>
  </tr>
</thead>
<tbody>
  <tr class="align-middle">
    @foreach ($datas as $o)
    <td>{{ $o->id }}</td>
    <td>{{ $o->user }}</td>
    <td>{{ $o->order_number }}</td>
    <td>{{ $o->status }}</td>
    <td>{{ $o->payment }}</td>
    <td>{{ $o->payment_status }}</td>
    <td>{{ $o->discount }}</td>
    <td>{{ $o->discount_amount }}</td>
    <td>{{ $o->total_price }}</td>
    <td>{{ $o->final_price }}</td>
    <td>{{ $o->ordered_at }}</td>
  </tr>
  @endforeach
  </tr>
</tbody>
</table>
@endsection
