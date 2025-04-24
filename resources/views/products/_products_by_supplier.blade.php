@if($products->count() > 0)
<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->name }}</td> 
                <td>{{ $product->category->name ?? 'N/A' }}</td>      
                <td>{{ $product->description }}</td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td>{{ $product->stock->quantity_stock ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@else
<p class="text-muted">There is no product for this supplier.</p>
@endif
