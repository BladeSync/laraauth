@extends('authpkg::layouts.app')

@section('title', 'Home')

@section('content')
<div class="w-full max-w-2xl bg-white rounded-lg shadow-md p-8 text-center">
    <h2 class="text-3xl font-bold text-gray-800 mb-4">
        Welcome, {{ Auth::user()->name }}!
    </h2>
    
    <p class="text-gray-600 mb-8">
        You have successfully logged in using the authentication package.
    </p>

    {{-- Logout Button Form --}}
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
            Logout
        </button>
    </form>
</div>
@endsection