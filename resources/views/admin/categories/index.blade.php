@extends('layouts.admin')
@section('content')
@section('title', 'Category - Admin Panel')

<div class="container mt-5">
    <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#categoryModal" onclick="openAddCategoryModal()">Create Category</button>
    <table class="text-center table text-capitalize" style="border: 2px solid black;">
        <thead style="border: 2px solid black;">
            <tr style="border: 2px solid black;">
                <th style="border: 2px solid black;">ID</th>
                <th style="border: 2px solid black;">Name</th>
                <th style="border: 2px solid black;">Description</th>
                <th style="border: 2px solid black;">Slug</th>
                <th style="border: 2px solid black;">Image</th>
                <th style="border: 2px solid black;">Actions</th>
            </tr>
        </thead>
        <tbody style="border: 2px solid black;">
            @foreach ($categories as $category)
            <tr style="border: 2px solid black;">
                <td style="border: 2px solid black;">{{ $category->id }}</td>
                <td style="border: 2px solid black;">{{ $category->name }}</td>
                <td style="border: 2px solid black;">{{ $category->description }}</td>
                <td style="border: 2px solid black;">{{ $category->slug }}</td>
                <!-- <td><img src="{{ asset('/storage/' . $category->image) }}" width="100"></td> -->
                <td>
                    @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" width="100">
                    @else
                    <span>No Image</span>
                    @endif
                </td>
                <td style="border: 2px solid black;">
                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#categoryModal"
                        onclick="openEditCategoryModal({{ json_encode($category->id) }})">Edit</button>
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
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <img id="previewImage" src="" width="50" style="display: none;">
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
        $("#previewImage").hide();
        $("#categoryForm").attr("action", "{{ route('admin.category.store') }}").attr("method", "POST");
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
                if (response.image) {
                    $("#previewImage").attr("src", "{{ asset('storage/') }}/" + response.image).show();
                } else {
                    $("#previewImage").hide();
                }
                $("#categoryForm").attr("action", "{{ url('admin/category') }}/" + categoryId + "/update").attr("method", "POST");
            },
            error: function() {
                alert("Failed to fetch category details");
            }
        });
    }

    $("#categoryForm").on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let action = $("#categoryForm").attr("action");

        $.ajax({
            url: action,
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    location.reload();
                } else {
                    alert("Something went wrong!");
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON?.errors || {};
                let errorMessage = "An error occurred:\n";
                $.each(errors, function(key, value) {
                    errorMessage += value[0] + "\n";
                });
                alert(errorMessage);
            }
        });
    });
</script>
@endsection