@extends('layouts.app') 
@section('content') 
<div>
    <div>
        <h3>Products by Category</h3>         
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <select class="form-select" onchange="window.location.href=this.value;">
                            <option value="{{ route('products.bycat') }}" 
                                {{ !request()->route('category') ? 'selected' : '' }}>
                                Select a category
                            </option>
                            @foreach($categories as $cat)
                                <option value="{{ route('products.filter.by.category', ['category' => $cat->id]) }}" 
                                    {{ request()->route('category')?->id === $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Supplier</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->stock->quantity_stock ?? 0 }}</td>
                                    <td>{{ $product->supplier->name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        No products found in this category
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 
