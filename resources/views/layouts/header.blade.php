@if (Auth::user() !== null)
    <header class="p-1">
        <nav class="nav">
            <ul class="m-0">
                <li>
                    <p class="m-0">
                        Logged in as: {{ Auth::user()->first_name }}
                    </p>
                </li>
            </ul>
        </nav>
    </header>
@endif
