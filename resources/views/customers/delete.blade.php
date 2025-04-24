@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col d-flex justify-content-between align-items-center">
            <h2 class="h3 mb-0">Delete Customer</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="alert alert-danger">
                <h4 class="alert-heading">Confirm Deletion</h4>
                <p>Are you sure you want to delete the following customer?</p>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">{{ $customer->first_name }} {{ $customer->last_name }}</h5>
                    <p class="card-text"><strong>Email:</strong> {{ $customer->email }}</p>
                    <p class="card-text"><strong>Phone:</strong> {{ $customer->phone }}</p>
                    <p class="card-text"><strong>Address:</strong> {{ $customer->address }}</p>
                </div>
            </div>

            <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-danger">Confirm Delete</button>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection