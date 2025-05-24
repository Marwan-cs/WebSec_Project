@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Staff Details') }}</div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4">{{ __('Name') }}</dt>
                        <dd class="col-sm-8">{{ $staff->name }}</dd>
                        <dt class="col-sm-4">{{ __('Email') }}</dt>
                        <dd class="col-sm-8">{{ $staff->email }}</dd>
                        <dt class="col-sm-4">{{ __('Role') }}</dt>
                        <dd class="col-sm-8">{{ $staff->roles->pluck('name')->join(', ') }}</dd>
                    </dl>
                    <a href="{{ route('manager.staff.edit', $staff->id) }}" class="btn btn-primary">Edit</a>
                    <a href="{{ route('manager.staff.index') }}" class="btn btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 