<!DOCTYPE html>
<html lang="en" class="h-full bg-slate-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookstore</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-slate-950 text-white" data-page="{{ $page ?? 'home' }}">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(14,116,144,0.2),_transparent_30%),linear-gradient(180deg,#020617,#020617_25%,#020817)]">
        <header class="sticky top-0 z-30 border-b border-white/10 bg-slate-950/80 backdrop-blur">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4">
                <a href="/" class="flex items-center gap-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-cyan-500 text-lg font-bold text-slate-950">B</div>
                    <div>
                        <p class="text-lg font-semibold text-white">Bookstore</p>
                        <p class="text-[10px] uppercase tracking-[0.28em] text-cyan-200">Curated reads</p>
                    </div>
                </a>

                <nav class="hidden items-center gap-6 text-sm text-slate-300 md:flex">
                    <a href="/" class="transition hover:text-white">Home</a>
                    <a href="/cart" class="transition hover:text-white">Cart</a>
                    <a href="/orders" class="transition hover:text-white">Orders</a>
                    <a href="/profile" class="transition hover:text-white">Profile</a>
                    <a id="admin-link" href="/admin" class="hidden transition hover:text-white">Admin</a>
                </nav>

                <div class="flex items-center gap-3">
                    <a href="/cart" class="relative rounded-full border border-white/10 px-3 py-2 text-sm text-white">
                        Cart <span id="cart-badge" class="ml-2 rounded-full bg-cyan-500 px-2 py-0.5 text-[10px] font-bold text-slate-950">0</span>
                    </a>

                    <div id="auth-menu-logged-out" class="flex items-center gap-2">
                        <a href="/login" class="rounded-full border border-white/10 px-3 py-2 text-sm font-medium text-white">Login</a>
                        <a href="/register" class="rounded-full bg-cyan-500 px-3 py-2 text-sm font-semibold text-slate-950">Register</a>
                    </div>

                    <div id="auth-menu-logged-in" class="hidden items-center gap-2">
                        <div class="rounded-full border border-cyan-500/30 bg-cyan-500/10 px-3 py-2 text-xs font-semibold text-cyan-100">
                            <span id="user-label">Account</span>
                        </div>
                        <button id="logout-button" class="rounded-full bg-rose-500/20 px-3 py-2 text-sm font-semibold text-rose-100">Logout</button>
                    </div>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-6">
            @yield('content')
        </main>
    </div>

    <div id="toast-container" class="pointer-events-none fixed right-4 top-4 z-50 flex max-w-md flex-col gap-2"></div>
</body>
</html>
