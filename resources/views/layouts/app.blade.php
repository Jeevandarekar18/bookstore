<!DOCTYPE html>
<html lang="en" class="h-full bg-[#f8f5f1]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookstore</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full bg-stone-50 text-[#2f241f]" data-page="{{ $page ?? 'home' }}">
    <div class="min-h-screen bg-white/70">
        <header class="sticky top-0 z-30 border-b border-stone-200/80 bg-white/90 backdrop-blur">
            <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3">
                <a href="/" class="flex items-center gap-2.5">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-sm font-bold text-white">B</div>
                    <div>
                        <p class="text-base font-semibold text-stone-900">Bookstore</p>
                        <p class="text-[9px] uppercase tracking-[0.28em] text-blue-700">Curated reads</p>
                    </div>
                </a>

                <nav class="hidden items-center gap-5 text-sm text-stone-600 md:flex">
                    <a href="/" class="transition hover:text-stone-900">Home</a>
                    <a href="/cart" class="transition hover:text-stone-900">Cart</a>
                    <a href="/orders" class="transition hover:text-stone-900">Orders</a>
                    <a href="/profile" class="transition hover:text-stone-900">Profile</a>
                    <a id="admin-link" href="/admin" class="hidden transition hover:text-stone-900">Admin</a>
                </nav>

                <div class="flex items-center gap-2.5">
                    <a href="/cart" class="relative rounded-full border border-stone-300 px-2.5 py-1.5 text-xs font-medium text-stone-700">
                        Cart <span id="cart-badge" class="ml-2 rounded-full bg-blue-600 px-1.5 py-0.5 text-[9px] font-bold text-white">0</span>
                    </a>

                    <div id="auth-menu-logged-out" class="flex items-center gap-2">
                        <a href="/login" class="rounded-full border border-stone-300 px-2.5 py-1.5 text-xs font-medium text-stone-700">Login</a>
                        <a href="/register" class="rounded-full bg-blue-600 px-2.5 py-1.5 text-xs font-semibold text-white">Register</a>
                    </div>

                    <div id="auth-menu-logged-in" class="hidden items-center gap-2">
                        <div class="rounded-full border border-blue-200 bg-blue-50 px-2.5 py-1.5 text-[10px] font-semibold text-blue-700">
                            <span id="user-label">Account</span>
                        </div>
                        <button id="logout-button" class="rounded-full border border-rose-200 bg-rose-50 px-2.5 py-1.5 text-xs font-semibold text-rose-700">Logout</button>
                    </div>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-4">
            @yield('content')
        </main>
    </div>

    <div id="toast-container" class="pointer-events-none fixed right-4 top-4 z-50 flex max-w-md flex-col gap-2"></div>
</body>
</html>
