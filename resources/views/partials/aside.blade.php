<aside class="aside-menu">
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#timeline" role="tab">
                <i class="icon-list"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#messages" role="tab">
                <i class="icon-speech"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#settings" role="tab">
                <i class="icon-settings"></i>
            </a>
        </li>
    </ul>
        
    <div class="tab-content">
        <div class="tab-pane active" id="timeline" role="tabpanel">
            <div class="list-group list-group-accent">
            <div class="list-group-item list-group-item-accent-secondary bg-light text-center font-weight-bold text-muted text-uppercase small">Today</div>
            <div class="list-group-item list-group-item-accent-warning list-group-item-divider">
                <div class="avatar float-right">
                    <img class="img-avatar" src="{{ asset('img/avatars/user.jpg') }}" alt="admin@bootstrapmaster.com">
                </div>
                <div>Meeting with
                    <strong>Lucas</strong>
                </div>
                <small class="text-muted mr-3">
                    <i class="icon-calendar"></i>&nbsp; 1 - 3pm</small>
                <small class="text-muted">
                <i class="icon-location-pin"></i>&nbsp; Palo Alto, CA</small>
            </div>
            <div class="list-group-item list-group-item-accent-info">
                <div class="avatar float-right">
                    <img class="img-avatar" src="{{ asset('img/avatars/user.jpg') }}" alt="admin@bootstrapmaster.com">
                </div>
                <div>Skype with
                    strong>Megan</strong>
                </div>
                <small class="text-muted mr-3">
                    <i class="icon-calendar"></i>&nbsp; 4 - 5pm</small>
                <small class="text-muted">
                    <i class="icon-social-skype"></i>&nbsp; On-line</small>
            </div>
            <div class="list-group-item list-group-item-accent-secondary bg-light text-center font-weight-bold text-muted text-uppercase small">Tomorrow</div>
                <div class="list-group-item list-group-item-accent-danger list-group-item-divider">
                    <div>New UI Project -
                        <strong>deadline</strong>
                    </div>
                    <small class="text-muted mr-3">
                        <i class="icon-calendar"></i>&nbsp; 10 - 11pm</small>
                    <small class="text-muted">
                        <i class="icon-home"></i>&nbsp; creativeLabs HQ</small>
                    <div class="avatars-stack mt-2">
                        <div class="avatar avatar-xs">
                            <img class="img-avatar" src="{{ asset('img/avatars/user.jpg') }}" alt="admin@bootstrapmaster.com">
                        </div>
                        <div class="avatar avatar-xs">
                            <img class="img-avatar" src="{{ asset('img/avatars/user.jpg') }}" alt="admin@bootstrapmaster.com">
                        </div>
                    </div>
                </div>
                <div class="list-group-item list-group-item-accent-success list-group-item-divider">
                    <div>
                        <strong>#10 Startups.Garden</strong> Meetup</div>
                    <small class="text-muted mr-3">
                        <i class="icon-calendar"></i>&nbsp; 1 - 3pm</small>
                    <small class="text-muted">
                        <i class="icon-location-pin"></i>&nbsp; Palo Alto, CA</small>
                </div>
            </div>
        </div>
        <div class="tab-pane p-3" id="messages" role="tabpanel">
            <div class="message">
                <div class="py-3 pb-5 mr-3 float-left">
                    <div class="avatar">
                        <img class="img-avatar" src="{{ asset('img/avatars/user.jpg') }}" alt="admin@bootstrapmaster.com">
                        <span class="avatar-status badge-success"></span>
                    </div>
                </div>
                <div>
                    <small class="text-muted">Lukasz Holeczek</small>
                    <small class="text-muted float-right mt-1">1:52 PM</small>
                </div>
                <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
                <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</small>
            </div>
            <hr>
            <div class="message">
                <div class="py-3 pb-5 mr-3 float-left">
                    <div class="avatar">
                        <img class="img-avatar" src="{{ asset('img/avatars/user.jpg') }}" alt="admin@bootstrapmaster.com">
                        <span class="avatar-status badge-success"></span>
                    </div>
                </div>
                <div>
                    <small class="text-muted">Lukasz Holeczek</small>
                    <small class="text-muted float-right mt-1">1:52 PM</small>
                </div>
                <div class="text-truncate font-weight-bold">Lorem ipsum dolor sit amet</div>
                <small class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt...</small>
            </div>
            <hr>
            
        </div>
        <div class="tab-pane p-3" id="settings" role="tabpanel">
            <h6>Configuraciones</h6>
            <div class="aside-options">
                <div class="clearfix mt-4">
                    <small>
                        <b>Ruta del sistema facturacion sunat</b>
                    </small>
                    {{-- <label class="switch switch-label switch-pill switch-success switch-sm float-right">
                        <input class="switch-input" type="checkbox" checked="">
                        <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                    </label> --}}
                </div>
                <div>
                    <form-setting></form-setting>
                </div>
            </div>
            {{-- <div class="aside-options">
                <div class="clearfix mt-3">
                    <small>
                        <b>Option 2</b>
                    </small>
                    <label class="switch switch-label switch-pill switch-success switch-sm float-right">
                        <input class="switch-input" type="checkbox">
                        <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                    </label>
                </div>
                <div>
                    <small class="text-muted">Lorem ipsum dolor sit amet.</small>
                </div>
            </div> --}}
            {{-- <div class="aside-options">
                <div class="clearfix mt-3">
                    <small>
                        <b>Option 3</b>
                    </small>
                    <label class="switch switch-label switch-pill switch-success switch-sm float-right">
                        <input class="switch-input" type="checkbox">
                        <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                    </label>
                </div>
            </div>
            <div class="aside-options">
                <div class="clearfix mt-3">
                    <small>
                        <b>Option 4</b>
                    </small>
                    <label class="switch switch-label switch-pill switch-success switch-sm float-right">
                        <input class="switch-input" type="checkbox" checked="">
                        <span class="switch-slider" data-checked="On" data-unchecked="Off"></span>
                    </label>
                </div>
            </div> --}}
        </div>
    </div>
</aside>