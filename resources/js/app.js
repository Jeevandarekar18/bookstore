import $ from 'jquery';

window.$ = $;
window.jQuery = $;

const AUTH_TOKEN_KEY = 'bookstore_auth_token';
const AUTH_USER_KEY = 'bookstore_auth_user';
const CART_KEY = 'bookstore_cart';

const App = {
    token: localStorage.getItem(AUTH_TOKEN_KEY),
    user: JSON.parse(localStorage.getItem(AUTH_USER_KEY) || 'null'),
};

function formatCurrency(value) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(Number(value || 0));
}

function showToast(type, message) {
    const toast = $(`
    <div class="pointer-events-auto min-w-72 rounded-2xl border px-4 py-3 text-sm shadow-xl ${type === 'success' ? 'border-emerald-500/40 bg-emerald-500/10 text-emerald-100' : type === 'error' ? 'border-rose-500/40 bg-rose-500/10 text-rose-100' : 'border-cyan-500/40 bg-cyan-500/10 text-cyan-100'}">
        <div class="font-medium">${type === 'success' ? 'Success' : type === 'error' ? 'Error' : 'Notice'}</div>
        <div class="mt-1 text-sm/relaxed opacity-90">${message}</div>
    </div>
    `);

    $('#toast-container').append(toast);

    setTimeout(() => toast.addClass('opacity-0 transition-all duration-300'), 3200);
    setTimeout(() => toast.remove(), 3600);
}

function getToken() {
    return App.token || localStorage.getItem(AUTH_TOKEN_KEY);
}

function setToken(token, user) {
    App.token = token;
    App.user = user;
    localStorage.setItem(AUTH_TOKEN_KEY, token);
    localStorage.setItem(AUTH_USER_KEY, JSON.stringify(user));
    updateAuthState();
}

function clearAuth() {
    App.token = null;
    App.user = null;
    localStorage.removeItem(AUTH_TOKEN_KEY);
    localStorage.removeItem(AUTH_USER_KEY);
    updateAuthState();
}

function updateAuthState() {
    const token = getToken();
    const user = App.user;

    if (token && user) {
        $('#auth-menu-logged-in').removeClass('hidden');
        $('#auth-menu-logged-out').addClass('hidden');
        $('#user-label').text(user.name || 'Account');
        $('#admin-link').toggleClass('hidden', !user.is_admin);
    } else {
        $('#auth-menu-logged-in').addClass('hidden');
        $('#auth-menu-logged-out').removeClass('hidden');
        $('#admin-link').addClass('hidden');
    }
}

function api(url, options = {}) {
    const token = getToken();

    const settings = {
        url: url.startsWith('http') ? url : `/api${url}`,
        type: options.type || 'GET',
        data: options.data || undefined,
        contentType: options.contentType || 'application/json',
        dataType: options.dataType || 'json',
        beforeSend: (xhr) => {
            if (token) {
                xhr.setRequestHeader('Authorization', `Bearer ${token}`);
            }
        },
        error: (xhr) => {
            if (xhr.status === 401) {
                clearAuth();
                if (window.location.pathname !== '/login') {
                    window.location.href = '/login';
                }
            }

            if (options.onError) {
                options.onError(xhr);
            }
        },
        ...options,
    };

    return $.ajax(settings);
}

function setCart(items) {
    localStorage.setItem(CART_KEY, JSON.stringify(items));
    updateCartCount();
}

function getCart() {
    try {
        return JSON.parse(localStorage.getItem(CART_KEY) || '[]');
    } catch (error) {
        return [];
    }
}

function updateCartCount() {
    const cart = getCart();
    const count = cart.reduce((sum, item) => sum + Number(item.quantity || 0), 0);
    $('#cart-badge').text(count);
}

function loadUserSession() {
    const storedUser = JSON.parse(localStorage.getItem(AUTH_USER_KEY) || 'null');

    if (storedUser) {
        App.user = storedUser;
    }

    if (getToken()) {
        api('/user')
            .done((user) => {
                App.user = user;
                localStorage.setItem(AUTH_USER_KEY, JSON.stringify(user));
                updateAuthState();
            })
            .fail(() => {
                clearAuth();
            });
    } else {
        updateAuthState();
    }
}

