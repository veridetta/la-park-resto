<nav class="navbar navbar-expand navbar-dark my-bg text-white">
    <a class="sidebar-toggle js-sidebar-toggle text-white">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse ">
        <ul class="navbar-nav navbar-align">
            <?php
            use App\Models\Notification;
            $notifications = Notification::where('user_id', auth()->user()->id)->where('is_read', 0)->get();

            ?>
            <li class="nav-item position-relative me-2">
                <a class="nav-link" href="{{ route('manager.notification') }}">
                    <i class="align-middle" data-feather="bell"></i>
                    <span class="position-absolute top-10 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $notifications->count() }}</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="user"></i>
                    {{-- <span class="text-dark fw-bold text-white text-uppercase">{{ substr(auth()->user()->name, 0, 2) }}</span> --}}
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="{{ route('profile') }}"><i class="align-middle me-1"
                            data-feather="user"></i> Profile</a>
                    <div class="dropdown-divider"></div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item"><i class="align-middle me-1" data-feather="log-out"></i>
                            Sign out</button>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
