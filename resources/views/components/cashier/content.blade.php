@section('content_scripts')
    <script src="{{ asset('/js/hotkeys-js/dist/hotkeys.js') }}" type="module" defer></script>
    <script src="{{ asset('/js/scope/cashier-hotkeys.js') }}" type="module" defer></script>
@endsection
<div class="my-xl-4 mx-xl-5 row">
    <div class="gutter-div col-xl-2"></div>

    @include('components.site-title')
    <div class="col-xl-2">
        <div>
            <p>
                {{ date('Y-m-d h:i A') }}
            </p>
        </div>
        <div>
            <span>Cashier: {{ Auth::user()->first_name }}</span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-2 mx-0 px-0">
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
    <div class="col-xl-10">
        @yield('cashier_content')
    </div>
</div>
