<x-layouts.guest title="Register - Circlo">
    <div class="text-center mb-6">
        <h1 class="text-3xl font-bold text-slate-900">CIRCLO</h1>
        <p class="text-slate-600">Create your student account</p>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex mb-6 border-b">
            <a href="{{ route('login') }}" class="flex-1 text-center pb-2 text-slate-500 hover:text-slate-800">Login</a>
            <a href="{{ route('register') }}"
                class="flex-1 text-center pb-2 font-semibold border-b-2 border-blue-600 text-blue-600">Register</a>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <x-input label="Full name" name="name" />
            <x-input label="Student ID" name="student_id" />
            <x-input label="Email" name="email" type="email" />
            <x-input label="Password" name="password" type="password" />
            <x-input label="Confirm password" name="password_confirmation" type="password" />

            <x-button type="submit" class="w-full">Create Account</x-button>
        </form>
    </div>
</x-layouts.guest>
