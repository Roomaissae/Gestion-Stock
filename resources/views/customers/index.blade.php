@extends('layouts.app')

@section('content')

{{-- En-tête avec le titre et le bouton "Ajouter un nouveau client" --}}
<div class="row mb-4">
    <div class="col d-flex justify-content-between align-items-center">
        <h1 class="h3 mb-0">Customer list</h1>

        {{-- Lien vers la page de création d'un nouveau client --}}
        <a href="{{ route('customers.create') }}" class="btn btn-success d-flex align-items-center gap-2">
            {{-- Icône SVG --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                <path
                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
            </svg>
            Add New Customer
        </a>
    </div>
</div>

{{-- Champ de recherche pour filtrer les clients en temps réel --}}
<div class="row mb-3">
    <div class="col-md-6">
        <input type="text" id="searchInput" class="form-control" placeholder="Search customers...">
    </div>
</div>

{{-- Tableau des clients --}}
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="customerTableBody">
                {{-- Affichage des clients via une boucle Blade --}}
                @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->address }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            {{-- Bouton pour modifier un client --}}
                            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-primary">
                                {{-- Icône crayon --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                    <path
                                        d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                    <path fill-rule="evenodd"
                                        d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                </svg>
                                Edit
                            </a>

                            {{-- Bouton pour supprimer un client --}}
                            <a href="{{ route('customers.delete', $customer) }}" class="btn btn-sm btn-danger">
                                {{-- Icône poubelle --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                    <path fill-rule="evenodd"
                                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                </svg>
                                Delete
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Script de recherche AJAX temps réel --}}
@push('scripts')
<script>
    document.getElementById('searchInput').addEventListener('input', function () {
        const term = this.value;

        // Appel AJAX à l'API de recherche des clients
        fetch(`/customers/search?term=${term}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.getElementById('customerTableBody');
                tbody.innerHTML = ''; // Vider l'ancien contenu

                // Réinjection des résultats dans le tableau
                data.customers.forEach(customer => {
                    const row = `
                        <tr>
                            <td>${customer.first_name} ${customer.last_name}</td>
                            <td>${customer.email}</td>
                            <td>${customer.phone}</td>
                            <td>${customer.address}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="/customers/${customer.id}/edit" class="btn btn-sm btn-primary">Edit</a>
                                    <a href="/customers/${customer.id}/delete" class="btn btn-sm btn-danger">Delete</a>
                                </div>
                            </td>
                        </tr>
                    `;
                    tbody.insertAdjacentHTML('beforeend', row);
                });
            });
    });
</script>
@endpush

@endsection
