@section('content_scripts')
    <script src="{{ asset('/js/hotkeys-js/dist/hotkeys.js') }}" type="module" defer></script>
    <script src="{{ asset('/js/scope/cashier-hotkeys.js') }}" type="module" defer></script>
@endsection

<div class="row">
    <div class="left-nav-container col-sm-auto mx-0 px-0">
        <a href="{{ url('/pos') }}" class="logo p-3 d-block text-center">
            <img src="{{ asset('img/logo.svg') }}"alt="maemaestore logo">
        </a>
        <nav id="cashier_nav" class="side-nav text-center">
            <a class="p-3 d-block {{ navActive('pos') }}" href="{{ url('/pos') }}" title="[F1]">
                <div class="icon-container rounded-circle mx-auto text-center">
                    <i class="fa-solid fa-clipboard-list align-middle"></i>
                </div>
                <span>POS</span>
            </a>

            <a class="p-3 d-block {{ navActive('cashier-products') }}" href="{{ url('/cashier-products') }}"
                title="[F2]">
                <div class="icon-container rounded-circle mx-auto text-center">
                    <i class="fa-solid fa-box align-middle"></i>
                </div>
                <span>PRODUCTS</span>
            </a>

            <a class="p-3 d-block {{ navActive('customer') }}" href="{{ route('customer') }}" title="[F2]">
                <div class="icon-container rounded-circle mx-auto text-center">
                    <i class="fa-solid fa-face-smile align-middle"></i>
                </div>
                <span>CUSTOMERS</span>
            </a>

            <a class="p-3 d-block {{ navActive('cashier-settings') }}" href="{{ url('/cashier-settings') }}"
                title="[F3]">
                <div class="icon-container rounded-circle mx-auto text-center">
                    <i class="fa-solid fa-tags align-middle"></i>
                </div>
                <span>SETTINGS</span>
            </a>
            <a class="p-3 d-block" href="{{ url('/logout') }}" title="[F9]">
                <div class="icon-container rounded-circle mx-auto text-center">
                    <i class="fa-solid fa-user align-middle"></i>
                </div>
                <span>SWITCH USER</span>
            </a>
        </nav>
    </div>
    <div class="col-xl-10 pt-3">
        @yield('cashier_content')
    </div>
</div>
