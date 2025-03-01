@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row align-items-center my-5">
        <div class="col-lg-4 text-center">
            <input type="search" id="searchProduct" class="form-control form-control-lg" placeholder="Search Products">
        </div>
        <div class="col-lg-8 text-center">
            <button type="button" class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#addProductModal">
                Add Products
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
                        <th>Image</th>
                        <th>Price</th>
                        <th>Brand</th>
                        <th>Unit</th>
                        <th>Category</th>
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
                        <input type="text" name="name" class="form-control" placeholder="Name">
                    </div>
                    <div class="mb-3">
                        <!-- <input type="file" name="img" class="form-control"> -->
                        <input type="file" name="img" class="form-control" multiple required>
                    </div>
                    <div class="mb-3">
                        <input type="number" name="price" class="form-control" placeholder="Price">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="brand" class="form-control" placeholder="Brand">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="unit" class="form-control" placeholder="Unit">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="category" class="form-control" placeholder="Category">
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
                        <input type="text" name="name" class="form-control" placeholder="Name">
                        <input type="hidden" name="id">
                    </div>
                    <div class="mb-3 d-flex">
                        <!-- <input type="file" name="img" class="form-control"> -->
                        <input type="file" name="images[]" class="form-control" multiple required>
                        <img id="editPreviewImg" src="" class="PrefillProductImg">
                    </div>
                    <div class="mb-3">
                        <input type="number" name="price" class="form-control" placeholder="Price">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="brand" class="form-control" placeholder="Brand">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="unit" class="form-control" placeholder="Unit">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="category" class="form-control" placeholder="Category">
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
        // function loadProducts() {
        //     $.ajax({
        //         url: "/products/show",
        //         method: "GET",
        //         dataType: "json",
        //         success: function(response) {
        //             let tableRows = "";
        //             $.each(response, function(index, product) {
        //                 tableRows += `
        //                 <tr>
        //                     <th>${index + 1}</th>
        //                     <td>${product.name}</td>
        //                     <td><img class="productImg" src="${product.img}"></td>
        //                     <td>${product.price}</td>
        //                     <td>${product.brand}</td>
        //                     <td>${product.unit}</td>
        //                     <td>${product.category}</td>
        //                     <td class="text-center">
        //                         <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${product.id}" data-bs-toggle="modal" data-bs-target="#updateModal">Edit</button>
        //                         <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${product.id}">Delete</button>
        //                     </td>
        //                 </tr>
        //             `;
        //             });
        //             $("#productTableBody").html(tableRows);
        //         },
        //         error: function() {
        //             alert("Failed to load products. Please try again.");
        //         }
        //     });
        // }


        function loadProducts() {
            $.ajax({
                url: "/products/show",
                method: "GET",
                dataType: "json",
                success: function(response) {
                    let tableRows = "";
                    $.each(response, function(index, product) {
                        let imagesHtml = "";
                        $.each(product.images, function(i, imgUrl) {
                            imagesHtml += `<img src="${imgUrl}" width="50" class="me-1">`;
                        });

                        tableRows += `
                    <tr>
                        <th>${index + 1}</th>
                        <td>${product.name}</td>
                        <td>${imagesHtml}</td>
                        <td>${product.price}</td>
                        <td>${product.brand}</td>
                        <td>${product.unit}</td>
                        <td>${product.category}</td>
                        <td>
                            <button class="btn btn-primary editBtn" data-id="${product.id}">Edit</button>
                            <button class="btn btn-danger deleteBtn" data-id="${product.id}">Delete</button>
                        </td>
                    </tr>
                `;
                    });
                    $("#productTableBody").html(tableRows);
                }
            });
        }

        // Add Records
        $("#addProductForm").on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "/products/store",
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
                url: `/products/update/${productId}`,
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
            let productId = $(this).data("id");
            $.ajax({
                url: `/products/edit_product/${productId}`,
                method: "GET",
                success: function(response) {
                    let form = $("#editProductForm");
                    form.find("input[name='id']").val(response.id);
                    form.find("input[name='name']").val(response.name);
                    form.find("input[name='price']").val(response.price);
                    form.find("input[name='brand']").val(response.brand);
                    form.find("input[name='unit']").val(response.unit);
                    form.find("input[name='category']").val(response.category);
                    $("#editPreviewImg").attr("src", response.img);
                },
                error: function() {
                    alert("Failed to fetch product details.");
                }
            });
        });

        // Delete Record
        $(document).on("click", ".deleteBtn", function() {
            let productId = $(this).data("id");
            if (confirm("Are you sure you want to delete this product?")) {
                $.ajax({
                    url: "/products/destroy/" + productId,
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
    });

    // Search Records
    $("#searchProduct").on("keyup", function() {
        let query = $(this).val();
        $.ajax({
            url: "/products/search/",
            method: "GET",
            data: {
                query: query
            },
            success: function(response) {
                let tableRows = "";
                $.each(response, function(index, product) {
                    tableRows += `
                        <tr>
                            <th>${index + 1}</th>
                            <td>${product.name}</td>
                            <td><img src="${product.img}" width="50"></td>
                            <td>${product.price}</td>
                            <td>${product.brand}</td>
                            <td>${product.unit}</td>
                            <td>${product.category}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-primary editBtn" data-id="${product.id}" data-bs-toggle="modal" data-bs-target="#updateModal">Edit</button>
                                <button type="button" class="btn btn-sm btn-danger deleteBtn" data-id="${product.id}">Delete</button>
                            </td>
                        </tr>
                    `;
                });
                $("#productTableBody").html(tableRows);
            },
            error: function() {
                alert("Search failed. Try again.");
            }
        });
    });
</script>
@endsection