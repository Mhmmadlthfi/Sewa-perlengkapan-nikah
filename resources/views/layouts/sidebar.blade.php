<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <span class="app-brand-text menu-text fw-bolder ms-2">KARISMA
      ARGA</span>
    <a href="javascript:void(0);"
      class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>
  <div class="menu-inner-shadow"></div>
  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item {{ Request::is('dashboard') ? 'active open' : '' }}">
      <a href="{{ route('dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div>Dashboard</div>
      </a>
    </li>

    <!-- Data Master -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Data Master</span>
    </li>
    <li class="menu-item {{ Request::is('category*') ? 'active open' : '' }}">
      <a href="{{ route('category.index') }}" class="menu-link">
        <i class='menu-icon tf-icons bx bx-category-alt'></i>
        <div>Kategori Produk</div>
      </a>
    </li>
    <li class="menu-item {{ Request::is('product*') ? 'active open' : '' }}">
      <a href="{{ route('product.index') }}" class="menu-link">
        <i class='menu-icon tf-icons bx bx-box'></i>
        <div>Produk</div>
      </a>
    </li>

    <!-- Data Transaksi -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Data Transaksi</span>
    </li>
    <li class="menu-item {{ Request::is('order*') ? 'active open' : '' }}">
      <a href="{{ route('order.index') }}" class="menu-link">
        <i class='menu-icon tf-icons bx bx-archive-in'></i>
        <div>Order</div>
      </a>
    </li>

    <!-- Data User -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Data User</span>
    </li>
    <li class="menu-item {{ Request::is('user*') ? 'active open' : '' }}">
      <a href="{{ route('user.index') }}" class="menu-link">
        <i class='menu-icon tf-icons bx bx-user'></i>
        <div>User</div>
      </a>
    </li>

    <!-- Logout -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Logout</span>
    </li>
    <li class="menu-item">
      <form action="{{ route('logout') }}" method="post">
        @csrf
        <div class="menu-link">
          <button type="submit" class="btn p-0 border-0">
            <i class='menu-icon tf-icons bx bx-log-out-circle'></i>
            Logout
          </button>
        </div>
      </form>
    </li>
    <!-- / Logout -->

</aside>