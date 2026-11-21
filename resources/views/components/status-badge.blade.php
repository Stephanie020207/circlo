@props(['status'])
@php
    $map = [
        'Pending' => 'bg-amber-100 text-amber-800',
        'Accepted' => 'bg-green-100 text-green-800',
        'Rejected' => 'bg-red-100 text-red-700',
        'Cancelled' => 'bg-slate-200 text-slate-600',
        'Active' => 'bg-blue-100 text-blue-800',
        'Completed' => 'bg-green-100 text-green-800',
    ];
@endphp
<span
    class="text-xs rounded-full px-3 py-1 shrink-0 {{ $map[$status] ?? 'bg-slate-200 text-slate-600' }}">{{ $status }}</span>
