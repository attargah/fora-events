<!-- Navigation Bar -->
<header
    x-data="{ open: false }"
    class="sticky top-0 z-50 w-full border-b border-white/10 bg-background-light/80 dark:bg-background-dark/80 backdrop-blur-md px-6 lg:px-20 py-4"
>
    <!-- Top Bar -->
    <div class="mx-auto flex max-w-[1440px] items-center justify-between">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2 hover:opacity-80 transition-opacity">
            <img src="{{ asset('/logo_light.png') }}" class="w-[220px] h-full" alt="Logo">
        </a>

        <!-- Desktop Menu -->
        <nav class="hidden md:flex items-center gap-8">
            <a href="{{ route('events.index') }}" class="text-sm font-semibold hover:text-primary transition-colors">Events</a>
            <a href="{{ route('events.index', ['category' => ['concerts']]) }}" class="text-sm font-semibold hover:text-primary transition-colors">Concerts</a>
            <a href="{{ route('events.index', ['category' => ['sports']]) }}" class="text-sm font-semibold hover:text-primary transition-colors">Sports</a>
            <a href="{{ route('contact.index') }}" class="text-sm font-semibold hover:text-primary transition-colors">Contact</a>
        </nav>

        <!-- Desktop Auth -->
        <div class="hidden md:flex items-center gap-4">
            @auth
                <a href="{{ route('tickets.index') }}" class="text-sm font-semibold hover:text-primary transition-colors">
                    My Tickets
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="rounded-lg bg-primary px-6 py-2.5 text-sm font-bold text-white transition-transform active:scale-95"
                    >
                        Logout
                    </button>
                </form>
            @else
                <a
                    href="{{ route('login') }}"
                    class="rounded-lg bg-primary px-6 py-2.5 text-sm font-bold text-white transition-transform active:scale-95"
                >
                    Login
                </a>
            @endauth
        </div>

        <!-- Mobile Hamburger -->
        <button
            @click="open = !open"
            class="md:hidden flex items-center justify-center rounded-lg border border-white/20 p-2"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div
        x-show="open"
        x-transition
        @click.outside="open = false"
        class="md:hidden mt-4 rounded-2xl border border-white/10 bg-background-light dark:bg-background-dark p-6 space-y-6"
    >
        <!-- Links -->
        <nav class="flex flex-col gap-4">
            <a href="{{ route('events.index') }}" class="font-semibold hover:text-primary">Events</a>
            <a href="{{ route('events.index', ['category' => ['concerts']]) }}" class="font-semibold hover:text-primary">Concerts</a>
            <a href="{{ route('events.index', ['category' => ['sports']]) }}" class="font-semibold hover:text-primary">Sports</a>
            <a href="{{ route('contact.index') }}" class="font-semibold hover:text-primary">Contact</a>
        </nav>

        <!-- Auth -->
        <div class="border-t border-white/10 pt-4 flex flex-col gap-3">
            @auth
                <a href="{{ route('tickets.index') }}" class="font-semibold hover:text-primary">
                    My Tickets
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        type="submit"
                        class="w-full rounded-lg bg-primary py-2 text-sm font-bold text-white transition-transform active:scale-95"
                    >
                        Logout
                    </button>
                </form>
            @else
                <a
                    href="{{ route('login') }}"
                    class="w-full text-center rounded-lg bg-primary py-2 text-sm font-bold text-white transition-transform active:scale-95"
                >
                    Login
                </a>
            @endauth
        </div>
    </div>
</header>
