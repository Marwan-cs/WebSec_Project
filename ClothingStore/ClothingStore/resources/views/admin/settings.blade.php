@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">System Settings</h5>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('settings.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="site_name" class="form-label">Site Name</label>
                            <input type="text" class="form-control @error('site_name') is-invalid @enderror" 
                                   id="site_name" name="site_name" value="{{ old('site_name', config('app.name')) }}">
                            @error('site_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="site_description" class="form-label">Site Description</label>
                            <textarea class="form-control @error('site_description') is-invalid @enderror" 
                                      id="site_description" name="site_description" rows="3">{{ old('site_description', config('app.description')) }}</textarea>
                            @error('site_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="contact_email" class="form-label">Contact Email</label>
                            <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                                   id="contact_email" name="contact_email" value="{{ old('contact_email', config('mail.from.address')) }}">
                            @error('contact_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="maintenance_mode" class="form-label">Maintenance Mode</label>
                            <select class="form-select @error('maintenance_mode') is-invalid @enderror" 
                                    id="maintenance_mode" name="maintenance_mode">
                                <option value="0" {{ old('maintenance_mode', app()->isDownForMaintenance() ? '1' : '0') == '0' ? 'selected' : '' }}>Off</option>
                                <option value="1" {{ old('maintenance_mode', app()->isDownForMaintenance() ? '1' : '0') == '1' ? 'selected' : '' }}>On</option>
                            </select>
                            @error('maintenance_mode')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="registration_enabled" class="form-label">User Registration</label>
                            <select class="form-select @error('registration_enabled') is-invalid @enderror" 
                                    id="registration_enabled" name="registration_enabled">
                                <option value="1" {{ old('registration_enabled', config('auth.registration_enabled', true)) ? 'selected' : '' }}>Enabled</option>
                                <option value="0" {{ old('registration_enabled', config('auth.registration_enabled', true)) ? '' : 'selected' }}>Disabled</option>
                            </select>
                            @error('registration_enabled')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 