<nav class="sidebar close">
    <header>
        <div class="image-text">
            <span class="image">
                <img src="{{ asset(Auth::user()->img ?? './img/client-1.jpg') }}" alt="logo" loading="lazy">
            </span>

            <div class="text-header-text">
                @if (Auth::check())
                    <span class="name">
                        <div>
                            {{ strlen(Auth::user()->name) > 16 ? substr(Auth::user()->name, 0, 16) . '...' : Auth::user()->name }}
                        </div>
                    </span>
                    <span class="email">
                        <div>
                            {{ strlen(Auth::user()->email) > 16 ? substr(Auth::user()->email, 0, 16) . '...' : Auth::user()->email }}
                        </div>
                    </span>
                @else
                    <span class="email">
                        <a href="/log-reg">
                            <button type="button"
                                class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:focus:ring-cyan-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Login</button>
                        </a>
                    </span>
                @endif
            </div>
        </div>
        </div>

        <i class="bx bx-chevron-left toggle"></i>
    </header>
    <div class="menu-bar">
        <div class="menu">


            <li class="search-box">
                <i class="bx bx-search icon"></i>
                <input type="search" placeholder="Search..">
            </li>

            <ul class="menu-links">
                @if (Auth::check())
                    @if (Auth::user()->hasRole('admin'))
                        <li class="{{ Request::is('admin.products.index') ? 'nav-link active' : 'nav-link' }}">
                            {{-- <a href="{{ route('admin.products.index') }}"> --}}
                            <a href="/admin/products/index">
                                <i class='bx bx-restaurant icon'></i>
                                <span class="text nav-text">Produk</span>
                            </a>
                        </li>

                        <li class="{{ Request::is('admin.products_orders.index') ? 'nav-link active' : 'nav-link' }}">
                            {{-- <a href="{{ route('admin.products_orders.index') }}"> --}}
                            <a href="/admin/products_orders/index">
                                <i class='bx bx-store icon'></i>
                                <span class="text nav-text">Toko</span>
                            </a>
                        </li>

                        <li class="{{ Request::is('admin.categories.index') ? 'nav-link active' : 'nav-link' }}">
                            {{-- <a href="{{ route('admin.categories.index') }}"> --}}
                            <a href="/admin/categories/index">
                                <i class='bx bx-bowl-hot icon'></i>
                                <span class="text nav-text">Kategori</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="#" onclick="openProfile()">
                                <i class='bx bx-user icon'></i>
                                <span class="text nav-text">My Profile</span>
                            </a>
                        </li>
                    @elseif (Auth::user()->hasRole('seller'))
                        <li class="{{ Request::is('store-sell') ? 'nav-link active' : 'nav-link' }}">
                            <a href="/seller/seller-edit">
                                <i class='bx bx-store icon'></i>
                                <span class="text nav-text">Toko</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="#" onclick="openProfile()">
                                <i class='bx bx-user icon'></i>
                                <span class="text nav-text">My Profile</span>
                            </a>
                        </li>
                    @else
                    <li class="{{ Request::is('home') ? 'nav-link active' : 'nav-link' }}">
                        <a href="/home">
                            <i class="bx bx-home-alt icon"></i>
                            <span class="text nav-text">Home</span>
                        </a>
                        <li class="{{ Request::is('product-slider') ? 'nav-link active' : 'nav-link' }}">
                            <a href="/product-slider">
                                <i class="bx bx-restaurant icon"></i>
                                <span class="text nav-text">Produk</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('stores') ? 'nav-link active' : 'nav-link' }}">
                            <a href="/stores">
                                <i class='bx bx-store icon'></i>
                                <span class="text nav-text">Toko</span>
                            </a>
                        </li>

                        <li class="{{ Request::is('categories') ? 'nav-link active' : 'nav-link' }}">
                            <a href="/categories">
                                <i class='bx bx-bowl-hot icon'></i>
                                <span class="text nav-text">Kategori</span>
                            </a>
                        </li>
                        <li class="{{ Request::is('history') ? 'nav-link active' : 'nav-link' }}">
                            <a href="/history">
                                <i class='bx bx-history icon'></i>
                                <span class="text nav-text">Riwayat</span>
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="#" onclick="openProfile()">
                                <i class='bx bx-user icon'></i>
                                <span class="text nav-text">My Profile</span>
                            </a>
                        </li>
                    @endif
                @else
                    <li class="{{ Request::is('home') ? 'nav-link active' : 'nav-link' }}">
                        <a href="/home">
                            <i class="bx bx-home-alt icon"></i>
                            <span class="text nav-text">Home</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('product-slider') ? 'nav-link active' : 'nav-link' }}">
                        <a href="/product-slider">
                            <i class="bx bx-restaurant icon"></i>
                            <span class="text nav-text">Produk</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('stores') ? 'nav-link active' : 'nav-link' }}">
                        <a href="/stores">
                            <i class='bx bx-store icon'></i>
                            <span class="text nav-text">Toko</span>
                        </a>
                    </li>

                    <li class="{{ Request::is('categories') ? 'nav-link active' : 'nav-link' }}">
                        <a href="/categories">
                            <i class='bx bx-bowl-hot icon'></i>
                            <span class="text nav-text">Kategori</span>
                        </a>
                    </li>
                @endif
            </ul>

        </div>

        @if (Auth::check())
            <div class="bottom-content">
                <li class="logout">
                    <form method="POST" action="{{ route('logout') }}" style="display: flex">
                        @csrf
                        <a href="/logout"
                            onclick="event.preventDefault();
                this.closest('form').submit();">
                            <i class="bx bx-log-out icon"></i>
                            <span class="text nav-text">Logout</span>
                        </a>
                    </form>
                </li>
            @else
                <div class="hidden">
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="display: flex">
                            @csrf
                            <a href="/logout"
                                onclick="event.preventDefault();
                this.closest('form').submit();">
                                <i class="bx bx-log-out icon"></i>
                                <span class="text nav-text">Logout</span>
                            </a>
                        </form>
                    </li>
                </div>
        @endif


        <li class="mode">
            <div class="moon-sun">
                <i class="bx bx-moon icon moon"></i>
                <i class="bx bx-sun icon sun"></i>
            </div>
            <span class="mode-text text">Dark Mode</span>
            <div class="toggle-switch">
                <span class="switch"></span>
            </div>
        </li>
    </div>
    </div>
</nav>
