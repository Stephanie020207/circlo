<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Circlo' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <x-alert />
        {{ $slot }}
    </div>
</body>

</html>