function getPageName() {
    return $('body').data('page');
}

function initHomePage() {
    updateCartCount();
    const $search = $('#book-search');
    const $categoryFilter = $('#category-filter');
    const $authorFilter = $('#author-filter');
    const $sortFilter = $('#sort-filter');
    const $grid = $('#book-grid');
    const $pagination = $('#pagination');
    const $status = $('#book-list-status');
    let currentPage = 1;

    function renderSkeletons() {
        $grid.html(Array.from({ length: 6 }).map(() => `
            <div class="rounded-2xl border border-stone-200/80 bg-stone-50 p-4 animate-pulse">
                <div class="h-36 rounded-xl bg-stone-200"></div>
                <div class="mt-4 h-4 w-3/4 rounded bg-stone-200"></div>
                <div class="mt-2 h-3 w-1/2 rounded bg-stone-200"></div>
                <div class="mt-4 h-3 w-full rounded bg-stone-200"></div>
                <div class="mt-6 h-9 rounded-xl bg-stone-200"></div>
            </div>
        `).join(''));
    }

    function renderBooks(response) {
        $grid.empty();

        if (!response.data || response.data.length === 0) {
            $status.html('<div class="rounded-2xl border border-dashed border-stone-300 bg-white p-5 text-sm text-stone-600">No books match your current search. Try a different keyword or filter.</div>');
            $pagination.empty();
            return;
        }

        $status.empty();

        $grid.append(response.data.map((book) => {
            const authorName = book.author?.name || 'Unknown author';
            const categoryName = book.category?.name || 'General';
            const inStock = Number(book.stock_quantity || 0) > 0;

            return `
                <article class="group rounded-2xl border border-stone-200/80 bg-white p-4 shadow-sm shadow-stone-200/60 transition hover:-translate-y-0.5 hover:border-stone-300">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="rounded-full bg-blue-50 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.2em] text-blue-700">${categoryName}</p>
                            <h3 class="mt-3 text-lg font-semibold text-stone-900">${book.title}</h3>
                            <p class="mt-1 text-sm text-stone-600">by ${authorName}</p>
                        </div>
                        <div class="rounded-xl bg-stone-50 px-2.5 py-2 text-right">
                            <div class="text-base font-semibold text-stone-900">${formatCurrency(book.price)}</div>
                            <div class="text-[10px] uppercase tracking-[0.2em] text-stone-500">${inStock ? 'In stock' : 'Out of stock'}</div>
                        </div>
                    </div>

                    <p class="mt-4 line-clamp-3 text-sm text-stone-600">${book.description || 'A great addition to your reading list.'}</p>

                    <div class="mt-4 flex items-center justify-between text-xs text-stone-500">
                        <span>${book.author?.name || 'Author'} • ISBN ${book.isbn}</span>
                        <span>${book.stock_quantity} left</span>
                    </div>

                    <div class="mt-5 grid grid-cols-2 gap-2">
                        <button class="js-view-details rounded-xl border border-stone-300 bg-white px-3 py-2 text-sm font-medium text-stone-700" data-id="${book.id}">View details</button>
                        <button class="js-add-to-cart rounded-xl bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-500 disabled:cursor-not-allowed disabled:bg-stone-300 disabled:text-stone-500" data-id="${book.id}" ${!inStock ? 'disabled' : ''}>Add to cart</button>
                    </div>
                </article>
            `;
        }).join(''));

        $pagination.empty();
        if (response.last_page > 1) {
            for (let page = 1; page <= response.last_page; page++) {
                $pagination.append(`<button class="rounded-full border border-stone-300 px-3 py-1 text-sm ${page === response.current_page ? 'bg-blue-600 text-white' : 'bg-white text-stone-700'}" data-page="${page}">${page}</button>`);
            }
        }
    }

    function loadCatalog() {
        renderSkeletons();
        const params = {
            page: currentPage,
            search: $search.val(),
            category_id: $categoryFilter.val(),
            author_id: $authorFilter.val(),
            sort: $sortFilter.val(),
            per_page: 12,
        };

        api('/books', {
            type: 'GET',
            data: params,
        }).done((response) => {
            renderBooks(response);
        }).fail(() => {
            $status.html('<div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 p-6 text-rose-100">Unable to load books right now.</div>');
        });
    }

    function loadFilters() {
        $.when(
            api('/categories', { type: 'GET', data: { per_page: 100 } }),
            api('/authors', { type: 'GET', data: { per_page: 100 } })
        ).done((categoriesResponse, authorsResponse) => {
            const categories = categoriesResponse[0].data || [];
            const authors = authorsResponse[0].data || [];

            $categoryFilter.empty().append('<option value="">All categories</option>');
            $authorFilter.empty().append('<option value="">All authors</option>');

            categories.forEach((category) => $categoryFilter.append(`<option value="${category.id}">${category.name}</option>`));
            authors.forEach((author) => $authorFilter.append(`<option value="${author.id}">${author.name}</option>`));
        });
    }

    loadFilters();
    loadCatalog();

    $search.on('input', () => {
        currentPage = 1;
        loadCatalog();
    });

    $categoryFilter.on('change', () => {
        currentPage = 1;
        loadCatalog();
    });

    $authorFilter.on('change', () => {
        currentPage = 1;
        loadCatalog();
    });

    $sortFilter.on('change', () => {
        currentPage = 1;
        loadCatalog();
    });

    $pagination.on('click', 'button', function () {
        currentPage = Number($(this).data('page'));
        loadCatalog();
        $('html, body').animate({ scrollTop: $('#catalog-panel').offset().top - 30 }, 250);
    });

    $(document).on('click', '.js-add-to-cart', function () {
        const bookId = Number($(this).data('id'));
        const cart = getCart();
        const existing = cart.find((item) => item.id === bookId);

        api(`/books/${bookId}`)
            .done((book) => {
                if (Number(book.stock_quantity || 0) <= 0) {
                    showToast('error', 'This book is out of stock.');
                    return;
                }

                if (existing) {
                    existing.quantity = Math.min(Number(existing.quantity || 1) + 1, Number(book.stock_quantity || 1));
                } else {
                    cart.push({
                        id: book.id,
                        title: book.title,
                        price: Number(book.price),
                        quantity: 1,
                        author: book.author?.name || 'Unknown author',
                        stock_quantity: Number(book.stock_quantity || 0),
                    });
                }

                setCart(cart);
                showToast('success', `${book.title} added to cart.`);
            });
    });

    $(document).on('click', '.js-view-details', function () {
        const bookId = Number($(this).data('id'));

        api(`/books/${bookId}`)
            .done((book) => {
                $('#detail-modal-title').text(book.title);
                $('#detail-modal-author').text(book.author?.name || 'Unknown author');
                $('#detail-modal-category').text(book.category?.name || 'General');
                $('#detail-modal-price').text(formatCurrency(book.price));
                $('#detail-modal-stock').text(Number(book.stock_quantity || 0) > 0 ? 'In stock' : 'Out of stock');
                $('#detail-modal-description').text(book.description || 'No description available.');
                $('#detail-modal-add').data('id', book.id);
                $('#detail-modal').removeClass('hidden');
            });
    });

    $('#detail-modal-close').on('click', () => $('#detail-modal').addClass('hidden'));
    $('#detail-modal-overlay').on('click', () => $('#detail-modal').addClass('hidden'));

    $('#detail-modal-add').on('click', function () {
        const bookId = Number($(this).data('id'));
        $(`.js-add-to-cart[data-id="${bookId}"]`).trigger('click');
        $('#detail-modal').addClass('hidden');
    });
}

