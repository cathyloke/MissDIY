@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm rounded">
                    <div class="card-header text-white" style="background-color: #98afc7;">
                        <h4 class="mb-0">Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Contact Number -->
                            <div class="mb-3">
                                <label for="contact_number" class="form-label">Contact Number</label>
                                <input type="text" class="form-control" id="contact_number" name="contact_number"
                                    value="{{ old('contact_number', Auth::user()->contact_number) }}">
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', Auth::user()->address) }}</textarea>
                            </div>

                            <!-- Gender -->
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select" id="gender" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ Auth::user()->gender == 'male' ? 'selected' : '' }}>Male
                                    </option>
                                    <option value="female" {{ Auth::user()->gender == 'female' ? 'selected' : '' }}>Female
                                    </option>
                                    <option value="other" {{ Auth::user()->gender == 'other' ? 'selected' : '' }}>Other
                                    </option>
                                </select>
                            </div>

                            <!-- Account Type -->
                            <div class="mb-3">
                                <label for="type" class="form-label">Account Type</label>
                                <select class="form-select" id="type" name="type" disabled>
                                    <option value="customer" {{ Auth::user()->isCustomer() ? 'selected' : '' }}>Customer
                                    </option>
                                    <option value="admin" {{ Auth::user()->isAdmin() ? 'selected' : '' }}>Admin
                                    </option>
                                </select>
                                <small class="text-muted">Account type cannot be changed.</small>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('profile.show') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
