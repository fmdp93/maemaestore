@if (session('msg_success'))
    <div class="row my-xl-3">
        <div class="col-auto">
            <div class="rounded-1 bg-msg-success p-xl-3 text-primary">
                {{ session('msg_success') }}
            </div>
        </div>
    </div>
@endif
