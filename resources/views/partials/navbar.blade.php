{{-- resources/views/partials/navbar.blade.php --}}
<nav class="bg-white border-b-[3px] border-gold shadow-sm sticky top-0 z-50">
    <div class="flex items-center justify-between px-6 md:px-[100px]">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="flex items-center gap-3 no-underline animate-slide-r">
            <img src="{{ asset('img/nceeic-logo.png') }}" alt="NCEEIC Logo" class="h-[100px]">
        </a>

        {{-- Desktop nav --}}
        <div class="hidden lg:flex items-center animate-fade-in delay-150">
            <a href="{{ url('/') }}"
               class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                Home
                {{-- <i class="ti ti-chevron-down text-[11px] text-muted"></i> --}}
            </a>
            <a href="{{ url('/#about') }}" class="nav-link">
                About
                {{-- <i class="ti ti-chevron-down text-[11px] text-muted"></i> --}}
            </a>
            {{-- <a href="{{ url('/#mandate') }}" class="nav-link">
                Mandate <i class="ti ti-chevron-down text-[11px] text-muted"></i>
            </a>
            <a href="{{ url('/#portal') }}" class="nav-link">
                Programmes <i class="ti ti-chevron-down text-[11px] text-muted"></i>
            </a>
            <a href="#" class="nav-link">Publications</a> --}}
            <a href="{{ url('/#news') }}" class="nav-link">News</a>
            <a href="{{ url('/#footer') }}" class="nav-link">Contact</a>

            <a href="{{ url('/portal/dashboard') }}" class="nav-cta ml-4">
                <i class="ti ti-file-certificate"></i> Grant Portal
            </a>
        </div>

        {{-- Mobile hamburger --}}
        <button data-collapse-toggle="mobile-menu" type="button"
                class="lg:hidden inline-flex items-center p-2 text-dark-green rounded-lg hover:bg-gray-100 focus:outline-none"
                aria-controls="mobile-menu" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <i class="ti ti-menu-2 text-2xl"></i>
        </button>
    </div>

    {{-- Mobile menu --}}
    <div class="hidden lg:hidden" id="mobile-menu">
        <ul class="flex flex-col px-4 pb-4 pt-2 gap-1 font-medium border-t border-gray-100">
            <li><a href="{{ url('/') }}" class="block py-2 px-3 text-dark-green rounded hover:bg-offwhite">Home</a></li>
            <li><a href="{{ url('/#about') }}" class="block py-2 px-3 text-dark-green rounded hover:bg-offwhite">About</a></li>
            <li><a href="{{ url('/#news') }}" class="block py-2 px-3 text-dark-green rounded hover:bg-offwhite">News</a></li>
            <li><a href="{{ url('/#footer') }}" class="block py-2 px-3 text-dark-green rounded hover:bg-offwhite">Contact</a></li>
            <li class="pt-2">
                <a href="{{ url('/portal/dashboard') }}" class="nav-cta w-full justify-center">
                    <i class="ti ti-file-certificate"></i> Grant Portal
                </a>
            </li>
        </ul>
    </div>
</nav>
