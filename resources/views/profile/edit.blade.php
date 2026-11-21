<x-layouts.app title="Edit Profile - Circlo">
    <a href="{{ route('profile.show') }}" class="text-sm text-slate-500 hover:text-slate-800">&larr; Back to My
        Profile</a>
    <h1 class="text-2xl sm:text-3xl font-bold tracking-tight mt-2 mb-6">Edit Profile</h1>

    {{-- UI-04 Edit Profile Page --}}
    <form method="POST" action="{{ route('profile.update') }}"
        class="w-full max-w-5xl rounded-3xl border border-slate-200 bg-white p-5 sm:p-8">
        @csrf
        @method('PUT')

        <div class="mb-4 rounded-2xl bg-slate-50 p-4">
            <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Student ID</span>
            <p class="mt-1">{{ $student->student_id }}</p>
            <p class="text-xs text-slate-500 mt-1">The Student ID cannot be changed.</p>
        </div>

        <div class="grid grid-cols-1 gap-x-4 sm:grid-cols-2">
            <x-input label="Full name" name="name" :value="$student->name" />
            <x-input label="Email" name="email" type="email" :value="$student->email" />
            <x-input label="Phone number" name="phone_number" :value="$student->phone_number" />
            <x-input label="Campus pickup point" name="campus_pickup_point" :value="$student->campus_pickup_point" />
        </div>

        <x-textarea label="About" name="about" :value="$student->about" :rows="4" />

        <div class="flex flex-col-reverse gap-3 sm:flex-row">
            <a href="{{ route('profile.show') }}"
                class="px-4 py-2 border rounded-lg text-center hover:bg-slate-50 sm:order-2">Cancel</a>
            <x-button type="submit" class="sm:order-1">Save changes</x-button>
        </div>
    </form>
</x-layouts.app>
