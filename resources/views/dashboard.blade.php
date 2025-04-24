@extends('layouts.app')

@section('content')
<div class="container">
     {{-- Message de bienvenue --}}
     <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    {{ __('You are logged in') }}
                </div>
            </div>
        </div>
    </div>
    <div class="text-center py-5">
        <h2 class="display-4 mb-4">@lang('Welcome to Stock Management Systeme')</h2>
    </div>
    <ul style="list-style: none; padding-left: 0;">
        <li><a href="{{ route('customers.index') }}" class="btn btn-primary btn-lg shadow-sm mb-2">List Of Customers</a></li>
        <li><a href="{{ route('suppliers.index') }}" class="btn btn-success btn-lg shadow-sm mb-2">List Of Suppliers</a></li>
        <li><a href="{{ route('products.index') }}" class="btn btn-info btn-lg shadow-sm mb-2">List Of Products</a></li>
        <li><a href="{{ route('products.bycat') }}" class="btn btn-warning btn-lg shadow-sm mb-2">Products By Category</a></li>
        <li><a href="/products-by-supplier" class="btn btn-secondary btn-lg shadow-sm mb-2">Products By Supplier</a></li>
        <li><a href="/products-by-store" class="btn btn-dark btn-lg shadow-sm mb-2">Products By Store</a></li>
    </ul>
    {{-- Cookie --}}
    <div class="text-center my-5">
        <h1>
            Hello
            @if(Cookie::has("UserName"))
                {{ Cookie::get("UserName") }}
            @endif
        </h1>
        <form method="POST" action="{{ url('saveCookie') }}">
            @csrf
            <label for="txtCookie">Type your name</label>
            <input type="text" id="txtCookie" name="txtCookie" />
            <button class="btn btn-primary">
                Save Cookie
            </button>
        </form>
    </div>

    {{-- Session --}}
    <div class="text-center my-5">
        <h1>
            Hello
            @if(Session::has("SessionName"))
                {{ Session("SessionName") }}
            @endif
        </h1>
        <form method="POST" action="{{ url('saveSession') }}">
            @csrf
            <label for="txtSession">Type your name</label>
            <input type="text" id="txtSession" name="txtSession" />
            <button class="btn btn-primary">
                Save Session
            </button>
        </form>
    </div>

    {{-- Avatar --}}
    <div class="text-center my-5">
    <form method="POST" action="{{ route('saveAvatar') }}" enctype="multipart/form-data">
        @csrf
        <label for="avatarFile">@lang('Choose your picture') </label>
        <input type="file" id="avatarFile" name="avatarFile" />
        <button class="btn btn-primary">
            Save picture for your account
        </button>
        {{-- Affichage de l'image --}}
        <div class="mt-3">
            <img src="{{ asset('storage/avatars/' . ($pic ?? 'default.png')) }}" alt="Avatar" style="width:150px;height:150px;">
        </div>
    </form>
</div>

</div>
@endsection
