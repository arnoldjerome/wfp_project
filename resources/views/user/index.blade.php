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
    <th>Action</th>
  </tr>
</thead>
<tbody>
  @foreach ($datas as $u)
  <tr class="align-middle">
    <td>{{ $u->id }}</td>
    <td>{{ $u->name }}</td>
    <td>{{ $u->email }}</td>
    <td>
      <button class="btn btn-warning btn-sm" onclick='openEditUser(@json($u))'>Edit</button>
      <button class="btn btn-danger btn-sm" onclick="deleteUser({{ $u->id }})">Delete</button>
    </td>
  </tr>
  @endforeach
</tbody>
</table>

<div class="d-flex justify-content-end mt-3">
    {{ $datas->links('pagination::bootstrap-5') }}
</div>

<br>
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createUserModal">
  <i class="fa fa-plus"></i> Add New User
</button>

<div class="modal fade" id="createUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="createUserForm" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Add New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Save</button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editUserForm" class="modal-content">
      @csrf
      @method('PUT')
      <input type="hidden" name="id" id="edit-id">
      <div class="modal-header">
        <h5 class="modal-title">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label">Name</label>
          <input type="text" name="name" id="edit-name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" name="email" id="edit-email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">New Password (optional)</label>
          <input type="password" name="password" class="form-control">
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
  document.getElementById('createUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch(`{{ route('user.store') }}`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      alert('User created!');
      location.reload();
    })
    .catch(err => {
      console.error(err);
      alert('Create failed!');
    });
  });

  function openEditUser(user) {
    document.getElementById('edit-id').value = user.id;
    document.getElementById('edit-name').value = user.name;
    document.getElementById('edit-email').value = user.email;
    new bootstrap.Modal(document.getElementById('editUserModal')).show();
  }

  document.getElementById('editUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('edit-id').value;
    const formData = new FormData(this);
    formData.append('_method', 'PUT');

    fetch(`/user/${id}`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      alert('User updated!');
      location.reload();
    })
    .catch(err => {
      console.error(err);
      alert('Update failed!');
    });
  });

  function deleteUser(id) {
    if (!confirm("Are you sure to delete this user?")) return;

    fetch(`/user/${id}`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ _method: 'DELETE' })
    })
    .then(res => res.json())
    .then(data => {
      alert('User deleted!');
      location.reload();
    })
    .catch(err => {
      console.error(err);
      alert('Delete failed!');
    });
  }
</script>
@endpush
