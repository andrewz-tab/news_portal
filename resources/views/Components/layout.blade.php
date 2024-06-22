@vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Temp</title>
</head>

<body>

<nav class="nav navbar navbar-dark bg-dark">
    <div class="container">
        <x-nav-link href="{{ route('home.index') }}">Home</x-nav-link>
        <x-nav-link href="{{ route('post.index') }}">News</x-nav-link>
        <x-nav-link href="{{ route('home.contacts') }}">Contacts</x-nav-link>
        <x-nav-link href="{{ route('home.about') }}">About</x-nav-link>
        @can('view', auth()->user())
            <x-nav-link href="{{ route('admin.post.index') }}">Admin Panel</x-nav-link>
        @endcan

    </div>
</nav>
<div class="container">
    @yield('content')
</div>
</body>

</html>
