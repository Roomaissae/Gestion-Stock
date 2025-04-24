@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col d-flex justify-content-between align-items-center">
            <h2 class="h3 mb-0">Edit Customer</h2>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Formulaire de mise à jour du client -->
            <form action="{{ route('customers.update', $customer) }}" method="POST" id="customerForm">
                @csrf
                @method('PUT') <!-- Utilisation de la méthode PUT pour la mise à jour -->

                <!-- Champ pour le prénom du client -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                id="first_name" name="first_name" value="{{ old('first_name', $customer->first_name) }}"
                                required>
                            @error('first_name') <!-- Affichage de l'erreur pour le prénom -->
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Champ pour le nom de famille du client -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                id="last_name" name="last_name" value="{{ old('last_name', $customer->last_name) }}"
                                required>
                            @error('last_name') <!-- Affichage de l'erreur pour le nom de famille -->
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Champ pour l'adresse email du client -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" value="{{ old('email', $customer->email) }}" required>
                    @error('email') <!-- Affichage de l'erreur pour l'email -->
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Champ pour le numéro de téléphone du client -->
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone"
                        value="{{ old('phone', $customer->phone) }}" required>
                    @error('phone') <!-- Affichage de l'erreur pour le téléphone -->
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Champ pour l'adresse du client -->
                <div class="mb-3">
                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                        rows="3" required>{{ old('address', $customer->address) }}</textarea>
                    @error('address') <!-- Affichage de l'erreur pour l'adresse -->
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Boutons pour soumettre ou annuler -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">Update Customer</button>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Validation du formulaire avant soumission
    $(document).ready(function() {
        $('#customerForm').on('submit', function(event) {
            let isValid = true;

            // Validation du prénom
            if (!$('#first_name').val().trim()) {
                $('#first_name').addClass('is-invalid');
                isValid = false;
            } else {
                $('#first_name').removeClass('is-invalid');
            }

            // Validation du nom de famille
            if (!$('#last_name').val().trim()) {
                $('#last_name').addClass('is-invalid');
                isValid = false;
            } else {
                $('#last_name').removeClass('is-invalid');
            }

            // Validation de l'email (format d'email valide)
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!$('#email').val().trim() || !emailRegex.test($('#email').val().trim())) {
                $('#email').addClass('is-invalid');
                isValid = false;
            } else {
                $('#email').removeClass('is-invalid');
            }

            // Validation du téléphone
            if (!$('#phone').val().trim()) {
                $('#phone').addClass('is-invalid');
                isValid = false;
            } else {
                $('#phone').removeClass('is-invalid');
            }

            // Validation de l'adresse
            if (!$('#address').val().trim()) {
                $('#address').addClass('is-invalid');
                isValid = false;
            } else {
                $('#address').removeClass('is-invalid');
            }

            // Si le formulaire n'est pas valide, empêcher l'envoi
            if (!isValid) {
                event.preventDefault();
            }
        });
    });
</script>
@endpush
@endsection
