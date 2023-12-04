{{-- resources/views/passwords/create.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Enter Password Details</h2>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <form method="POST" action="{{ route('passwords.store') }}">
        @csrf
        <div class="form-group">
            <label for="app_key">Key:</label>
            <input type="password" class="form-control" id="app_key" name="app_key" autocomplete="off"  required>
        </div>
        <div class="form-group">
            <label for="account_name">Account Name:</label>
            <input type="text" class="form-control" id="account_name" name="account_name" required>
        </div>
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
