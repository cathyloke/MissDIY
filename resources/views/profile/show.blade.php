@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm rounded">
                <div class="card-header text-white d-flex justify-content-between align-items-center" style="background-color: #98afc7;">
                    <h4 class="mb-0">My Profile</h4>
                    <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm">Edit Profile</a>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <div class="ms-3">
                            <h5 class="mb-1">{{ Auth::user()->name }}</h5>
                            <span class="text-muted">{{ Auth::user()->type }}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-sm-4 font-weight-bold">Email:</div>
                        <div class="col-sm-8">{{ Auth::user()->email }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 font-weight-bold">Contact Number:</div>
                        <div class="col-sm-8">{{ Auth::user()->contact_number ?? 'Not provided' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 font-weight-bold">Gender:</div>
                        <div class="col-sm-8 text-capitalize">{{ Auth::user()->gender ?? 'Not specified' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 font-weight-bold">Address:</div>
                        <div class="col-sm-8">{{ Auth::user()->address ?? 'Not provided' }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 font-weight-bold">Account Type:</div>
                        <div class="col-sm-8 text-capitalize">{{ Auth::user()->type }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
