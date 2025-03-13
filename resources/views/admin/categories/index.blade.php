@extends('layouts.admin')
@section('content')

<div class="container mt-5">
    <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="openAddCategoryModal()">Create Category</button>
    <table class="table table-bordered table-striped table-responsive">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Slug</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description }}</td>
                <td>{{ $category->slug }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="openEditCategoryModal({{ json_encode($category->id) }})">Edit</button>
                    <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Category Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="categoryForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="categoryId" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    function openAddCategoryModal() {
        $("#exampleModalLabel").text("Add Category");
        $("#categoryId").val("");
        $("#name").val("");
        $("#description").val("");
        $("#slug").val("");
        $("#image").val("");
        $("#categoryForm").attr("action", "{{ route('admin.category.store') }}");
        $("#categoryForm").attr("method", "POST");
    }

    function openEditCategoryModal(categoryId) {
        $.ajax({
            url: "{{ url('admin/category') }}/" + categoryId + "/edit",
            method: "GET",
            success: function(response) {
                $("#exampleModalLabel").text("Edit Category");
                $("#categoryId").val(response.id);
                $("#name").val(response.name);
                $("#description").val(response.description);
                $("#slug").val(response.slug);
                $("#categoryForm").attr("action", "{{ url('admin/category') }}/" + categoryId + "/update");
                $("#categoryForm").attr("method", "PUT");
            },
            error: function() {
                alert("Failed to fetch category details.");
            }
        });
    }

    $("#categoryForm").on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let action = $("#categoryForm").attr("action");
        let method = $("#categoryForm").attr("method");

        $.ajax({
            url: action,
            method: method,
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert(response.success);
                location.reload();
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMessage = "";
                $.each(errors, function(key, value) {
                    errorMessage += value[0] + "\n";
                });
                alert(errorMessage);
            }
        });
    });
</script>
@endsection