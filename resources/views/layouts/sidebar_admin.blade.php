 <nav id="sidebar" class="sidebar js-sidebar fixed my-bg-secondary">
     <div class="sidebar-content js-simplebar my-bg-secondary">
         <a class="sidebar-brand" href="#">
            <img src="{{ asset('img/logo.png') }}" alt="logo" class="img-fluid" width="50">
            <span class="align-middle">{{ get_my_app_config('nama_web') }}</span>
         </a>

         <ul class="sidebar-nav">
             <li class="sidebar-item @if (request()->routeIs('manager.dashboard')) active @endif">
                 <a class="sidebar-link bg-transparent fw-bold" href="{{ route('manager.dashboard') }}">
                     <i class="align-middle fa fa-home"></i> <span class="align-middle">Dashboard</span>
                 </a>
             </li>

            <li class="sidebar-item @if (request()->routeIs('manager.menu.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('manager.menu.index') }}">
                    <i class="align-middle fa fa-cart-plus"></i>
                    <span class="align-middle">Menu</span>
                </a>
            </li>

            <li class="sidebar-item @if (request()->routeIs('manager.raw_material.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('manager.raw_material.index') }}">
                    <i class="align-middle fa fa-layer-group"></i>
                    <span class="align-middle">Kelola Bahan Baku</span>
                </a>
            </li>

            <li class="sidebar-item @if (request()->routeIs('manager.user.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('manager.user.index') }}">
                    <i class="align-middle fa fa-users"></i>
                    <span class="align-middle">Kelola User</span>
                </a>
            </li>

            <li class="sidebar-item @if (request()->routeIs('manager.cash.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('manager.cash.index') }}">
                    <i class="align-middle fa fa-money-bill-wave"></i>
                    <span class="align-middle">Kelola Kas</span>
                </a>
            </li>

            <li class="sidebar-item @if (request()->routeIs('manager.report.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('manager.report.index') }}">
                    <i class="align-middle fa fa-file-alt"></i>
                    <span class="align-middle">Laporan</span>
                </a>
            </li>

             {{-- <li class="sidebar-item @if (request()->routeIs('admin.categories.*')) active @endif">
                 <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.categories.index') }}">
                     <i class="align-middle fa fa-list"></i> <span class="align-middle">Kategori</span>
                 </a>
             </li>
             <li class="sidebar-item @if (request()->routeIs('admin.racks.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.racks.index') }}">
                    <i class="align-middle fa fa-boxes-packing"></i> <span class="align-middle">Lemari Penyimpanan</span>
                </a>
            </li>
            <li class="sidebar-item @if (request()->routeIs('admin.ingredients.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.ingredients.index') }}">
                    <i class="align-middle fa fa-layer-group"></i> <span class="align-middle">Bahan Baku</span>
                </a>
            </li>
            <li class="sidebar-item @if (request()->routeIs('admin.ingredientStocks.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.ingredientStocks.index') }}">
                    <i class="align-middle fa fa-cart-flatbed"></i> <span class="align-middle">Persediaan Bahan Baku</span>
                </a>
            </li>
            <li class="sidebar-item @if (request()->routeIs('admin.products.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.products.index') }}">
                    <i class="align-middle fa fa-bread-slice"></i> <span class="align-middle">Master Roti</span>
                </a>
            </li>
            <li class="sidebar-item @if (request()->routeIs('admin.productStocks.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.productStocks.index') }}">
                    <i class="align-middle fa fa-boxes-packing"></i> <span class="align-middle">Produksi Roti</span>
                </a>
            </li>
            <li class="sidebar-item @if (request()->routeIs('admin.orders.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.orders.index') }}">
                    <i class="align-middle fa fa-cart-shopping"></i> <span class="align-middle">Pesanan</span>
                </a>
            </li>
            <li class="sidebar-item @if (request()->routeIs('admin.persediaan.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.persediaan.index') }}">
                    <i class="align-middle fa fa-boxes-stacked"></i> <span class="align-middle">Persediaan Roti</span>
                </a>
            </li>
            <li class="sidebar-item @if (request()->routeIs('admin.mrp.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('admin.mrp.index') }}">
                    <i class="align-middle fa fa-calculator"></i> <span class="align-middle">Perhitungan MRP</span>
                </a>
            </li> --}}
         </ul>
     </div>
 </nav>
