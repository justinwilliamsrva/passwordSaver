{{-- resources/views/passwords/show.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Decrypt Password</h2>
    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif
    <form method="POST" action="{{ route('passwords.decrypt') }}" id="decryptForm">
        @csrf
        <div class="form-group">
        <label for="accountSelect">Select Account:</label>
        <select class="form-control" id="accountSelect" name="account_name">
            @foreach($passwords as $pwd)
                <option value="{{ $pwd->account_name }}">{{ $pwd->account_name }}</option>
            @endforeach
        </select>
    </div>
        <div class="form-group">
            <label for="app_key">App Key:</label>
            <input type="password" class="form-control" id="app_key" name="app_key" autocomplete="off" required>
        </div>
        <button type="submit" class="btn btn-primary">Decrypt</button>
        <button type="button" class="btn btn-secondary" onclick="clearForm()">Clear</button>
    </form>

    @if(isset($password))
    <div class="mt-4" id="passwordDetails">
        <h3>Account Details</h3>
        <p><strong>Account Name:</strong> {{ $password->account_name }}</p>
        <p><strong>Username:</strong> {{ $password->username }}</p>
        <p><strong>Password:</strong>
            <span id="passwordField">********</span>
            <button onclick="togglePasswordVisibility()">Show</button>
            <button onclick="copyToClipboard()">Copy</button>
            <span id="copyMessage"></span>
        </p>
    </div>
    @endif
</div>

<script>
function togglePasswordVisibility() {
    var passwordField = document.getElementById('passwordField');
    if (passwordField.innerHTML === '********') {
        passwordField.innerHTML = '{{ $decryptedPassword ?? '' }}';
    } else {
        passwordField.innerHTML = '********';
    }
}

function clearForm() {
    document.getElementById('decryptForm').reset();
    var passwordDetails = document.getElementById('passwordDetails');
    if (passwordDetails) {
        passwordDetails.style.display = 'none';
    }
}

function updateAccountName() {
    var selectedAccount = document.getElementById('accountSelect').value;
    document.getElementById('account_name').value = selectedAccount;
}

function copyToClipboard() {
    var password = '{{ $decryptedPassword ?? '' }}';
    var tempInput = document.createElement("input");
    tempInput.style = "position: absolute; left: -1000px; top: -1000px";
    tempInput.value = password;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);

    var copyMessage = document.getElementById('copyMessage');
    copyMessage.innerText = 'Password copied!';
    setTimeout(() => copyMessage.innerText = '', 3000);
}
</script>

@endsection