function initAuthPage() {
    if (getToken()) {
        window.location.href = '/';
    }

    $('#login-form').on('submit', function (event) {
        event.preventDefault();
        const formData = {
            email: $('#login-email').val(),
            password: $('#login-password').val(),
        };

        api('/login', {
            type: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
        }).done((response) => {
            setToken(response.token, response.user);
            showToast('success', 'Logged in successfully.');
            window.location.href = '/';
        }).fail((xhr) => {
            const message = xhr.responseJSON?.message || xhr.responseJSON?.errors?.email?.[0] || 'Login failed.';
            showToast('error', message);
        });
    });

    $('#register-form').on('submit', function (event) {
        event.preventDefault();
        const formData = {
            name: $('#register-name').val(),
            email: $('#register-email').val(),
            password: $('#register-password').val(),
            password_confirmation: $('#register-password-confirmation').val(),
            phone: $('#register-phone').val(),
            address: $('#register-address').val(),
        };

        api('/register', {
            type: 'POST',
            data: JSON.stringify(formData),
            contentType: 'application/json',
        }).done((response) => {
            setToken(response.token, response.user);
            showToast('success', 'Registration successful.');
            window.location.href = '/';
        }).fail((xhr) => {
            const message = xhr.responseJSON?.message || Object.values(xhr.responseJSON?.errors || {}).flat()[0] || 'Registration failed.';
            showToast('error', message);
        });
    });
}

