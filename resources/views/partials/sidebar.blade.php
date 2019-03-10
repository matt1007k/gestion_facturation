<div class="sidebar">
    <nav class="sidebar-nav ps ps--active-y">
        <ul class="nav">

            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <i class="nav-icon icon-speedometer"></i> Dashboard
                </a>
            </li>
            <li class="nav-title">Operaciones</li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="nav-icon icon-basket"></i> Ventas</a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/documentos/create') ? 'active' : ''}}" href="{{ route('documentos.create') }}">
                        <i class="nav-icon icon-notebook"></i> Nuevo comprobante</a>
                    </li>                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('documentos.index') }}">
                        <i class="nav-icon icon-list"></i> Comprobantes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('clientes.index') }}">
                        <i class="nav-icon icon-people"></i> Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('productos.index') }}">
                        <i class="nav-icon icon-handbag"></i> Productos</a>
                    </li>
                </ul>
            </li>
       
        </ul>
        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;">
            </div>
        </div>
        <div class="ps__rail-y" style="top: 0px; height: 564px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 240px;"></div>
        </div>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>