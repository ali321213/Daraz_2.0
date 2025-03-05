@extends('layouts.app')
@section('content')
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
            <table class="table table-striped table-bordered text-capitalize text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Logo</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="brandTableBody"></tbody>
            </table>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        loadBrands();

        // Show Records
        function loadBrands() {
            $.ajax({
                url: "/brands/show",
                method: "GET",
                dataType: "json",
                success: function(response) {
                    let tableRows = "";
                    $.each(response, function(index, brand) {
                        tableRows += `
                        <tr>
                            <th>${index + 1}</th>
                            <td>${brand.name}</td>
                            <td><img class="productImg" src="${brand.img}"></td>
                            <td>${brand.price}</td>
                            <td>${brand.brand}</td>
                            <td>${brand.unit}</td>
                            <td>${brand.category}</td>
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
                    alert("Failed to load brands. Please try again.");
                }
            });
        }

            // Add Records
            $("#addBrandForm").on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: "/brands/create",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.success);
                        loadBrands();
                        $("#addBrandForm")[0].reset();
                        $("#exampleModal").modal('hide');
                        loadBrands();
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
                let productId = $("input[name='id']").val();
                $.ajax({
                    url: `/brands/update/${productId}`,
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
                        loadBrands(); // Refresh Product List
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
                let productId = $(this).data("id");
                $.ajax({
                    url: `/brands/edit_product/${productId}`,
                    method: "GET",
                    success: function(response) {
                        let form = $("#editBrandForm");
                        form.find("input[name='id']").val(response.id);
                        form.find("input[name='name']").val(response.name);
                        form.find("input[name='slug']").val(response.price);
                        form.find("input[name='description']").val(response.brand);
                        form.find("input[name='logo']").val(response.unit);
                        $("#editPreviewImg").attr("src", response.img);
                    },
                    error: function() {
                        alert("Failed to fetch brand details.");
                    }
                });
            });

            // Delete Record
            $(document).on("click", ".deleteBtn", function() {
                let productId = $(this).data("id");
                if (confirm("Are you sure you want to delete this brand?")) {
                    $.ajax({
                        url: "/brands/destroy/" + productId,
                        method: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            alert(response.success);
                            loadBrands();
                        },
                        error: function() {
                            alert("Failed to delete product.");
                        }
                    });
                }
            });
        });

    // Search Records
    $("#searchBrand").on("keyup", function() {
        let query = $(this).val();
        $.ajax({
            url: "/brands/search/",
            method: "GET",
            data: {
                query: query
            },
            success: function(response) {
                let tableRows = "";
                $.each(response, function(index, brand) {
                    tableRows += `
                        <tr>
                            <th>${index + 1}</th>
                            <td>${brand.name}</td>
                            <td><img src="${brand.img}" width="50"></td>
                            <td>${brand.price}</td>
                            <td>${brand.brand}</td>
                            <td>${brand.unit}</td>
                            <td>${brand.category}</td>
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
</script>
@endsection