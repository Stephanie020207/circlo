<x-layouts.guest title="Login - Circlo">
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-slate-900">CIRCLO</h1>
        <p class="text-slate-600">Borrow. Share. Make it Count.</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex mb-6 border-b">
            <a href="{{ route('login') }}"
                class="flex-1 text-center pb-2 font-semibold border-b-2 border-blue-600 text-blue-600">Login</a>
            <a href="{{ route('register') }}"
                class="flex-1 text-center pb-2 text-slate-500 hover:text-slate-800">Register</a>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <x-input label="Email or Student ID" name="login" placeholder="student@its.ac.id" />
            <x-input label="Password" name="password" type="password" />

            <label class="flex items-center gap-2 text-sm mb-4">
                <input type="checkbox" name="remember" class="rounded"> Remember me
            </label>

            <x-button type="submit" class="w-full">Login</x-button>
        </form>
    </div>
</x-layouts.guest>
