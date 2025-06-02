<nav class="navbar navbar-expand-lg bg-body-tertiary nav-cont sticky-top">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="/">
        <img class="logo-icon me-2" src="{{ asset('images/logo.png') }}" alt="Logo" style=>
    </a>
    <button class="navbar-toggler navbar-icon" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <div class="d-lg-flex align-items-center w-100">
        <form class="d-flex search-cont flex-grow-1 me-3" role="search" method="GET" action="{{ route('homeSearch') }}">
          <input class="search form-control me-2" type="search" placeholder="Search" name="query" value="{{ request('query') }}">
          <button class="search icon-cont" type="submit">
            <img class="search-icon" src="{{ asset('images/search.svg') }}" alt="Search">
          </button>
        </form>
      </div>
      <ul class="navbar-nav ms-auto d-flex flex-row align-items-center">
        <li class="nav-item text me-1 d-none d-lg-flex">
          <a class="nav-link" href="/cart">
            <img class="icon" src="{{ asset('images/cart.svg') }}" alt="Cart">
          </a>
        </li>

        <li class="nav-item product dropdown me-1 d-none d-lg-flex">
          <a class="nav-link">
            <img class="icon" src="{{ asset('images/product.svg') }}" alt="Product">
          </a>
          <ul class="dropdown-menu menu" aria-labelledby="productDropdown">
            <li><a class="dropdown-item" href="/add-product">Add Product</a></li>
            <li><a class="dropdown-item" href="/manage-product">Manage Product</a></li>
          </ul>
        </li>

        <li class="nav-item return dropdown me-1 d-none d-lg-flex">
          <a class="nav-link">
            <img class="icon" src="{{ asset('images/return.svg') }}" alt="Return">
          </a>
          <ul class="dropdown-menu menu" aria-labelledby="returnDropdown">
            <li><a class="dropdown-item" href="/return-due">Return Due</a></li>
            <li><a class="dropdown-item" href="/return-request">Return Request</a></li>
            <li><a class="dropdown-item" href="/return">Return History</a></li>
          </ul>
        </li>

        <li class="nav-item text me-1 d-none d-lg-flex">
          <a class="nav-link" href="/transaction">
            <img class="icon" src="{{ asset('images/history.svg') }}" alt="History">
          </a>
        </li>

        <li class="mx-2 devider d-none d-lg-flex" style="width: 1px; background-color: #ccc; height: 24px; align-self: center;"></li>

        <li class="nav-item profile dropdown me-1 d-none d-lg-flex align-items-center">
          @auth
            <img class="profile-icon" src="{{ asset('images/profile.svg') }}" alt="Profile">
            <a class="nav-link profile-name">
              {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu dmprofile" aria-labelledby="profileDropdown">
              <li><a class="dropdown-item" href="/shipping-detail">Shipping Detail</a></li>
              <li>
                <form action="{{ route('logout') }}" method="POST" class="mb-0">
                  @csrf
                  <button type="submit" class="dropdown-item">Logout</button>
                </form>
              </li>
            </ul>
          @else
            <a class="dropdown-item" href="/login">Login</a>
            <a class="dropdown-item" href="/register">Register</a>
          @endauth
        </li>
      </ul>

      <ul class="navbar-nav d-flex flex-column d-lg-none">
        <li class="nav-item">
          <a class="nav-link" href="/cart">Cart</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/add-product">Add Product</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/manage-product">Manage Product</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/return-due">Return Due</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/return-request">Return Request</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/return">Return History</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/transaction">Transaction History</a>
        </li>

        @auth
          <li class="nav-item">
            <a class="nav-link" href="/shipping-detail">Shipping Detail</a>
          </li>

          <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="nav-link">Logout</button>
            </form>
          </li>
        @else
          <li class="nav-item">
            <a class="nav-link" href="/login">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/register">Register</a>
          </li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
