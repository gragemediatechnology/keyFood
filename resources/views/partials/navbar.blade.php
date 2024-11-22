<header class="header-nav">
    <nav class="nav container-nav py-5">
        <div class="nav__data">
            <a href="#" class="nav__logo">
                @foreach($cms as $company)
                    <img src="https://teraskabeka.com/{{ $company->logo }}" class="h-8 me-2" alt="KeyFood Logo" loading="lazy"/> {{$company->company_name}}
                @endforeach
            </a>


            <div class="nav__toggle" id="nav-toggle">
                <i class="ri-menu-line nav__toggle-menu"></i>
                <i class="ri-close-line nav__toggle-close"></i>
            </div>



            <!--=============== NAV MENU ===============-->
            <div class="nav__menu" id="nav-menu">
                <ul class="nav__list">
                    <li class="list">
                        <a href="/home"
                            class="{{ Request::is('/') || Request::is('home') ? 'nav__link active' : 'nav__link' }}">Home</a>
                    </li>
                    <li class="list">
                        <a href="/product-slider"
                            class="{{ Request::is('product-slider') ? 'nav__link active' : 'nav__link' }}">Produk</a>
                    </li>
                    <li class="list">
                        <a href="/stores"
                            class="{{ Request::is('stores') ? 'nav__link active' : 'nav__link' }}">Toko</a>
                    </li>
                    <li class="list">
                        <a href="/categories"
                            class="{{ Request::is('categories') ? 'nav__link active' : 'nav__link' }}">Kategori</a>
                    </li>
                    <li class="list">
                        <a href="/history"
                            class="{{ Request::is('history') ? 'nav__link active' : 'nav__link' }}">Histori</a>
                    </li>
                </ul>
            </div>

            <div class="profile-dropdown">
            </div>
        </div>
    </nav>
</header>
