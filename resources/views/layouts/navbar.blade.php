<nav class="navbar navbar-expand-lg bg-body-tertiary nav-cont">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">ShareSphere</a>
    <button class="navbar-toggler navbar-icon" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <form class="d-flex search-cont" role="search">
          <input class="search form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="search icon-cont" type="submit">
            <img class="search-icon" src="{{ asset('images/search.svg') }}" alt="Logo">
          </button>
        </form>
        <li class="nav-item text">
          <a class="nav-link" href="#">Cart</a>
        </li>
        <li class="nav-item dropdown text">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Account
          </a>
          <ul class="dropdown-menu text">
            @auth
              <li><a class="dropdown-item" href="#" id="logout-button">Logout</a></li>

              <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                  @csrf
              </form>
            @endauth
            @guest  
              <li><a class="dropdown-item" href="/login">Login</a></li>
              <li><a class="dropdown-item" href="/register">Register</a></li>
            @endguest
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
