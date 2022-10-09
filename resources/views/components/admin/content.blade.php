@section('content_scripts')
    <script src="{{ asset('/js/hotkeys-js/dist/hotkeys.js') }}" type="module" defer></script>
    <script src="{{ asset('/js/scope/admin-hotkeys.js') }}" type="module" defer></script>
@endsection

<div class="my-xl-4 mx-xl-5 row">
    <div class="gutter-div col-xl-2"></div>
    <div class="col-xl-auto align-self-center px-0">
    </div>
    @include('components.site-title')
    <div class="col-xl-2">
        <div>
            <p>
                {{ date('Y-m-d h:i A') }}
            </p>
        </div>
        <div>
            <span>Admin: {{ Auth::user()->first_name }}</span>
            <div>
                <a href="{{ route('settings') }}">
                    <i class="fa-solid fa-gear"></i> Settings
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-2 mx-0 px-0">
        <nav id="admin_nav" class="side-nav text-center">
            <a class="p-3 d-block {{ navActive('products') }}" href="{{ url('/products') }}" title="[F1]">
                <div class="icon-container rounded-circle mx-auto text-center">
                    <i class="fa-solid fa-clipboard-list align-middle"></i>
                </div>
                <span>PRODUCTS</span>
            </a>

            <a class="p-3 d-block {{ navActive('inventory') }}" href="{{ url('/inventory') }}" title="[F2]">
                <div class="icon-container rounded-circle mx-auto text-center">
                    <i class="fa-solid fa-box align-middle"></i>
                </div>
                <span>INVENTORY</span>
            </a>

            <a class="p-3 d-block {{ navActive('report') }}" href="{{ url('/report') }}" title="[F3]">
                <div class="icon-container rounded-circle mx-auto text-center">
                    <i class="fa-solid fa-tags align-middle"></i>
                </div>
                <span>REPORT</span>
            </a>
            <a class="p-3 d-block {{ navActive('accounts') }}" href="{{ url('/accounts') }}" title="[F4]">
                <div class="icon-container rounded-circle mx-auto text-center">
                    <i class="fa-solid fa-user align-middle"></i>
                </div>
                <span>ACCOUNTS</span>
            </a>
            <a class="p-3 d-block {{ navActive('log-manager') }}" href="{{ url('/log-manager') }}" title="[F6]">
                <div class="icon-container rounded-circle mx-auto text-center">
                    <i class="fa-solid fa-table-list align-middle"></i>
                </div>
                <span>LOG MANAGER</span>
            </a>
            <a class="p-3 d-block {{ navActive('pos') }}" href="{{ url('/pos') }}" title="[F7]">
                <div class="icon-container rounded-circle mx-auto text-center">
                    <i class="fa-solid fa-clipboard-list align-middle"></i>
                </div>
                <span>POS</span>
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
        @yield('admin_content')
    </div>
</div>
