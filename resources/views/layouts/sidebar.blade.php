<ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('home')}}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-futbol"></i>
        </div>
        <div class="sidebar-brand-text mx-2"> apuestatotal</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item">
        <a class="nav-link" href="{{route('home')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Interface
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse" aria-expanded="true"
            aria-controls="collapse">
            <i class="fas fa-fw fa-search"></i>
            <span>Consultas</span>
        </a>
        <div id="collapse" class="collapse {{ (request()->is('dni','dnimultiple','services', 'age')) ? 'show' : '' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">DNI</h6>
                <a class="collapse-item {{ (request()->is('dni')) ? 'active' : '' }}" href="{{route('dni')}}">Individual</a>
                <a class="collapse-item {{ (request()->is('dni-multiple')) ? 'active' : '' }}" href="{{route('dni-multiple')}}">Masivo</a>
                <a class="collapse-item {{ (request()->is('age')) ? 'active' : '' }}" href="{{route('age')}}">Validar 18+</a>
                <h6 class="collapse-header">RUC</h6>
                <a class="collapse-item {{ (request()->is('ruc')) ? 'active' : '' }}" href="{{route('ruc')}}">RUC</a>
                <h6 class="collapse-header">Servicios</h6>
                <a class="collapse-item {{ (request()->is('services')) ? 'active' : '' }}" href="{{route('services')}}">Servicios</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider d-none d-md-block">
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