function initProfilePage() {
    if (!getToken()) {
        window.location.href = '/login';
        return;
    }

    api('/user')
        .done((user) => {
            $('#profile-name').val(user.name || '');
            $('#profile-email').val(user.email || '');
            $('#profile-phone').val(user.phone || '');
            $('#profile-address').val(user.address || '');
            $('#profile-summary-name').text(user.name || 'Customer');
            $('#profile-summary-email').text(user.email || '');
            $('#profile-summary-role').text(user.is_admin ? 'Admin' : 'Customer');
        });

    api('/orders')
        .done((response) => {
            const orders = response.data || [];
            $('#profile-recent-orders').empty();

            if (orders.length === 0) {
                $('#profile-recent-orders').append('<div class="rounded-2xl border border-stone-200/80 bg-stone-50 p-4 text-sm text-stone-600">No orders yet. Start shopping to see your recent purchases.</div>');
                return;
            }

            $('#profile-recent-orders').append(orders.slice(0, 3).map((order) => `
                <div class="rounded-2xl border border-stone-200/80 bg-stone-50 p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-stone-900">Order #${order.id}</p>
                            <p class="text-xs text-stone-500">${new Date(order.order_date).toLocaleDateString()}</p>
                        </div>
                        <span class="rounded-full bg-blue-50 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.2em] text-blue-700">${order.status}</span>
                    </div>
                    <p class="mt-3 text-sm text-stone-600">${order.order_items?.length || 0} items • ${formatCurrency(order.total_amount)}</p>
                </div>
            `).join(''));
        });

    $('#profile-form').on('submit', function (event) {
        event.preventDefault();
        const payload = {
            name: $('#profile-name').val(),
            email: $('#profile-email').val(),
            phone: $('#profile-phone').val(),
            address: $('#profile-address').val(),
        };

        api('/profile', {
            type: 'PATCH',
            data: JSON.stringify(payload),
            contentType: 'application/json',
        }).done((user) => {
            App.user = user;
            localStorage.setItem(AUTH_USER_KEY, JSON.stringify(user));
            showToast('success', 'Profile updated successfully.');
        }).fail((xhr) => {
            showToast('error', xhr.responseJSON?.message || 'Unable to update profile.');
        });
    });

    $('#password-form').on('submit', function (event) {
        event.preventDefault();
        const payload = {
            current_password: $('#current-password').val(),
            password: $('#new-password').val(),
            password_confirmation: $('#new-password-confirmation').val(),
        };

        api('/profile/password', {
            type: 'POST',
            data: JSON.stringify(payload),
            contentType: 'application/json',
        }).done(() => {
            $('#password-form')[0].reset();
            showToast('success', 'Password updated successfully.');
        }).fail((xhr) => {
            showToast('error', xhr.responseJSON?.message || 'Unable to update password.');
        });
    });
}

