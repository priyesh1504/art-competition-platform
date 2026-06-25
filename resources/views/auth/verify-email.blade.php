@extends('layouts.app')

@section('content')

<div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">

<h2 class="text-xl font-bold mb-4">
Verify Your Email Address
</h2>

<p class="text-gray-600 mb-4">
Please check your email for a verification link.
</p>

@if (session('status') == 'verification-link-sent')
<div class="text-green-600 mb-4">
A new verification link has been sent to your email.
</div>
@endif

<form method="POST" action="{{ route('verification.send') }}">
@csrf
<button class="bg-indigo-600 text-white px-4 py-2 rounded">
Resend Verification Email
</button>
</form>

</div>

@endsection