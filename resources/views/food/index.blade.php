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
                <th>Description</th>
                <th>Nutrition Facts</th>
                <th>Price</th>
                <th>Category</th>
                <th>Add Ons</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr class="align-middle">
                @foreach ($foods as $f)
                        <td>{{ $f->id }}</td>
                        <td>{{ $f->name }}</td>
                        <td>{{ $f->description }}</td>
                        <td>{{ $f->nutrition_fact }}</td>
                        <td>{{ $f->price }}</td>
                        <td>{{ $f->category->name }}</td>
                        <td>
                            @if ($f->addOns->count())
                                @foreach ($f->addOns as $addon)
                                    <div>{{ $addon->name }} - {{ number_format($addon->price) }}</div>
                                @endforeach
                            @else
                                <span class="text-muted">No add-ons</span>
                            @endif
                        </td>
                        <td>
                            <img src="{{ $f->img_url }}" alt="{{ $f->name }}" width="100">
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <button class="btn btn-warning btn-sm" onclick='openEditModal(@json($f))'>Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="deleteFood({{ $f->id }})">Delete</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tr>
        </tbody>
    </table>
    <div class="d-flex justify-content-end mt-3">
        {{ $foods->links('pagination::bootstrap-5') }}
    </div>

    <br>
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createFoodModal">
        <i class="fa fa-plus"></i> Add New Food
    </button>


    <div class="modal fade" id="createFoodModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="createFoodForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Food</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label for="create-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="create-name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="create-description" class="form-label">Description</label>
                            <textarea class="form-control" id="create-description" name="description" rows="2"
                                required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="create-nutrition_fact" class="form-label">Nutrition Fact</label>
                            <textarea class="form-control" id="create-nutrition_fact" name="nutrition_fact"
                                rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="create-price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="create-price" name="price" required>
                        </div>

                        <div class="mb-3">
                            <label for="create-category_id" class="form-label">Category</label>
                            <select class="form-control" id="create-category_id" name="category_id" required>
                                <option value="" disabled selected>Select a category</option>
                                @foreach ($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <hr>
                        <h6>Add Ons</h6>
                        <div id="create-addons-wrapper">
                            <div class="d-flex gap-2 mb-2">
                                <input type="text" name="addons[0][name]" class="form-control" placeholder="Add-on name">
                                <input type="number" name="addons[0][price]" class="form-control" placeholder="Price">
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="addAddonField('create')">+ Add
                            More</button>


                        <div class="mb-3">
                            <label for="create-img_url" class="form-label">Image URL</label>
                            <input type="text" class="form-control" id="create-img_url" name="img_url" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="editFoodModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editFoodForm" method="POST" enctype="multipart/form-data" action=""
                    onsubmit="return updateFood(event)">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit-id">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Food</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit-name" name="name">
                        </div>

                        <div class="mb-3">
                            <label for="edit-description" class="form-label">Description</label>
                            <textarea class="form-control" id="edit-description" name="description"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="edit-nutrition_fact" class="form-label">Nutrition Fact</label>
                            <textarea class="form-control" id="edit-nutrition_fact" name="nutrition_fact"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="edit-price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="edit-price" name="price">
                        </div>

                        <div class="mb-3">
                            <label for="edit-category_id" class="form-label">Category</label>
                            <select class="form-control" id="edit-category_id" name="category_id">
                                @foreach ($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <hr>
                        <h6>Add Ons</h6>
                        <div id="edit-addons-wrapper">
                        </div>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="addAddonField('edit')">+ Add
                            More</button>


                        <div class="mb-3">
                            <label for="edit-image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="edit-image" name="image">
                        </div>
                        <div class="mt-2">
                            <label for="edit-image2" class="form-label">Current image => </label>
                            <img id="edit-image-preview" src="" alt="Current image" style="width: 100px;">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    </div>


@endsection




@push('scripts')
    <script>
        function updateFood(e) {
            e.preventDefault();

            const id = document.getElementById('edit-id').value;
            const formData = new FormData(document.getElementById('editFoodForm'));
            formData.append('_method', 'PUT');
            formData.append('image', document.getElementById('edit-image').files[0]);

            fetch(`/food/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
                .then(response => {
                    if (!response.ok) throw new Error("Update failed");

                    return response.text(); // <- ganti dari `.json()`
                })
                .then(data => {
                    console.log('Server response:', data);
                    alert('Food updated!');
                    location.reload();
                })
                .catch(err => {
                    console.error(err);
                    alert('Update failed!');
                });


            return false;
        }
    </script>
    <script>
        document.getElementById('createFoodForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(`{{ route('food.store') }}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
                .then(response => {
                    if (!response.ok) throw new Error("Create failed");
                    return response.json();
                })
                .then(data => {
                    alert('Food created!');
                    location.reload();
                })
                .catch(err => {
                    console.error(err);
                    alert('Create failed!');
                });
        });
    </script>
    <script>
        function deleteFood(id) {
            if (!confirm("Are you sure you want to delete this food?")) return;

            fetch(`/food/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    _method: 'DELETE'
                })
            })
                .then(response => {
                    if (!response.ok) throw new Error('Delete failed');
                    return response.json();
                })
                .then(data => {
                    alert('Food deleted!');
                    location.reload();
                })
                .catch(err => {
                    console.error(err);
                    alert('Delete failed!');
                });
        }
    </script>


    <script>
        function openEditModal(food) {
            console.log("Edit button clicked", food);

            const modalElement = document.getElementById('editFoodModal');
            if (!modalElement) {
                console.error("Modal element not found!");
                return;
            }
            const addonWrapper = document.getElementById('edit-addons-wrapper');
            addonWrapper.innerHTML = '';
            editAddonIndex = 0;

            if (food.add_ons && food.add_ons.length) {
                food.add_ons.forEach((addon) => {
                    const div = document.createElement('div');
                    div.classList.add('d-flex', 'gap-2', 'mb-2');
                    div.innerHTML = `
                        <input type="text" name="addons[${editAddonIndex}][name]" value="${addon.name}" class="form-control" placeholder="Add-on name">
                        <input type="number" name="addons[${editAddonIndex}][price]" value="${addon.price}" class="form-control" placeholder="Price">
                        <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">X</button>
                    `;
                    addonWrapper.appendChild(div);
                    editAddonIndex++;
                });
            }

            // Assign value ke form
            document.getElementById('edit-id').value = food.id;
            document.getElementById('edit-name').value = food.name;
            document.getElementById('edit-description').value = food.description;
            document.getElementById('edit-nutrition_fact').value = food.nutrition_fact;
            document.getElementById('edit-price').value = food.price;
            document.getElementById('edit-category_id').value = food.category_id;
            document.getElementById('edit-image-preview').src = food.img_url;

            // Tampilkan modal
            const modal = new bootstrap.Modal(modalElement);
            modal.show();
        }

    </script>
    <script>
        let createAddonIndex = 1;
        let editAddonIndex = 0;

        function addAddonField(mode) {
            let wrapper = document.getElementById(`${mode}-addons-wrapper`);
            let index = mode === 'create' ? createAddonIndex++ : editAddonIndex++;

            let div = document.createElement('div');
            div.classList.add('d-flex', 'gap-2', 'mb-2');
            div.innerHTML = `
                                    <input type="text" name="addons[${index}][name]" class="form-control" placeholder="Add-on name">
                                    <input type="number" name="addons[${index}][price]" class="form-control" placeholder="Price">
                                    <button type="button" class="btn btn-danger btn-sm" onclick="this.parentElement.remove()">X</button>
                                `;
            wrapper.appendChild(div);
        }
    </script>
@endpush