function initCartPage() {
    updateCartCount();
    const $items = $('#cart-items');
    const $summary = $('#cart-summary');

    function render() {
        const cart = getCart();

        if (cart.length === 0) {
            $items.html('<div class="rounded-2xl border border-dashed border-stone-300 bg-white p-6 text-center text-sm text-stone-600">Your cart is empty. Browse books and add your favorites.</div>');
            $summary.html('<div class="rounded-2xl border border-stone-200/80 bg-white p-4 text-sm text-stone-600">Your cart is empty.</div>');
            return;
        }

        const total = cart.reduce((sum, item) => sum + (Number(item.price) * Number(item.quantity)), 0);

        $items.empty().append(cart.map((item) => `
            <div class="rounded-2xl border border-stone-200/80 bg-white p-4">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="text-lg font-semibold text-stone-900">${item.title}</p>
                        <p class="mt-1 text-sm text-stone-600">by ${item.author}</p>
                        <p class="mt-2 text-sm text-blue-700">${formatCurrency(item.price)} each</p>
                    </div>

                    <div class="flex items-center gap-3">
                        <button class="js-decrease-cart rounded-full border border-stone-300 px-3 py-1 text-stone-700" data-id="${item.id}">−</button>
                        <span class="min-w-10 text-center text-stone-900">${item.quantity}</span>
                        <button class="js-increase-cart rounded-full border border-stone-300 px-3 py-1 text-stone-700" data-id="${item.id}">+</button>
                        <button class="js-remove-cart rounded-full bg-rose-50 px-3 py-1 text-sm font-medium text-rose-700" data-id="${item.id}">Remove</button>
                    </div>
                </div>
            </div>
        `).join(''));

        $summary.html(`
            <div class="rounded-2xl border border-stone-200/80 bg-white p-4">
                <div class="flex items-center justify-between text-stone-600">
                    <span>Subtotal</span>
                    <span>${formatCurrency(total)}</span>
                </div>
                <div class="mt-3 flex items-center justify-between text-stone-600">
                    <span>Shipping</span>
                    <span>${formatCurrency(0)}</span>
                </div>
                <div class="mt-4 border-t border-stone-200 pt-4 flex items-center justify-between text-lg font-semibold text-stone-900">
                    <span>Total</span>
                    <span>${formatCurrency(total)}</span>
                </div>
                <button id="checkout-button" class="mt-5 w-full rounded-xl bg-blue-600 px-4 py-2.5 font-semibold text-white">Place order</button>
            </div>
        `);
    }

    render();

    $(document).on('click', '.js-increase-cart', function () {
        const bookId = Number($(this).data('id'));
        const cart = getCart();
        const item = cart.find((entry) => entry.id === bookId);

        if (item) {
            item.quantity = Math.min(Number(item.quantity) + 1, Number(item.stock_quantity || 1));
            setCart(cart);
            render();
        }
    });

    $(document).on('click', '.js-decrease-cart', function () {
        const bookId = Number($(this).data('id'));
        const cart = getCart();
        const item = cart.find((entry) => entry.id === bookId);

        if (item) {
            item.quantity = Math.max(Number(item.quantity) - 1, 1);
            setCart(cart);
            render();
        }
    });

    $(document).on('click', '.js-remove-cart', function () {
        const bookId = Number($(this).data('id'));
        const filtered = getCart().filter((entry) => entry.id !== bookId);
        setCart(filtered);
        render();
    });

    $(document).on('click', '#checkout-button', function () {
        if (!getToken()) {
            showToast('error', 'Please log in to place an order.');
            window.location.href = '/login';
            return;
        }

        const cart = getCart();
        const total = cart.reduce((sum, item) => sum + Number(item.price) * Number(item.quantity), 0);

        api('/user')
            .done((user) => {
                const payload = {
                    user_id: user.id,
                    total_amount: total,
                    order_date: new Date().toISOString(),
                    status: 'pending',
                    order_items: cart.map((item) => ({
                        book_id: item.id,
                        quantity: item.quantity,
                        price: item.price,
                    })),
                };

                api('/orders', {
                    type: 'POST',
                    data: JSON.stringify(payload),
                    contentType: 'application/json',
                }).done(() => {
                    setCart([]);
                    render();
                    showToast('success', 'Order placed successfully!');
                    window.location.href = '/orders';
                }).fail((xhr) => {
                    showToast('error', xhr.responseJSON?.message || 'Unable to place order.');
                });
            });
    });
}

