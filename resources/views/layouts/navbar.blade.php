<header class="navbar navbar-expand-md navbar-light bg-white">
  <div class="container-xl">
    <a href="{{ url('/') }}" class="navbar-brand">
      <img src="{{ asset('logo.svg') }}" alt="Logo" height="32">
    </a>

    <div class="navbar-nav flex-row order-md-last">
      <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown">
          <span class="avatar avatar-sm" style="background-image: url('https://ui-avatars.com/api/?name={{ Auth::user()->name }}')"></span>
          <div class="d-none d-xl-block ps-2">
            <div>{{ Auth::user()->name }}</div>
            <div class="mt-1 small text-muted">{{ Auth::user()->email }}</div>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <a href="{{ route(Auth::user()->getRoleNames()->first() . '.profile.edit') }}" class="dropdown-item">
            Profile
          </a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="dropdown-item">Logout</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</header>
