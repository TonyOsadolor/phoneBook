<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" href="{{ asset('/assets/icons/contacts.png') }}" sizes="any">
<link rel="icon" href="{{ asset('/assets/icons/contacts.png') }}" type="image/png">
<link rel="apple-touch-icon" href="{{ asset('/assets/icons/contacts.png') }}">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