function initOrdersPage() {
    if (!getToken()) {
        window.location.href = '/login';
        return;
    }

    api('/orders')
        .done((response) => {
            const orders = response.data || [];
            $('#orders-list').empty();

            if (orders.length === 0) {
                $('#orders-list').append('<div class="rounded-2xl border border-dashed border-stone-300 bg-white p-6 text-sm text-stone-600">You have not placed any orders yet.</div>');
                return;
            }

            $('#orders-list').append(orders.map((order) => `
                <article class="rounded-2xl border border-stone-200/80 bg-white p-4">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-lg font-semibold text-stone-900">Order #${order.id}</p>
                            <p class="text-sm text-stone-500">${new Date(order.order_date).toLocaleString()}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-blue-700">${order.status}</span>
                            <span class="rounded-full bg-stone-100 px-3 py-1 text-xs font-semibold text-stone-700">${formatCurrency(order.total_amount)}</span>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2">
                        ${(order.order_items || []).map((item) => `
                            <div class="flex items-center justify-between rounded-xl bg-stone-50 px-3 py-2 text-sm text-stone-700">
                                <span>${item.book?.title || 'Book'} × ${item.quantity}</span>
                                <span>${formatCurrency(item.price * item.quantity)}</span>
                            </div>
                        `).join('')}
                    </div>
                </article>
            `).join(''));
        });
}

