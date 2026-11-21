<x-layouts.app title="My Profile - Circlo">
    <div class="flex flex-wrap items-center justify-between gap-3 w-full max-w-5xl">
        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">My Profile</h1>
        <a href="{{ route('profile.edit') }}"><x-button>Edit Profile</x-button></a>
    </div>

    {{-- UI-03 Profile Page: data from the Student Account (users table) --}}
    <section class="mt-6 w-full max-w-5xl rounded-3xl border border-slate-200 bg-white overflow-hidden">
        <div class="h-24 sm:h-32 bg-emerald-800"></div>

        <div class="px-5 sm:px-8">
            {{-- avatar overlaps the banner; status badge sits on the white area --}}
            <div class="-mt-10 sm:-mt-12 flex items-end justify-between gap-3">
                <div
                    class="w-20 h-20 sm:w-24 sm:h-24 shrink-0 rounded-full border-4 border-white bg-orange-400 text-white grid place-items-center text-2xl sm:text-3xl font-bold">
                    {{ strtoupper(substr($student->name, 0, 1)) }}
                </div>
                <span class="mb-1 rounded-full bg-lime-200 px-3 py-1 text-sm font-semibold whitespace-nowrap">
                    &#9679; {{ $student->account_status ?? 'Active' }}
                </span>
            </div>

            {{-- name is always below the banner, so it never overlaps the green area --}}
            <div class="mt-3">
                <h2 class="text-xl sm:text-2xl font-bold tracking-tight break-words">{{ $student->name }}</h2>
                <p class="text-slate-500 text-sm sm:text-base">
                    Member since
                    {{ \Illuminate\Support\Carbon::parse($student->member_since ?? $student->created_at)->format('d F Y') }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-3 sm:gap-4 p-5 sm:p-8 sm:grid-cols-2">
            <div class="rounded-2xl border border-slate-200 p-4 min-w-0">
                <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Student ID</span>
                <p class="mt-1 break-words">{{ $student->student_id }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 p-4 min-w-0">
                <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Email</span>
                <p class="mt-1 break-all">{{ $student->email }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 p-4 min-w-0">
                <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Phone number</span>
                <p class="mt-1 break-words {{ $student->phone_number ? '' : 'italic text-slate-500' }}">
                    {{ $student->phone_number ?? 'Not added yet' }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 p-4 min-w-0">
                <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Campus pickup
                    point</span>
                <p class="mt-1 break-words {{ $student->campus_pickup_point ? '' : 'italic text-slate-500' }}">
                    {{ $student->campus_pickup_point ?? 'Not added yet' }}</p>
            </div>
            <div class="rounded-2xl border border-slate-200 p-4 sm:col-span-2 min-w-0">
                <span class="block text-xs font-semibold uppercase tracking-wider text-slate-500">About</span>
                <p class="mt-1 whitespace-pre-line break-words {{ $student->about ? '' : 'italic text-slate-500' }}">
                    {{ $student->about ?? 'Tell other students a little about yourself.' }}</p>
            </div>
        </div>
    </section>
</x-layouts.app>
