@extends('layouts.admin')
@section('content')
@section('title', 'Banners - Admin Panel')

<div class="container mt-5">
    <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#bannerModal" onclick="openAddbannerModal()">Create Banner</button>
    <table class="brandsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Link</th>
                <th>Status</th>
                <th>Position</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($banners as $banner)
            <tr>
                <td>{{ $banner->id }}</td>
                <td>{{ $banner->title }}</td>
                <td>{{ $banner->link }}</td>
                <td><input type="checkbox" class="toggle-status" data-id="{{ $banner->id }}" {{ $banner->status ? 'checked' : '' }}></td>
                <td>{{ $banner->position }}</td>
                <td>
                    @if($banner->image)
                    <img src="{{ asset('storage/' . $banner->image) }}" class="bannerImg">
                    @else
                    <span>No Image</span>
                    @endif
                </td>
                <td>{{ $banner->created_at }}</td>
                <td>{{ $banner->updated_at }}</td>
                <td>
                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#bannerModal" onclick="openEditBannerModal({{ json_encode($banner->id) }})">Edit</button>
                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="display:inline;">
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

<!-- banner Modal -->
<div class="modal fade" id="bannerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add banner</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="bannerForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="bannerId" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link</label>
                        <textarea class="form-control" id="link" name="link"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <img id="previewImage" src="" width="50" style="display: none;border-radius: 50%;border:2px solid black;">
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
    function openAddbannerModal() {
        $("#exampleModalLabel").text("Add Banner");
        $("#bannerId").val("");
        $("#title").val("");
        $("#link").val("");
        $("#image").val("");
        $("#previewImage").hide();
        $("#bannerForm").attr("action", "{{ route('admin.banners.store') }}").attr("method", "POST");
    }

    function openEditBannerModal(bannerId) {
        $.ajax({
            url: "{{ url('admin/banners') }}/" + bannerId + "/edit",
            method: "GET",
            success: function(response) {
                $("#exampleModalLabel").text("Edit Banner");
                $("#bannerId").val(response.id);
                $("#title").val(response.title);
                $("#link").val(response.link);
                if (response.image) {
                    $("#previewImage").attr("src", "{{ asset('storage/') }}/" + response.image).show();
                } else {
                    $("#previewImage").hide();
                }
                $("#bannerForm").attr("action", "{{ url('admin/banners') }}/" + bannerId + "/update").attr("method", "POST");
            },
            error: function() {
                alert("Failed to fetch banner details");
            }
        });
    }

    $("#bannerForm").on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let action = $("#bannerForm").attr("action");

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

    $(".toggle-status").change(function () {
            let bannerId = $(this).data('id');
            let status = $(this).is(':checked') ? 1 : 0;
            $.ajax({
                url: "/admin/banners/toggleStatus/",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: bannerId,
                    status: status
                },
                success: function (response) {
                    alert(response.message);
                },
                error: function () {
                    alert("Failed to update status.");
                }
            });
        });
</script>
@endsection