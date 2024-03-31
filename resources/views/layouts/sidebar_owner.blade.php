 <nav id="sidebar" class="sidebar js-sidebar fixed my-bg-secondary">
     <div class="sidebar-content js-simplebar my-bg-secondary">
         <a class="sidebar-brand" href="#">
            <span class="align-middle text-capitalize">Panel {{ Auth::user()->role }}</span>
         </a>

         <ul class="sidebar-nav">
             <li class="sidebar-item @if (request()->routeIs('owner.dashboard')) active @endif">
                 <a class="sidebar-link bg-transparent fw-bold" href="{{ route('owner.dashboard') }}">
                     <i class="align-middle fa fa-home"></i> <span class="align-middle">Dashboard</span>
                 </a>
             </li>
             <li class="sidebar-item @if (request()->routeIs('owner.prediction.in.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('owner.prediction.in') }}">
                    <i class="align-middle fa fa-money-bill-wave"></i> <span class="align-middle">Prediksi Kas Masuk</span>
                </a>
            </li>
            <li class="sidebar-item @if (request()->routeIs('owner.prediction.out.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('owner.prediction.out') }}">
                    <i class="align-middle fa fa-credit-card"></i> <span class="align-middle">Prediksi Kas Keluar</span>
                </a>
            </li>
            <li class="sidebar-item @if (request()->routeIs('owner.prediction.sales.*')) active @endif">
                <a class="sidebar-link bg-transparent fw-bold" href="{{ route('owner.prediction.sales') }}">
                    <i class="align-middle fa fa-shopping-cart"></i>
                    <span class="align-middle">Prediksi Penjualan</span>
                </a>
            </li>
                <li class="sidebar-item @if (request()->routeIs('owner.prediction.profit')) active @endif">
                    <a class="sidebar-link bg-transparent fw-bold" href="{{ route('owner.prediction.profit') }}">
                        <i class="align-middle fa fa-chart-line"></i> <span class="align-middle">Prediksi Profit</span>
                    </a>
                </li>
         </ul>
     </div>
 </nav>
