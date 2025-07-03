<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <style>
            .bg-auth {
                background-image: url('/images/bg-login.png'); /* update with your image path */
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
            }
            .bg-overlay {
                background-color: rgba(0, 0, 0, 0.6); /* dark overlay */
            }
        </style>
    </head>
    <body class="min-h-screen antialiased bg-auth">
        <div class="flex min-h-screen items-center justify-center bg-overlay px-4">
            <div class="w-full max-w-md rounded-2xl bg-white/90 p-8 shadow-lg backdrop-blur-md dark:bg-neutral-900/80">
                <div class="mb-6 flex flex-col items-center gap-2 font-medium">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('images/icreative-logo.png') }}" alt="I-Creative Logo" class="h-12 w-auto" />
                    </a>
                </div>

                {{ $slot }}
            </div>
        </div>

        @fluxScripts
    </body>
</html>
