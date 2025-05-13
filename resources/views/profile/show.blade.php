@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">User Profile</h5>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">Edit Profile</a>
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Name:</div>
                        <div class="col-md-8">{{ $user->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Email:</div>
                        <div class="col-md-8">{{ $user->email }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Roles:</div>
                        <div class="col-md-8">
                            @foreach($user->roles as $role)
                                <span class="badge bg-primary me-1">{{ $role->name }}</span>
                            @endforeach
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Created At:</div>
                        <div class="col-md-8">{{ $user->created_at->format('F j, Y g:i a') }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Last Updated:</div>
                        <div class="col-md-8">{{ $user->updated_at->format('F j, Y g:i a') }}</div>
                    </div>

                    @if($user->email_verified_at)
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Email Verified:</div>
                            <div class="col-md-8">
                                <span class="badge bg-success">Yes</span>
                                ({{ $user->email_verified_at->format('F j, Y g:i a') }})
                            </div>
                        </div>
                    @else
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Email Verified:</div>
                            <div class="col-md-8">
                                <span class="badge bg-warning">No</span>
                                <a href="{{ route('verification.send') }}" class="btn btn-link btn-sm">Resend Verification Email</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 