function initAdminPage() {
    if (!getToken()) {
        window.location.href = '/login';
        return;
    }

    api('/user')
        .done((user) => {
            if (!user.is_admin) {
                window.location.href = '/';
                return;
            }

            $('#admin-title').text(`Admin dashboard • ${user.name}`);
            loadAdminDashboard();
        });

    function loadAdminDashboard() {
        api('/admin/analytics')
            .done((data) => {
                $('#stats-books').text(data.summary.books);
                $('#stats-orders').text(data.summary.orders);
                $('#stats-revenue').text(formatCurrency(data.summary.revenue));
                $('#stats-pending').text(data.summary.pending_orders);

                $('#status-breakdown').empty().append(Object.entries(data.status_breakdown || {}).map(([status, total]) => `
                    <div class="rounded-xl bg-stone-50 px-3 py-2 text-sm text-stone-700">${status}: ${total}</div>
                `).join(''));

                $('#recent-orders').empty().append((data.recent_orders || []).map((order) => `
                    <div class="rounded-2xl border border-stone-200/80 bg-white p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-stone-900">Order #${order.id}</p>
                                <p class="text-xs text-stone-500">${order.user?.name || 'Customer'} • ${new Date(order.order_date).toLocaleString()}</p>
                            </div>
                            <span class="rounded-full bg-blue-50 px-2.5 py-1 text-[10px] font-semibold uppercase tracking-[0.2em] text-blue-700">${order.status}</span>
                        </div>
                    </div>
                `).join(''));
            });

        loadAdminBooks();
        loadAdminAuthors();
        loadAdminOrders();
    }

    function loadAdminBooks() {
        api('/books', { type: 'GET', data: { per_page: 100 } })
            .done((response) => {
                $('#admin-books-body').empty().append((response.data || []).map((book) => `
                    <tr class="border-b border-stone-200/80">
                        <td class="px-3 py-2.5 text-sm text-stone-900">${book.title}</td>
                        <td class="px-3 py-2.5 text-sm text-stone-600">${book.author?.name || 'Unknown'}</td>
                        <td class="px-3 py-2.5 text-sm text-stone-600">${book.category?.name || 'General'}</td>
                        <td class="px-3 py-2.5 text-sm text-stone-600">${book.stock_quantity}</td>
                        <td class="px-3 py-2.5 text-sm text-stone-600">${formatCurrency(book.price)}</td>
                        <td class="px-3 py-2.5 text-right text-sm">
                            <button class="js-edit-book rounded-full bg-stone-100 px-3 py-1 text-stone-700" data-id="${book.id}">Edit</button>
                            <button class="js-delete-book rounded-full bg-rose-50 px-3 py-1 text-rose-700" data-id="${book.id}">Delete</button>
                        </td>
                    </tr>
                `).join(''));
            });
    }

    function loadAdminAuthors() {
        api('/authors', { type: 'GET', data: { per_page: 100 } })
            .done((response) => {
                $('#admin-authors-body').empty().append((response.data || []).map((author) => `
                    <tr class="border-b border-stone-200/80">
                        <td class="px-3 py-2.5 text-sm text-stone-900">${author.name}</td>
                        <td class="px-3 py-2.5 text-sm text-stone-600">${author.bio || '—'}</td>
                        <td class="px-3 py-2.5 text-right text-sm">
                            <button class="js-edit-author rounded-full bg-stone-100 px-3 py-1 text-stone-700" data-id="${author.id}">Edit</button>
                            <button class="js-delete-author rounded-full bg-rose-50 px-3 py-1 text-rose-700" data-id="${author.id}">Delete</button>
                        </td>
                    </tr>
                `).join(''));
            });
    }

    function loadAdminOrders() {
        api('/orders', { type: 'GET', data: { per_page: 100 } })
            .done((response) => {
                $('#admin-orders-body').empty().append((response.data || []).map((order) => `
                    <tr class="border-b border-stone-200/80">
                        <td class="px-3 py-2.5 text-sm text-stone-900">#${order.id}</td>
                        <td class="px-3 py-2.5 text-sm text-stone-600">${order.user?.name || 'Customer'}</td>
                        <td class="px-3 py-2.5 text-sm text-stone-600">${formatCurrency(order.total_amount)}</td>
                        <td class="px-3 py-2.5 text-sm">
                            <select class="status-select rounded-xl border border-stone-300 bg-white px-2 py-1 text-sm text-stone-700" data-order-id="${order.id}">
                                <option value="pending" ${order.status === 'pending' ? 'selected' : ''}>Pending</option>
                                <option value="processing" ${order.status === 'processing' ? 'selected' : ''}>Processing</option>
                                <option value="shipped" ${order.status === 'shipped' ? 'selected' : ''}>Shipped</option>
                                <option value="delivered" ${order.status === 'delivered' ? 'selected' : ''}>Delivered</option>
                                <option value="cancelled" ${order.status === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                            </select>
                        </td>
                    </tr>
                `).join(''));
            });
    }

    $('#book-form').on('submit', function (event) {
        event.preventDefault();
        const formData = {
            title: $('#book-title').val(),
            author_id: $('#book-author').val(),
            category_id: $('#book-category').val(),
            isbn: $('#book-isbn').val(),
            price: $('#book-price').val(),
            stock_quantity: $('#book-stock').val(),
            description: $('#book-description').val(),
            published_date: $('#book-date').val(),
        };

        const bookId = $('#book-id').val();
        const request = bookId ? api(`/books/${bookId}`, { type: 'PUT', data: JSON.stringify(formData), contentType: 'application/json' }) : api('/books', { type: 'POST', data: JSON.stringify(formData), contentType: 'application/json' });

        request.done(() => {
            $('#book-form')[0].reset();
            $('#book-id').val('');
            loadAdminBooks();
            showToast('success', bookId ? 'Book updated.' : 'Book created.');
        }).fail((xhr) => {
            showToast('error', xhr.responseJSON?.message || 'Unable to save book.');
        });
    });

    $('#author-form').on('submit', function (event) {
        event.preventDefault();
        const formData = {
            name: $('#author-name').val(),
            bio: $('#author-bio').val(),
            birth_date: $('#author-birth-date').val(),
        };

        const authorId = $('#author-id').val();
        const request = authorId ? api(`/authors/${authorId}`, { type: 'PUT', data: JSON.stringify(formData), contentType: 'application/json' }) : api('/authors', { type: 'POST', data: JSON.stringify(formData), contentType: 'application/json' });

        request.done(() => {
            $('#author-form')[0].reset();
            $('#author-id').val('');
            loadAdminAuthors();
            showToast('success', authorId ? 'Author updated.' : 'Author created.');
        }).fail((xhr) => {
            showToast('error', xhr.responseJSON?.message || 'Unable to save author.');
        });
    });

    $(document).on('click', '.js-edit-book', function () {
        const bookId = Number($(this).data('id'));
        api(`/books/${bookId}`)
            .done((book) => {
                $('#book-id').val(book.id);
                $('#book-title').val(book.title);
                $('#book-author').val(book.author_id);
                $('#book-category').val(book.category_id);
                $('#book-isbn').val(book.isbn);
                $('#book-price').val(book.price);
                $('#book-stock').val(book.stock_quantity);
                $('#book-description').val(book.description || '');
                $('#book-date').val(book.published_date);
                $('#book-book-tab').trigger('click');
            });
    });

    $(document).on('click', '.js-delete-book', function () {
        const bookId = Number($(this).data('id'));
        if (!window.confirm('Delete this book?')) {
            return;
        }

        api(`/books/${bookId}`, { type: 'DELETE' })
            .done(() => {
                loadAdminBooks();
                showToast('success', 'Book deleted.');
            });
    });

    $(document).on('click', '.js-edit-author', function () {
        const authorId = Number($(this).data('id'));
        api(`/authors/${authorId}`)
            .done((author) => {
                $('#author-id').val(author.id);
                $('#author-name').val(author.name);
                $('#author-bio').val(author.bio || '');
                $('#author-birth-date').val(author.birth_date || '');
                $('#author-author-tab').trigger('click');
            });
    });

    $(document).on('click', '.js-delete-author', function () {
        const authorId = Number($(this).data('id'));
        if (!window.confirm('Delete this author?')) {
            return;
        }

        api(`/authors/${authorId}`, { type: 'DELETE' })
            .done(() => {
                loadAdminAuthors();
                showToast('success', 'Author deleted.');
            });
    });

    $(document).on('change', '.status-select', function () {
        const orderId = Number($(this).data('order-id'));
        const status = $(this).val();

        api(`/orders/${orderId}`, {
            type: 'PATCH',
            data: JSON.stringify({ status }),
            contentType: 'application/json',
        }).done(() => {
            loadAdminOrders();
            showToast('success', 'Order status updated.');
        });
    });

    $('#book-author').empty();
    $('#book-category').empty();

    $.when(
        api('/authors', { type: 'GET', data: { per_page: 100 } }),
        api('/categories', { type: 'GET', data: { per_page: 100 } })
    ).done((authorsResponse, categoriesResponse) => {
        const authors = authorsResponse[0].data || [];
        const categories = categoriesResponse[0].data || [];

        $('#book-author').append(authors.map((author) => `<option value="${author.id}">${author.name}</option>`).join(''));
        $('#book-category').append(categories.map((category) => `<option value="${category.id}">${category.name}</option>`).join(''));
    });
}

$(function () {
    updateAuthState();
    loadUserSession();
    updateCartCount();

    const page = getPageName();

    if (page === 'home') {
        initHomePage();
    }

    if (page === 'auth') {
        initAuthPage();
    }

    if (page === 'profile') {
        initProfilePage();
    }

    if (page === 'cart') {
        initCartPage();
    }

    if (page === 'orders') {
        initOrdersPage();
    }

    if (page === 'admin') {
        initAdminPage();
    }

    $('#logout-button').on('click', function (event) {
        event.preventDefault();

        api('/logout', {
            type: 'POST',
        }).always(() => {
            clearAuth();
            window.location.href = '/login';
        });
    });
});

