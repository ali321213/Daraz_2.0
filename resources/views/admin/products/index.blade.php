@extends('layouts.admin')
@section('content')
@section('title', 'Products - Admin Panel')
<div class="container">
    <div class="row align-items-center my-5">
        <div class="col-lg-4 text-center">
            <input type="search" id="searchProduct" class="form-control form-control-lg" placeholder="Search Products">
        </div>
        <div class="col-lg-8 text-center">
            <button type="button" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Products</button>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <!-- <table id="productsTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Unit</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table> -->

            <table class="table-striped table-bordered text-capitalize text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Unit</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Slug</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="productTableBody"></tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Products</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addProductForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Product Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="file" name="image_path[]" class="form-control" multiple required>
                    </div>
                    <div class="mb-3">
                        <input type="number" name="price" step="0.01" class="form-control" placeholder="Price" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="description" class="form-control" placeholder="Description" required>
                    </div>
                    <div class="mb-3">
                        <input type="number" name="stock" class="form-control" placeholder="Stock" required>
                    </div>
                    <!-- Brand Selection -->
                    <div class="mb-3">
                        <select class="form-select" name="brand_id" required>
                            <option value="" disabled selected>Select Brand</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Unit Selection -->
                    <div class="mb-3">
                        <select class="form-select" name="unit_id" required>
                            <option value="" disabled selected>Select Unit</option>
                            @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Category Selection -->
                    <div class="mb-3">
                        <select class="form-select" name="category_id" required>
                            <option value="" disabled selected>Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
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
            <form id="editProductForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" name="id">
                        <input type="text" name="name" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="file" name="image_path[]" class="form-control" multiple required>
                        <img id="previewImage" src="" width="50" style="display: none;border-radius: 50%;border:2px solid black;">
                    </div>
                    <div class="mb-3">
                        <input type="number" name="price" step="0.01" class="form-control" placeholder="Price" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="description" class="form-control" placeholder="Description" required>
                    </div>
                    <div class="mb-3">
                        <input type="number" name="stock" class="form-control" placeholder="Stock" required>
                    </div>
                    <!-- Brand Selection -->
                    <div class="mb-3">
                        <select class="form-select" name="brand_id" required>
                            <option value="" disabled selected>Select Brand</option>
                            @foreach($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Unit Selection -->
                    <div class="mb-3">
                        <select class="form-select" name="unit_id" required>
                            <option value="" disabled selected>Select Unit</option>
                            @foreach($units as $unit)
                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Category Selection -->
                    <div class="mb-3">
                        <select class="form-select" name="category_id" required>
                            <option value="" disabled selected>Select Category</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
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
        loadProducts();
        // Show Records
        function loadProducts() {
            $.ajax({
                url: "/admin/products/show",
                method: "GET",
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    let tableRows = "";
                    if (response.length === 0) {
                        tableRows = `
                    <tr>
                        <td colspan="10" class="text-center">No Records Found</td>
                    </tr>`;
                    } else {
                        $.each(response, function(index, product) {
                            let imagesHtml = "";
                            if (product.images && product.images.length > 0) {
                                $.each(product.images, function(i, image) {
                                    imagesHtml += `<img src="{{ asset('storage') }}/${image.image_path}" class="productImg" alt="Product Image">`;
                                });
                            } else {
                                imagesHtml = `<span class="text-muted">No Image</span>`;
                            }
                            tableRows += `<tr>
                        <th>${index + 1}</th>
                        <td>${product.name}</td>
                        <td>${imagesHtml}</td>
                        <td>${product.price}</td>
                        <td>${product.description}</td>
                        <td>${product.unit ? product.unit.name : 'N/A'}</td>
                        <td>${product.brand ? product.brand.name : 'N/A'}</td>
                        <td>${product.category ? product.category.name : 'N/A'}</td>
                        <td>${product.slug}</td>
                        <td>${product.stock}</td>
                        <td>
                            <button class="btn btn-sm btn-info editBtn" data-id="${product.id}" data-bs-toggle="modal" data-bs-target="#updateModal">Edit</button>
                            <button class="btn btn-sm btn-danger deleteBtn" data-id="${product.id}">Delete</button>
                        </td>
                    </tr>`;
                        });
                    }
                    $("#productTableBody").html(tableRows);
                },
                error: function() {
                    $("#productTableBody").html(`
                <tr>
                    <td colspan="10" class="text-center text-danger">Error fetching data</td>
                </tr>`);
                }
            });
        }

        // Add Records
        $("#addProductForm").on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "/admin/products/create",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    alert(response.success);
                    loadProducts();
                    $("#addProductForm")[0].reset();
                    $("#exampleModal").modal('hide');
                    loadProducts();
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
        $("#editProductForm").on("submit", function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            let productId = $("input[name='id']").val();

            $.ajax({
                url: `/admin/products/update/${productId}`,
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
                    loadProducts(); // Refresh Product List
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
            let id = $(this).data("id");
            $.ajax({
                url: `/admin/products/edit/${id}`,
                method: "GET",
                success: function(response) {
                    let form = $("#editProductForm");
                    form.find("input[name='id']").val(response.id);
                    form.find("input[name='name']").val(response.name);
                    form.find("input[name='price']").val(response.price);
                    form.find("input[name='description']").val(response.description);
                    form.find("input[name='stock']").val(response.stock);
                    form.find("input[name='brand_id']").val(response.brand_id);
                    form.find("input[name='unit_id']").val(response.unit_id);
                    form.find("input[name='category_id']").val(response.category_id);
                    $("#previewImage").attr("src", "{{ asset('storage/') }}/" + response.image).show();
                    // $("#editPreviewImg").attr("src", response.img);
                },
                error: function() {
                    alert("Failed to fetch product details.");
                }
            });
        });

        // Delete Record
        $(document).on("click", ".deleteBtn", function() {
            let id = $(this).data("id");
            if (confirm("Are you sure you want to delete this product?")) {
                $.ajax({
                    url: "/admin/products/destroy/" + id,
                    method: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert(response.success);
                        loadProducts();
                    },
                    error: function() {
                        alert("Failed to delete product.");
                    }
                });
            }
        });

        // Search Records
        $("#searchProduct").on("keyup", function() {
            let query = $(this).val();
            $.ajax({
                url: "/admin/products/search/",
                method: "GET",
                data: {
                    query: query
                },
                success: function(response) {
                    let tableRows = "";
                    if (response.length === 0) {
                        tableRows = `
                        <tr><td colspan="8" class="text-center">No Records Found</td></tr>`;
                    } else {
                        $.each(response, function(index, product) {
                            let imagesHtml = "";
                            if (product.images && product.images.length > 0) {
                                $.each(product.images, function(i, image) {
                                    imagesHtml += `<img src="/storage/${image.image_path}" width="50" class="productImg" alt="Product Image"> `;
                                });
                            } else {
                                imagesHtml = `<span class="text-muted">No Image</span>`;
                            }
                            tableRows += `
                            <tr>
                                <th>${index + 1}</th>
                                <td>${product.name}</td>
                                <td>${imagesHtml}</td>
                                <td>${product.price}</td>
                                <td>${product.description}</td>
                                <td>${product.unit ? product.unit.name : 'N/A'}</td>
                                <td>${product.brand ? product.brand.name : 'N/A'}</td>
                                <td>${product.category ? product.category.name : 'N/A'}</td>
                                <td>${product.stock}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${product.id}" data-bs-toggle="modal" data-bs-target="#updateModal">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${product.id}">Delete</button>
                                </td>
                            </tr>
                        `;
                        });
                    }
                    $("#productTableBody").html(tableRows);
                },
                error: function() {
                    alert("Search failed. Try again.");
                }
            });
        });
    });
</script>
@endsection