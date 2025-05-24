@extends('layouts.master')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0">Session Expired</h4>
                </div>
                <div class="card-body text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Page Expired (419)</h5>
                    <p class="card-text">
                        Your session has expired or the page has timed out. This usually happens when:
                    </p>
                    <ul class="text-left">
                        <li>You've been inactive for too long</li>
                        <li>The page was open in multiple tabs</li>
                        <li>Your browser's cookies were cleared</li>
                    </ul>
                    <div class="mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Go Back
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Login Again
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 