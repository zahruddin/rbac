<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <ul class="navbar-nav pt-lg-3">
      <li class="nav-item">
        <a class="nav-link" href="{{ route(Auth::user()->getRoleNames()->first() . '.dashboard') }}">
          <span class="nav-link-icon d-md-none d-lg-inline-block">
            <i class="ti ti-home"></i>
          </span>
          <span class="nav-link-title">Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{ route(Auth::user()->getRoleNames()->first() . '.profile.edit') }}">
          <span class="nav-link-icon d-md-none d-lg-inline-block">
            <i class="ti ti-user"></i>
          </span>
          <span class="nav-link-title">Profile</span>
        </a>
      </li>

      <!-- contoh tambahan -->
      {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route(Auth::user()->getRoleNames()->first() . '.sales.index') }}">
          <span class="nav-link-icon d-md-none d-lg-inline-block">
            <i class="ti ti-report"></i>
          </span>
          <span class="nav-link-title">Sales</span>
        </a>
      </li> --}}
    </ul>
  </div>
</aside>
