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
    <th>Action</th>
  </tr>
</thead>
<tbody>
  @foreach ($categories as $c)
  <tr class="align-middle">
    <td>{{ $c->id }}</td>
    <td>{{ $c->name }}</td>
    <td>{{ $c->foods_count }}</td>
    <td>
      <div class="d-flex gap-1">
        <button class="btn btn-warning btn-sm" onclick='openEditCategory(@json($c))'>Edit</button>
        <button class="btn btn-danger btn-sm" onclick="deleteCategory({{ $c->id }})">Delete</button>
      </div>
    </td>
  </tr>
  @endforeach
</tbody>
</table>
<br>
<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
    <i class="fa fa-plus"></i> Add New Category
  </button>

<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="createCategoryForm" class="modal-content">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Add New Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="create-name" class="form-label">Category Name</label>
          <input type="text" name="name" class="form-control" id="create-name" required>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" type="submit">Save</button>
      </div>
    </form>
  </div>
</div>

<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editCategoryForm" class="modal-content">
      @csrf
      @method('PUT')
      <input type="hidden" name="id" id="edit-id">
      <div class="modal-header">
        <h5 class="modal-title">Edit Category</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="edit-name" class="form-label">Category Name</label>
          <input type="text" name="name" class="form-control" id="edit-name" required>
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
  document.getElementById('createCategoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    fetch(`{{ route('category.store') }}`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      alert('Category created!');
      location.reload();
    })
    .catch(err => {
      console.error(err);
      alert('Create failed!');
    });
  });

  function openEditCategory(category) {
    document.getElementById('edit-id').value = category.id;
    document.getElementById('edit-name').value = category.name;

    new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
  }

  document.getElementById('editCategoryForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('edit-id').value;
    const formData = new FormData(this);
    formData.append('_method', 'PUT');

    fetch(`/category/${id}`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      alert('Category updated!');
      location.reload();
    })
    .catch(err => {
      console.error(err);
      alert('Update failed!');
    });
  });

  function deleteCategory(id) {
    if (!confirm("Are you sure to delete this category?")) return;

    fetch(`/category/${id}`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ _method: 'DELETE' })
    })
    .then(res => res.json())
    .then(data => {
      alert('Category deleted!');
      location.reload();
    })
    .catch(err => {
      console.error(err);
      alert('Delete failed!');
    });
  }
</script>
@endpush
