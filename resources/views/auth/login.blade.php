@extends('site.layouts.app')

@section('title', 'Login - ForaEvents')

@section('content')
<div class="flex min-h-[60vh] items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
    <div class="w-full max-w-md space-y-8 bg-white dark:bg-slate-800 p-8 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700">
        <div>
            <h2 class="mt-2 text-center text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                Welcome back
            </h2>
            <p class="mt-2 text-center text-sm text-slate-600 dark:text-slate-400">
                Sign in to your account
            </p>
        </div>
        <form class="mt-8 space-y-6" action="{{ route('authenticate') }}" method="POST">
            @csrf
            <div class="space-y-4 rounded-md shadow-sm">
                <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-slate-900 dark:text-slate-200">Email address</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required
                               class="block w-full rounded-lg border-0 py-2.5 text-slate-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6 dark:bg-slate-700 dark:text-white dark:ring-slate-600 dark:placeholder-slate-400"
                               value="{{ old('email') }}">
                    </div>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium leading-6 text-slate-900 dark:text-slate-200">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                               class="block w-full rounded-lg border-0 py-2.5 text-slate-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6 dark:bg-slate-700 dark:text-white dark:ring-slate-600 dark:placeholder-slate-400">
                    </div>

                </div>

            </div>

            @error('email')
                <p class="text-sm text-red-600 dark:text-red-400 mt-2">{{ $message }}</p>
            @enderror

            <div>
                <button type="submit"
                    class="group relative flex w-full justify-center rounded-lg bg-primary px-3 py-2.5 text-sm font-semibold text-white hover:bg-blue-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition-all duration-200 shadow-md hover:shadow-lg">

                    Sign in
                </button>
            </div>

            <div class="text-sm text-center">
                <a href="{{ route('register') }}" class="font-medium text-primary hover:text-blue-500 transition-colors">
                    Don't have an account? Create one
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
