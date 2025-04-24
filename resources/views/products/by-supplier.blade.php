@extends('layouts.app')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-4">
                <select class="form-select" id="supplier-select">
                    <option value="">Select a supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div id="loading" class="text-center d-none">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div id="products-container">
            <!-- Produits affiche par axios-->
        </div>
    </div>
</div>

@endsection


@push('scripts')

<script>
    document.getElementById('supplier-select').addEventListener('change', function () {
        const supplierId = this.value; // Récupère l'ID du fournisseur sélectionné
        const loadingElement = document.getElementById('loading'); // Élément de chargement
        const productsContainer = document.getElementById('products-container'); 
        productsContainer.innerHTML = ''; 

        if (supplierId) {
            loadingElement.classList.remove('d-none');
            axios.get(`/api/products-by-supplier/${supplierId}`)
                .then(response => {
                    // Injecte la réponse HTML dans le conteneur
                    productsContainer.innerHTML = response.data;
                })
                .catch(error => {
                    // Affiche un message d’erreur en cas d’échec
                    console.error('Error:', error);
                    productsContainer.innerHTML = '<p class="text-danger">An error occurred while loading products.</p>';
                })
                .finally(() => {
                    loadingElement.classList.add('d-none');
                });
        }
    });
</script>

@endpush
