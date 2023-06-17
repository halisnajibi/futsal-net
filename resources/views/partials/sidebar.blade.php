<div class="dlabnav">
    <div class="dlabnav-scroll">
        @if (Auth::user()->is_admin == 1)
        <ul class="navbar-nav metismenu" id="menu">
            <li class="nav-item  dropdown header-profile">
                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                    <img src="{{ asset('storage/'.Auth::user()->foto) }}" width="20" alt="" />
                    <div class="header-info ms-3">
                        <span class="font-w600 ">Hi,<b>{{ Auth::user()->nama }}</b></span>
                        <small class="text-end font-w400">{{ Auth::user()->email }}</small>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="./app-profile.html" class="dropdown-item ai-icon">
                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary"
                            width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span class="ms-2">Profile </span>
                    </a>
                    <a href="./email-inbox.html" class="dropdown-item ai-icon">
                        <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success"
                            width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                            </path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <span class="ms-2">Inbox </span>
                    </a>
                    <a href="/logout" class="dropdown-item ai-icon">
                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger"
                            width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span class="ms-2">Logout </span>
                    </a>
                </div>
            </li>
            <li class="nav-item">
                <a href="/dashboard" aria-expanded="false" class="nav-link">
                    <i class="fa-solid fa-house"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item"><a class="has-arrow ai-icon nav-link active" href="javascript:void()" aria-expanded="false">
                <i class="fa-solid fa-gears"></i>
                    <span class="nav-text ">Master Data</span>
                </a>
                <ul aria-expanded="false">
                    <li><a  href="/admin/users">User</a></li>
                    <li><a href="/admin/lapangans" >Lapangan</a></li>
                    <li><a href="/admin/kategoris">Kategori</a></li>
                </ul>
            </li>
            <li class="nav-item"><a class=" nav-link active" href="/admin/jams" >
                <i class="fa-solid fa-clock"></i>
                    <span class="nav-text ">Data Jam</span>
                </a>
            </li>
            <li class="nav-item"><a href="/admin/tarifs" class="nav-link" >
                <i class="fa-solid fa-clipboard-list"></i>
                    <span class="nav-text">Tarif Lapangan</span>
                </a>
            </li>
            <li class="nav-item"><a href="/rental" class="nav-link" >
                <i class="fa-solid fa-book"></i>
                    <span class="nav-text">Transaksi Rental</span>
                </a>
            </li>
        </ul>
        @else
        <ul class="navbar-nav metismenu" id="menu">
            <li class="nav-item  dropdown header-profile">
                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                    <img src="{{ asset('storage/'.Auth::user()->foto) }}" width="20" alt="" />
                    <div class="header-info ms-3">
                        @php
                           $nama = explode(" ", Auth::user()->nama);
                        @endphp
                        <span class="font-w600 ">Hi,<b>{{ trim($nama[0]) }}</b></span>
                        <small class="text-end font-w400">{{ Auth::user()->email }}</small>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="/profiel" class="dropdown-item ai-icon">
                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary"
                            width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span class="ms-2">Profile </span>
                    </a>
                    <a href="./email-inbox.html" class="dropdown-item ai-icon">
                        <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success"
                            width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                            </path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <span class="ms-2">Inbox </span>
                    </a>
                    <a href="/logout" class="dropdown-item ai-icon">
                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger"
                            width="18" height="18" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span class="ms-2">Logout </span>
                    </a>
                </div>
            </li>
            <li class="nav-item">
                <a href="/dashboard" aria-expanded="false" class="nav-link">
                    <i class="fa-solid fa-house"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item"><a href="/member/hargas" class="nav-link" >
                <i class="fa-solid fa-dollar-sign me-2"></i>
                    <span class="nav-text">List Harga</span>
                </a>
            </li>
            <li class="nav-item"><a href="/member/lapangans" class="nav-link" >
                <i class="fa-solid fa-basket-shopping"></i>
                    <span class="nav-text">Pesan Lapangan</span>
                </a>
            </li>
            <li class="nav-item"><a href="/member/transaksi" class="nav-link" >
                <i class="fa-solid fa-book"></i>
                    <span class="nav-text">Transaksi Rental</span>
                </a>
            </li>
        </ul>
        @endif
    </div>
</div>