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
                    <td>
                        <ul class="mb-0">
                            @foreach($o->items as $item)
                                <li>
                                    <strong>{{ $item->food->name ?? '-' }}</strong> × {{ $item->quantity }}
                                    @if ($item->note)
                                        <br><small><em>Note: {{ $item->note }}</em></small>
                                    @endif
                                    @if ($item->addOns->isNotEmpty())
                                        <ul class="ms-3">
                                            @foreach($item->addOns as $addon)
                                                <li>{{ $addon->addOn->name ?? '-' }} (+{{ number_format($addon->price, 0, ',', '.') }})</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $o->status }}</td>
                    <td>{{ $o->paymentMethod->name }}</td>
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

    <div class="d-flex justify-content-end mt-3">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>

    {{-- MODAL: Edit Order --}}
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
                        <div id="edit-food-names" class="form-control bg-light" readonly></div>
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

        function openEditOrder(order) {
            document.getElementById('edit-id').value = order.id;
            document.getElementById('edit-user-id').value = order.user_id;
            document.getElementById('edit-payment-method-id').value = order.payment_method_id;
            document.getElementById('edit-status').value = order.status;
            document.getElementById('edit-total-price').value = parseFloat(order.total_price).toFixed(2);
            document.getElementById('edit-final-price').value = parseFloat(order.final_price).toFixed(2);
            document.getElementById('edit-ordered-at').value = order.ordered_at?.slice(0, 16);

            let foodsHtml = '';
            if (order.items) {
                order.items.forEach(item => {
                    foodsHtml += `<div><strong>${item.food?.name ?? '-'}</strong> × ${item.quantity}</div>`;
                });
            } else {
                foodsHtml = '-';
            }
            document.getElementById('edit-food-names').innerHTML = foodsHtml;

            new bootstrap.Modal(document.getElementById('editOrderModal')).show();
        }

        document.getElementById('editOrderForm').addEventListener('submit', function (e) {
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
                .then(async res => {
                    const contentType = res.headers.get("content-type");
                    if (!res.ok) {
                        if (contentType && contentType.includes("application/json")) {
                            const data = await res.json();
                            throw new Error(data.message || 'Update failed');
                        } else {
                            const html = await res.text();
                            console.error("HTML error response:", html);
                            throw new Error("Something went wrong (HTML response)");
                        }
                    }

                    const data = await res.json();
                    showAlert(data.message || 'Order updated!');
                    location.reload();
                })
                .catch(err => {
                    console.error(err);
                    showAlert(err.message || 'Update failed!', 'error');
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
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) {
                        throw new Error(data.message || 'Delete failed');
                    }
                    showAlert(data.message || 'Order deleted!');
                    location.reload();
                })
                .catch(err => {
                    console.error(err);
                    showAlert(err.message || 'Delete failed!', 'error');
                });
        }
    </script>
@endpush