@extends('layouts.app')

@include('products.partials.import-modal')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col d-flex justify-content-between align-items-center">
            <h2 class="h3 mb-0">Product List</h2>
            <div class="d-flex gap-2">
                <a class="btn btn-warning" href="{{ route('products.export') }}">
                    <i class="fa fa-download"></i> Export Products Data
                </a>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importProductModal">
                    <i class="fa fa-file"></i> Import
                </button>
                <button type="button" class="btn btn-success d-flex align-items-center gap-2" data-bs-toggle="modal"
                    data-bs-target="#createProductModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                    </svg>
                    Add New Product
                </button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search products..."
                            value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="button" id="searchButton">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Supplier</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productsTableBody">
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock->quantity_stock ?? 0 }}</td>
                            <td>{{ $product->supplier->first_name }} {{ $product->supplier->last_name }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-primary edit-product"
                                        data-id="{{ $product->id }}" data-bs-toggle="modal"
                                        data-bs-target="#editProductModal">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger delete-product"
                                        data-id="{{ $product->id }}" data-name="{{ $product->name }}"
                                        data-bs-toggle="modal" data-bs-target="#deleteProductModal">Delete</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('products.partials.create-modal')
@include('products.partials.edit-modal')
@include('products.partials.delete-modal')

@push('scripts')
<script>
$(document).ready(function () {
    function loadProducts(page = 1, search = '') {
        $.ajax({
            url: '{{ route("products.index") }}',
            type: 'GET',
            data: {
                page: page,
                search: search
            },
            success: function (response) {
                let products = response.products;
                let tbody = $('#productsTableBody');
                tbody.empty();

                products.forEach(function (product) {
                    tbody.append(`
                        <tr>
                            <td>${product.name}</td>
                            <td>${product.category.name}</td>
                            <td>${product.description}</td>
                            <td>$${parseFloat(product.price).toFixed(2)}</td>
                            <td>${product.stock ? product.stock.quantity_stock : 0}</td>
                            <td>${product.supplier.name}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-sm btn-primary edit-product" data-id="${product.id}" data-bs-toggle="modal" data-bs-target="#editProductModal">Edit</button>
                                    <button type="button" class="btn btn-sm btn-danger delete-product" data-id="${product.id}" data-name="${product.name}" data-bs-toggle="modal" data-bs-target="#deleteProductModal">Delete</button>
                                </div>
                            </td>
                        </tr>
                    `);
                });

                attachEventHandlers();
            },
            error: function (xhr) {
                console.error('Erreur lors du chargement des produits:', xhr);
            }
        });
    }

    function attachEventHandlers() {
        $('.edit-product').on('click', function () {
            let productId = $(this).data('id');
            $.ajax({
                url: `/api/products/${productId}`,
                type: 'GET',
                success: function (product) {
                    $('#editProductId').val(product.id);
                    $('#editName').val(product.name);
                    $('#editDescription').val(product.description);
                    $('#editPrice').val(product.price);
                    $('#editCategoryId').val(product.category_id);
                    $('#editSupplierId').val(product.supplier_id);
                    $('#editProductForm').attr('action', `/products/${productId}`);
                },
                error: function (xhr) {
                    console.error('Erreur récupération produit:', xhr);
                }
            });
        });

        $('.delete-product').on('click', function () {
            let productId = $(this).data('id');
            let productName = $(this).data('name');
            $('#deleteProductId').val(productId);
            $('#productName').text(productName);
            $('#deleteProductForm').attr('action', `/products/${productId}`);
        });
    }

    let searchTimeout;
    $('#searchInput').on('keyup', function () {
        clearTimeout(searchTimeout);
        let search = $(this).val();

        searchTimeout = setTimeout(function () {
            loadProducts(1, search);
        }, 500);
    });

    $('#searchButton').on('click', function () {
        let search = $('#searchInput').val();
        loadProducts(1, search);
    });

    // Chargement initial des produits
    loadProducts();
});
</script>
@endpush

@endsection
