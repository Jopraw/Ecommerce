@extends('layouts.app')
@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="bg-bg-card border border-border-dark rounded-2xl p-8">
            <div class="text-center mb-8">
                <svg class="w-12 h-12 text-accent-orange mx-auto mb-3" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 22h20L12 2zm0 4l7 14H5l7-14z"/></svg>
                <h1 class="text-2xl font-bold">Masuk ke <span class="text-accent-orange">AstroStep</span></h1>
            </div>
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange">
                    @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium mb-1">Password</label>
                    <input type="password" name="password" required class="w-full bg-bg-secondary border border-border-dark rounded-lg px-4 py-3 text-white outline-none focus:border-accent-orange">
                </div>
                <label class="flex items-center gap-2 text-sm text-text-secondary">
                    <input type="checkbox" name="remember" class="rounded border-border-dark bg-bg-secondary text-accent-orange focus:ring-accent-orange">
                    Ingat saya
                </label>
                <button type="submit" class="w-full bg-accent-orange hover:bg-accent-orange-dark text-white font-bold py-3 rounded-xl transition-all glow-orange-hover">Masuk</button>
            </form>
            <p class="text-center text-text-muted text-sm mt-6">Belum punya akun? <a href="{{ route('register') }}" class="text-accent-orange hover:underline">Daftar</a></p>
        </div>
    </div>
</div>
@endsection
