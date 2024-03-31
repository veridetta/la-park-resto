 <nav id="sidebar" class="sidebar js-sidebar fixed my-bg-secondary">
     <div class="sidebar-content js-simplebar my-bg-secondary">
         <a class="sidebar-brand" href="#">
            <span class="align-middle text-capitalize">Panel {{ Auth::user()->role }}</span>
         </a>

         <ul class="sidebar-nav">
             <li class="sidebar-item @if (request()->routeIs('kasir.dashboard')) active @endif">
                 <a class="sidebar-link bg-transparent fw-bold" href="{{ route('kasir.dashboard') }}">
                     <i class="align-middle fa fa-home"></i> <span class="align-middle">Dashboard</span>
                 </a>
             </li>
                <li class="sidebar-item @if (request()->routeIs('kasir.sales.*')) active @endif">
                    <a class="sidebar-link bg-transparent fw-bold" href="{{ route('kasir.sales.index') }}">
                        <i class="align-middle fa fa-money-bill-wave"></i>
                        <span class="align-middle">Penjualan</span>
                    </a>
                </li>

         </ul>
     </div>
 </nav>
