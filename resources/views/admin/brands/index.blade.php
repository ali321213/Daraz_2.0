@extends('layouts.admin')
@section('content')
@section('title', 'Brands - Admin Panel')
<div class="container">
    <div class="row align-items-center my-5">
        <div class="col-lg-4 text-center">
            <input type="search" id="searchBrand" class="form-control form-control-lg" placeholder="Search Brands">
        </div>
        <div class="col-lg-8 text-center">
            <button type="button" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                Add Brands
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Logo</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($brands as $brand)
                    <tr>
                        <td>{{ $brand->name }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $brand->logo) }}" alt="Brand Logo" style="border-radius: 10%;height: 70px;width: 70px;">
                        </td>
                        <td>{{ $brand->slug }}</td>
                        <td>{{ $brand->description }}</td>
                        <td>
                        <a href="{{ route('admin.brands.edit', $brand->id) }}" data-id="{{ $brand->id }}" data-bs-toggle="modal" data-bs-target="#updateModal" class="btn btn-primary btn-sm editBtn">Edit</a>
                            <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($brands->isEmpty())
                    <tr>
                        <td colspan="5">No data found</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center mt-3">                
                {!! $brands->withQueryString()->links('pagination::bootstrap-5') !!}
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Brands</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addBrandForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Name">
                    </div>
                    <div class="mb-3">
                        <input type="file" name="logo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="slug" class="form-control" placeholder="Slug">
                    </div>
                    <div>
                        <input type="text" name="description" class="form-control" placeholder="Description">
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

<!-- Edit Product Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Products</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editBrandForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" name="id">
                        <input type="text" name="name" class="form-control" placeholder="Name">
                    </div>
                    <div class="mb-3">
                        <input type="file" name="logo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="slug" class="form-control" placeholder="Slug">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="description" class="form-control" placeholder="Description">
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // Show Records
        // loadBrands();
        // function loadBrands() {
        //     $.ajax({
        //         url: "/admin/brands/show",
        //         method: "GET",
        //         dataType: "json",
        //         success: function(response) {
        //             let tableRows = "";
        //             $.each(response, function(index, brand) {
        //                 tableRows += `
        //                 <tr>
        //                     <td>${brand.name}</td>
        //                     <td><img class="productImg" src="${brand.logo}" width="50"></td>
        //                     <td>${brand.slug}</td>
        //                     <td>${brand.description}</td>
        //                     <td class="text-center">
        //                         <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${brand.id}" data-bs-toggle="modal" data-bs-target="#updateModal">Edit</button>
        //                         <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${brand.id}">Delete</button>
        //                     </td>
        //                 </tr>
        //             `;
        //             });
        //             $("#brandTableBody").html(tableRows);
        //         },
        //         error: function() {
        //             alert("Failed to load brands. Please try again.");
        //         }
        //     });
        // }

        // Add Records
        $("#addBrandForm").on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "/admin/brands/create",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert(response.success);
                    // loadBrands();
                    $("#addBrandForm")[0].reset();
                    $("#addBrandModal").modal('hide');
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

        // Update Record
        $("#editBrandForm").on("submit", function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            let id = $("input[name='id']").val();
            $.ajax({
                url: `/admin/brands/update/${id}`,
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function(response) {
                    alert(response.success);
                    $("#updateModal").modal("hide");
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

        // Prefill Values
        $(document).on("click", ".editBtn", function() {
            let brandId = $(this).data("id");
            $.ajax({
                url: `/admin/brands/edit/${brandId}`,
                method: "GET",
                success: function(response) {
                    let form = $("#editBrandForm");
                    form.find("input[name='id']").val(response.id);
                    form.find("input[name='name']").val(response.name);
                    form.find("input[name='slug']").val(response.slug);
                    form.find("input[name='description']").val(response.description);
                    form.find("input[name='logo']").val(response.logo);
                    $("#editPreviewImg").attr("src", response.logo);
                },
                error: function() {
                    alert("Failed to fetch brand details.");
                }
            });
        });

        // Delete Record
        $(document).on("click", ".deleteBtn", function() {
            let brandId = $(this).data("id");
            if (confirm("Are you sure you want to delete this brand?")) {
                $.ajax({
                    url: "/admin/brands/destroy/" + brandId,
                    method: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.success);
                        // loadBrands();
                    },
                    error: function() {
                        alert("Failed to delete brand.");
                    }
                });
            }
        });

        // Search Records
        $("#searchBrand").on("keyup", function() {
            let query = $(this).val();
            $.ajax({
                url: "/admin/brands/search/",
                method: "GET",
                data: {
                    query: query
                },
                success: function(response) {
                    let tableRows = "";
                    $.each(response, function(index, brand) {
                        tableRows += `
                            <tr>
                                <td>${brand.name}</td>
                                <td><img src="${brand.logo}" width="50"></td>
                                <td>${brand.slug}</td>
                                <td>${brand.description}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${brand.id}" data-bs-toggle="modal" data-bs-target="#updateModal">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${brand.id}">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                    $("#brandTableBody").html(tableRows);
                },
                error: function() {
                    alert("Search failed. Try again.");
                }
            });
        });
    });
</script>
@endsection