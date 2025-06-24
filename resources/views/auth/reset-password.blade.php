@extends('authpkg::layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Reset Your Password</h2>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <div class="mb-4">
            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">New Password</label>
            <input type="password" name="password" id="password" required autocomplete="new-password"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('password') border-red-500 @enderror">
            @error('password')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label for="password-confirm" class="block text-gray-700 text-sm font-bold mb-2">Confirm New Password</label>
            <input type="password" name="password_confirmation" id="password-confirm" required autocomplete="new-password"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                Reset Password
            </button>
        </div>
    </form>
</div>
@endsection
