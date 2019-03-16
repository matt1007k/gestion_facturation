<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <a class="navbar-brand" href="#">
        @if (auth()->user()->logo !== 'logo.png')            
            <img class="navbar-brand-full" src="{{ url(auth()->user()->logo) }}" width="100" height="30" alt="{{auth()->user()->name}}">
        @else
            <img class="navbar-brand-full" src="{{ asset('img/brand/logo.svg') }}" width="89" height="25" alt="CoreUI Logo">
            <img class="navbar-brand-minimized" src="{{ asset('img/brand/sygnet.svg') }}" width="30" height="30" alt="CoreUI Logo">
        @endif
        
        
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
    <span class="navbar-toggler-icon"></span>
    </button>
    <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="{{ route('productos.index') }}">Productos</a>
        </li>
        <li class="nav-item px-3">
            <a class="nav-link" href="#">Settings</a>
        </li>
    </ul>
        <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown d-md-down-none">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="icon-bell"></i>
                <span class="badge badge-pill badge-danger">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
                <div class="dropdown-header text-center">
                    <strong>You have 0 notifications</strong>
                </div>
                <a class="dropdown-item" href="#">
                    <i class="icon-user-follow text-success"></i> New user registered
                </a>
                <a class="dropdown-item" href="#">
                    <i class="icon-user-unfollow text-danger"></i> User deleted
                </a>
                <a class="dropdown-item" href="#">
                    <i class="icon-chart text-info"></i> Sales report is ready
                </a>
                <a class="dropdown-item" href="#">
                    <i class="icon-basket-loaded text-primary"></i> New client
                </a>
                <a class="dropdown-item" href="#">
                    <i class="icon-speedometer text-warning"></i> Server overloaded
                </a>  
                <a class="dropdown-item text-center" href="#">
                    <strong>View all tasks</strong>
                </a>                  
            </div>
        </li>
        <li class="nav-item dropdown d-md-down-none">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="icon-list"></i>
                <span class="badge badge-pill badge-warning">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
                <div class="dropdown-header text-center">
                    <strong>You have 0 pending tasks</strong>
                </div>
                <a class="dropdown-item" href="#">
                    <div class="small mb-1">Upgrade NPM &amp; Bower
                        <span class="float-right">
                        <strong>0%</strong>
                        </span>
                    </div>
                    <span class="progress progress-xs">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </span>
                </a>
                <a class="dropdown-item" href="#">
                    <div class="small mb-1">ReactJS Version
                        <span class="float-right">
                        <strong>25%</strong>
                    </span>
                    </div>
                    <span class="progress progress-xs">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </span>
                </a>
                <a class="dropdown-item" href="#">
                    <div class="small mb-1">VueJS Version
                        <span class="float-right">
                        <strong>50%</strong>
                        </span>
                    </div>
                    <span class="progress progress-xs">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </span>
                </a>
                <a class="dropdown-item" href="#">
                    <div class="small mb-1">Add new layouts
                        <span class="float-right">
                        <strong>75%</strong>
                        </span>
                    </div>
                    <span class="progress progress-xs">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                    </span>
                </a>
                <a class="dropdown-item" href="#">
                    <div class="small mb-1">Angular 2 Cli Version
                        <span class="float-right">
                        <strong>100%</strong>
                        </span>
                    </div>
                    <span class="progress progress-xs">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </span>
                </a>
                <a class="dropdown-item text-center" href="#">
                    <strong>View all tasks</strong>
                </a>
            </div>
        </li>
        <li class="nav-item dropdown d-md-down-none">
            <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="icon-envelope-letter"></i>
                <span class="badge badge-pill badge-info">0</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg">
                <div class="dropdown-header text-center">
                    <strong>You have 0 messages</strong>
                </div>
                <a class="dropdown-item" href="#">
                    <div class="message">
                        <div class="py-3 mr-3 float-left">
                            <div class="avatar">
                                <img class="img-avatar" src="{{ asset('img/avatars/user.jpg') }}" alt="admin@bootstrapmaster.com">
                                <span class="avatar-status badge-success"></span>
                            </div>
                        </div>
                        <div>
                            <small class="text-muted">John Doe</small>
                            <small class="text-muted float-right mt-1">Just now</small>
                        </div>
                        <div class="text-truncate font-weight-bold">
                            <span class="fa fa-exclamation text-danger"></span> Important message
                        </div>
                        <div class="small text-muted text-truncate">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</div>
                    </div>
                </a>
               
                <a class="dropdown-item text-center" href="#">
                    <strong>View all messages</strong>
                </a>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                <img class="img-avatar" src="{{ asset('img/avatars/user.jpg') }}" alt="admin@bootstrapmaster.com">
            </a>
            <div class="dropdown-menu dropdown-menu-right">            
                <div class="dropdown-header text-center">
                    <strong>Settings</strong>
                </div>
                <a class="dropdown-item" href="{{ route('perfil') }}">
                    <i class="fa fa-user"></i> Perfil</a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-wrench"></i> Settings</a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-usd"></i> Payments
                    <span class="badge badge-dark">42</span>
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-file"></i> Projects
                    <span class="badge badge-primary">42</span>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-shield"></i> Lock Account</a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    <i class="fa fa-lock"></i> Cerrar sesion</a>   
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
            </div>
        </li>
    </ul>
    <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show">
        <span class="navbar-toggler-icon"></span>
    </button>
    <button class="navbar-toggler aside-menu-toggler d-lg-none" type="button" data-toggle="aside-menu-show">
        <span class="navbar-toggler-icon"></span>
    </button>
</header>