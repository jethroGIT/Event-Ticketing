<!-- resources/views/layout/sidebar.blade.php -->
<div class="sidebar bg-gradient-to-b from-blue-800 to-blue-600 shadow-lg w-64 min-h-screen fixed transition-all duration-300 z-10 overflow-y-auto h-[calc(100vh-6rem)] hide-scrollbar"
    x-data="sidebar">
    <!-- Logo/Site Name -->
    <div class="p-4 flex items-center justify-center border-b border-blue-400">
        <div class="text-center">
            <img src="{{ asset('image/logofakultas.png') }}" alt="">
            <p class="text-blue-200 text-xs mt-1">Event Ticketing System</p>
        </div>
    </div>

    <!-- Menu Items -->
    <ul class="space-y-0.5 p-3"> <!-- Changed space-y-1 to space-y-0.5 and p-4 to p-3 -->

        @if (session('user.role') == 1)
            <!-- Roles (for admin) -->
            <li class="nav-item">
                <a href="{{ route('roles.index') }}"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-blue-500/30 transition-colors duration-200 group {{ request()->routeIs('roles.*') ? 'bg-blue-500/30' : '' }}">
                    <i class="bi bi-shield-lock mr-3 text-lg group-hover:text-blue-100"></i>
                    <span class="font-medium">Roles</span>
                </a>
            </li>

            <!-- Users -->
            <li class="nav-item">
                <a href="{{ route('users.index') }}"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-blue-500/30 transition-colors duration-200 group {{ request()->routeIs('users.*') ? 'bg-blue-500/30' : '' }}">
                    <i class="bi bi-people mr-3 text-lg group-hover:text-blue-100"></i>
                    <span class="font-medium">Users</span>
                </a>
            </li>
        @endif

        @if (session('user.role') == 1 || session('user.role') == 3)
            <!-- Events -->
            <li class="nav-item">
                <a href="{{ route('events.index') }}"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-blue-500/30 transition-colors duration-200 group {{ request()->routeIs('events.*') ? 'bg-blue-500/30' : '' }}">
                    <i class="bi bi-calendar-event mr-3 text-lg group-hover:text-blue-100"></i>
                    <span class="font-medium">Event</span>
                </a>
            </li>
        @endif

        <!-- Venues -->
        @if (session('user.role') == 1 || session('user.role') == 2 || session('user.role') == 3)
            <li class="nav-item">
                <a href="{{ route('registrasi.index') }}"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-blue-500/30 transition-colors duration-200 group {{ request()->routeIs('attendances.*') ? 'bg-blue-500/30' : '' }}">
                    <i class="bi bi-person-check mr-3 text-lg group-hover:text-blue-100"></i>
                    <span class="font-medium">Registrasi</span>
                </a>
            </li>
        @endif

        @if (session('user.role') == 1 || session('user.role') == 4)
            <!-- Tickets -->
            <li class="nav-item">
                <a href="{{ route('orders.index') }}"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-blue-500/30 transition-colors duration-200 group {{ request()->routeIs('tickets.*') ? 'bg-blue-500/30' : '' }}">
                    <i class="bi bi-ticket-perforated mr-3 text-lg group-hover:text-blue-100"></i>
                    <span class="font-medium">Tickets</span>
                </a>
            </li>
        @endif

        <!-- Orders -->
        @if (session('user.role') == 1 || session('user.role') == 2)
            <li class="nav-item">
                <a href="{{ route('tickets.index') }}"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-blue-500/30 transition-colors duration-200 group {{ request()->routeIs('orders.*') ? 'bg-blue-500/30' : '' }}">
                    <i class="bi bi-cart mr-3 text-lg group-hover:text-blue-100"></i>
                    <span class="font-medium">Transaksi</span>
                </a>
            </li>
        @endif


        <!-- Attendance -->
        @if (session('user.role') == 1 || session('user.role') == 3)
            <li class="nav-item">
                <a href="{{ route('kehadiran.index') }}"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-blue-500/30 transition-colors duration-200 group {{ request()->routeIs('attendances.*') ? 'bg-blue-500/30' : '' }}">
                    <i class="bi bi-clipboard-check mr-3 text-lg group-hover:text-blue-100"></i>
                    <span class="font-medium">Kehadiran</span>
                </a>
            </li>
        @endif

        <!-- Sertifikat Kehadiran (Menu Baru) -->
        @if (session('user.role') == 1 || session('user.role') == 2 || session('user.role') == 3)
            <li class="nav-item">
                <a href="{{ route('kehadiran.sertifikat') }}"
                    class="flex items-center p-2 text-white rounded-lg hover:bg-blue-500/30 transition-colors duration-200 group {{ request()->routeIs('kehadiran.sertifikat') ? 'bg-blue-500/30' : '' }}">
                    <i class="bi bi-award mr-3 text-lg group-hover:text-blue-100"></i>
                    <span class="font-medium">Sertifikat</span>
                </a>
            </li>
        @endif
    </ul>

    <!-- Account Section -->
    <div class="px-3 py-1 mt-2"> <!-- Reduced padding and margin -->
        <div class="text-xs uppercase tracking-wider text-blue-300 font-medium mb-1">Account</div>
        <ul class="space-y-0.5"> <!-- Reduced space between items -->
            <!-- Settings -->
            <li class="nav-item">
                <a href=""
                    class="flex items-center p-2 text-white rounded-lg hover:bg-blue-500/30 transition-colors duration-200 group">
                    <i class="bi bi-gear mr-3 text-lg group-hover:text-blue-100"></i>
                    <span class="font-medium">Settings</span>
                </a>
            </li>

            <!-- Logout -->
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center w-full p-2 text-white rounded-lg hover:bg-blue-500/30 transition-colors duration-200 group">
                        <i class="bi bi-box-arrow-right mr-3 text-lg group-hover:text-blue-100"></i>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</div>
