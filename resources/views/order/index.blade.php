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
      <th>Order No</th>
      <th>Makanan</th>
      <th>Status</th>
      <th>Payment</th>
      <th>Discount</th>
      <th>Discount Amount</th>
      <th>Total Price</th>
      <th>Final Price</th>
      <th>Order Date</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($orders as $o)
    <tr class="align-middle">
      <td>{{ $o->id }}</td>
      <td>{{ $o->user->name }}</td>
      <td>{{ $o->order_number }}</td>
      <td>{{ $o->food->name ?? '-' }}</td>
      <td>{{ $o->status }}</td>
      <td>{{ $o->paymentMethod->name }}</td>
      <td>{{ $o->discount->code ?? '-' }}</td>
      <td>{{ $o->discount_amount ?? 0 }}</td>
      <td>{{ $o->total_price }}</td>
      <td>{{ $o->final_price }}</td>
      <td>{{ $o->ordered_at }}</td>
      <td>
        <div class="d-flex gap-1">
          <button class="btn btn-warning btn-sm" onclick='openEditOrder(@json($o))'>Edit</button>
          <button class="btn btn-danger btn-sm" onclick="deleteOrder({{ $o->id }})">Delete</button>
        </div>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>

<br>
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createOrderModal">
  <i class="fa fa-plus"></i> Add New Order
</button>

<div class="modal fade" id="createOrderModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="createOrderForm" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Add New Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label>User</label>
          <select name="user_id" class="form-control" required>
            @foreach ($users as $u)
              <option value="{{ $u->id }}">{{ $u->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
            <label>Food</label>
            <select name="food_id" class="form-control" required>
              @foreach ($foods as $food)
                <option value="{{ $food->id }}">{{ $food->name }}</option>
              @endforeach
            </select>
        </div>
        <div class="mb-3">
          <label>Payment Method</label>
          <select name="payment_method_id" class="form-control" required>
            @foreach ($payments as $p)
              <option value="{{ $p->id }}">{{ $p->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control" required>
              @foreach ($statuses as $s)
                <option value="{{ $s['value'] }}">{{ $s['label'] }}</option>
              @endforeach
            </select>
          </div>

        <div class="mb-3">
          <label>Total Price</label>
          <input type="number" name="total_price" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Discount</label>
          <select name="discount_id" class="form-control">
            <option value="">None</option>
            @foreach ($discounts as $d)
              <option value="{{ $d->id }}">{{ $d->code }}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label>Discount Amount</label>
          <input type="number" name="discount_amount" class="form-control">
        </div>

        <div class="mb-3">
          <label>Final Price</label>
          <input type="number" name="final_price" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Ordered At</label>
          <input type="datetime-local" name="ordered_at" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Save</button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="editOrderModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="editOrderForm" class="modal-content">
      @csrf
      <input type="hidden" id="edit-id">
      <div class="modal-header">
        <h5 class="modal-title">Edit Order</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label>User</label>
          <select name="user_id" id="edit-user-id" class="form-control" required>
            @foreach ($users as $u)
              <option value="{{ $u->id }}">{{ $u->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
            <label>Food</label>
            <select name="food_id" id="edit-food-id" class="form-control" required>
              @foreach ($foods as $food)
                <option value="{{ $food->id }}">{{ $food->name }}</option>
              @endforeach
            </select>
        </div>

        <div class="mb-3">
          <label>Payment Method</label>
          <select name="payment_method_id" id="edit-payment-method-id" class="form-control" required>
            @foreach ($payments as $p)
              <option value="{{ $p->id }}">{{ $p->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" id="edit-status" class="form-control" required>
              @foreach ($statuses as $s)
                <option value="{{ $s['value'] }}">{{ $s['label'] }}</option>
              @endforeach
            </select>
          </div>

        <div class="mb-3">
          <label>Total Price</label>
          <input type="number" name="total_price" id="edit-total-price" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Discount</label>
          <select name="discount_id" id="edit-discount-id" class="form-control">
            <option value="">None</option>
            @foreach ($discounts as $d)
              <option value="{{ $d->id }}">{{ $d->code }}</option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label>Discount Amount</label>
          <input type="number" name="discount_amount" id="edit-discount-amount" class="form-control">
        </div>

        <div class="mb-3">
          <label>Final Price</label>
          <input type="number" name="final_price" id="edit-final-price" class="form-control" required>
        </div>

        <div class="mb-3">
          <label>Ordered At</label>
          <input type="datetime-local" name="ordered_at" id="edit-ordered-at" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" type="submit">Update</button>
      </div>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script>
  function showAlert(message, type = 'success') {
    alert(message);
  }

  document.getElementById('createOrderForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch(`{{ route('order.store') }}`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      showAlert(data.message || 'Order created!');
      location.reload();
    })
    .catch(async (err) => {
      let msg = 'Create failed!';
      showAlert(msg, 'error');
    });
  });

  function openEditOrder(order) {
    document.getElementById('edit-id').value = order.id;
    document.getElementById('edit-user-id').value = order.user_id;
    document.getElementById('edit-food-id').value = order.food_id;
    document.getElementById('edit-payment-method-id').value = order.payment_method_id;
    document.getElementById('edit-status').value = order.status;
    document.getElementById('edit-total-price').value = order.total_price;
    document.getElementById('edit-discount-id').value = order.discount_id ?? '';
    document.getElementById('edit-discount-amount').value = order.discount_amount ?? '';
    document.getElementById('edit-final-price').value = order.final_price;
    document.getElementById('edit-ordered-at').value = order.ordered_at?.slice(0, 16);
    document.getElementById('edit-food-id').value = order.food_id;


    new bootstrap.Modal(document.getElementById('editOrderModal')).show();
  }

  document.getElementById('editOrderForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('edit-id').value;
    const formData = new FormData(this);
    formData.append('_method', 'PUT');

    fetch(`/order/${id}`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      showAlert(data.message || 'Order updated!');
      location.reload();
    })
    .catch(async (err) => {
      let msg = 'Update failed!';
      showAlert(msg, 'error');
    });
  });

  function deleteOrder(id) {
    if (!confirm("Are you sure to delete this order?")) return;

    fetch(`/order/${id}`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ _method: 'DELETE' })
    })
    .then(res => res.json())
    .then(data => {
      showAlert(data.message || 'Order deleted!');
      location.reload();
    })
    .catch(err => {
      console.error(err);
      showAlert('Delete failed!', 'error');
    });
  }
</script>
@endpush
