@extends('authpkg::layouts.app')

@section('title', 'Verify OTP')

@section('content')
<div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-4">Verify OTP</h2>
    <p class="text-center text-gray-600 mb-8">An OTP has been sent to your email address. Please enter it below.</p>

    @if (session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('otp.check') }}">
        @csrf
        <div class="mb-4">
            <label for="otp" class="block text-gray-700 text-sm font-bold mb-2">One-Time Password (OTP)</label>
            <input type="text" name="otp" id="otp" required autofocus
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('otp') border-red-500 @enderror">
            @error('otp')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                Verify OTP
            </button>
        </div>
    </form>
</div>
@endsection