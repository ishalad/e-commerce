<div class="aiz-sidebar-wrap">
    <div class="aiz-sidebar left c-scrollbar">
        <div class="aiz-side-nav-logo-wrap">
            <div class="d-block text-center my-3">
                @if (optional(Auth::user()->shop)->logo != null)
                    <img class="mw-100 mb-3" src="{{ uploaded_asset(optional(Auth::user()->shop)->logo) }}"
                        class="brand-icon" alt="{{ get_setting('site_name') }}">
                @else
                    <img class="mw-100 mb-3" src="{{ uploaded_asset(get_setting('header_logo')) }}" class="brand-icon"
                        alt="{{ get_setting('site_name') }}">
                @endif
                <h3 class="fs-16  m-0 text-primary">{{ Auth::user()->name }}</h3>
                <p class="text-primary">{{ Auth::user()->email }}</p>
            </div>
        </div> 
        @php $user = auth()->user(); @endphp
        @if ($user->user_type == 'super_dealer')
            <div class="aiz-side-nav-wrap">
                <div class="px-20px mb-3">
                    <input class="form-control bg-soft-secondary border-0 form-control-sm" type="text" name=""
                        placeholder="{{ translate('Search in menu') }}" id="menu-search" onkeyup="menuSearch()">
                </div>
                <ul class="aiz-side-nav-list" id="search-menu">
                </ul>
                <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('superdealer.dashboard') }}" class="aiz-side-nav-link">
                            <i class="las la-home aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Dashboard') }}</span>
                        </a>
                    </li>
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('superdealer.dealer.index') }}"
                            class="aiz-side-nav-link {{ areActiveRoutes(['superdealer.dealer.index']) }}">
                            <i class="las la-money-bill aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Dealer') }}</span>
                        </a>
                    </li>
                </ul><!-- .aiz-side-nav -->
            </div><!-- .aiz-side-nav-wrap -->
        @elseif ($user->user_type == 'dealer')
            <div class="aiz-side-nav-wrap">
                <div class="px-20px mb-3">
                    <input class="form-control bg-soft-secondary border-0 form-control-sm" type="text" name=""
                        placeholder="{{ translate('Search in menu') }}" id="menu-search" onkeyup="menuSearch()">
                </div>
                <ul class="aiz-side-nav-list" id="search-menu">
                </ul>
                <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('superdealer.dashboard') }}" class="aiz-side-nav-link">
                            <i class="las la-home aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Dashboard') }}</span>
                        </a>
                    </li>
                    <li class="aiz-side-nav-item">
                        <a href="{{ route('dealer.sellers.index') }}"
                            class="aiz-side-nav-link {{ areActiveRoutes(['dealer.sellers.index','dealer.sellers.show']) }}">
                            <i class="las la-money-bill aiz-side-nav-icon"></i>
                            <span class="aiz-side-nav-text">{{ translate('Sellers') }}</span>
                        </a>
                    </li>
                </ul><!-- .aiz-side-nav -->
            </div><!-- .aiz-side-nav-wrap -->
        @elseif ($user->user_type == 'influencer')
        <div class="aiz-side-nav-wrap">
            <div class="px-20px mb-3">
                <input class="form-control bg-soft-secondary border-0 form-control-sm" type="text" name=""
                    placeholder="{{ translate('Search in menu') }}" id="menu-search" onkeyup="menuSearch()">
            </div>
            <ul class="aiz-side-nav-list" id="search-menu">
            </ul>
            <ul class="aiz-side-nav-list" id="main-menu" data-toggle="aiz-side-menu">
                <li class="aiz-side-nav-item">
                    <a href="{{ route('superdealer.dashboard') }}" class="aiz-side-nav-link">
                        <i class="las la-home aiz-side-nav-icon"></i>
                        <span class="aiz-side-nav-text">{{ translate('Dashboard') }}</span>
                    </a>
                </li>
            </ul><!-- .aiz-side-nav -->
        </div><!-- .aiz-side-nav-wrap -->
        @endif
    </div><!-- .aiz-sidebar -->
    <div class="aiz-sidebar-overlay"></div>
</div><!-- .aiz-sidebar -->