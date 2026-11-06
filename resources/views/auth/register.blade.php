@extends('layouts.app')
@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="bg-bg-card border border-border-dark rounded-2xl p-8">
            <div class="text-center mb-8">
                <svg class="w-12 h-12 text-accent-orange mx-auto mb-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 22h20L12 2zm0 4l7 14H5l7-14z"/></svg>
                <h1 class="text-2xl font-bold">Daftar di <span class="text-accent-orange">AstroStep</span></h1>
            </div>
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange">
                    @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange">
                    @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" name="password" required class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange">
                    @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange">
                </div>
                <button type="submit" class="w-full bg-accent-orange hover:bg-accent-orange-dark text-white font-bold py-3 rounded-xl transition-all glow-orange-hover">Daftar</button>
            </form>
            <p class="text-center text-text-muted text-sm mt-6">Sudah punya akun? <a href="{{ route('login') }}" class="text-accent-orange hover:underline">Masuk</a></p>
        </div>
    </div>
</div>
@endsection
