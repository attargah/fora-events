<!DOCTYPE html>
<html class="dark" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'ForaEvents | Experience the Moment')</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#135bec",
                        "background-light": "#f6f6f8",
                        "background-dark": "#101622",
                    },
                    fontFamily: {
                        "display": ["Be Vietnam Pro", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Be Vietnam Pro', sans-serif;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-white transition-colors duration-300">
<div class="relative flex min-h-screen flex-col">
    @include('site.partials.header')
    
    <main class="flex-1 pb-20">
        @yield('content')
    </main>
    
    @include('site.partials.footer')
</div>


<div 
    x-data="{ 
        notifications: [],
        add(message, type = 'success') {
            if (!message) return;
            const id = Date.now() + Math.random();
            this.notifications.push({ id, message, type });
            setTimeout(() => this.remove(id), 5000);
        },
        remove(id) {
            this.notifications = this.notifications.filter(n => n.id !== id);
        }
    }"
    @notify.window="add($event.detail.message, $event.detail.type)"
    x-init="
        @if(session('success')) add(@js(session('success')), 'success'); @endif
        @if(session('error')) add(@js(session('error')), 'error'); @endif
        @if($errors->any())
            @foreach($errors->all() as $error)
                add(@js($error), 'error');
            @endforeach
        @endif
    "
    class="fixed bottom-4 right-4 z-[9999] flex flex-col gap-2 w-full max-w-xs pointer-events-none"
>
    <template x-for="notification in notifications" :key="notification.id">
        <div 
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="translate-y-2 opacity-0 scale-95"
            x-transition:enter-end="translate-y-0 opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="translate-y-0 opacity-100 scale-100"
            x-transition:leave-end="translate-y-2 opacity-0 scale-95"
            class="pointer-events-auto flex items-center gap-3 p-4 rounded-xl shadow-2xl border backdrop-blur-md"
            :class="{
                'bg-green-50/90 dark:bg-green-900/40 border-green-200 dark:border-green-800 text-green-800 dark:text-green-200': notification.type === 'success',
                'bg-red-50/90 dark:bg-red-900/40 border-red-200 dark:border-red-800 text-red-800 dark:text-red-200': notification.type === 'error'
            }"
        >
            <span class="material-symbols-outlined shrink-0" x-text="notification.type === 'success' ? 'check_circle' : 'error'"></span>
            <p class="text-sm font-semibold leading-tight" x-text="notification.message"></p>
            <button @click="remove(notification.id)" class="ml-auto text-current opacity-50 hover:opacity-100 transition-opacity">
                <span class="material-symbols-outlined text-sm">close</span>
            </button>
        </div>
    </template>
</div>

@stack('scripts')
</body>
</html>
