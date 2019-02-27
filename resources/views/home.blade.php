@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item active">Dashboard</li>
    <!-- Breadcrumb Menu-->
    <li class="breadcrumb-menu d-md-down-none">
      <div class="btn-group" role="group" aria-label="Button group">
        <a class="btn" href="#">
          <i class="icon-speech"></i>
        </a>
        <a class="btn" href=" {{route('home')}} ">
          <i class="icon-graph"></i>  Dashboard</a>
        <a class="btn" href="#">
          <i class="icon-settings"></i>  Settings</a>
      </div>
    </li>
</ol>
<div class="container-fluid">
    <div class="animated fadeIn">
      <div class="row">
        <div class="col-sm-6 col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="h1 text-muted text-right mb-4">
                <i class="icon-people"></i>
              </div>
              <div class="text-value">87.500</div>
              <small class="text-muted text-uppercase font-weight-bold">Visitors</small>
              <div class="progress progress-xs mt-3 mb-0">
                <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-sm-6 col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="h1 text-muted text-right mb-4">
                <i class="icon-user-follow"></i>
              </div>
              <div class="text-value">385</div>
              <small class="text-muted text-uppercase font-weight-bold">New Clients</small>
              <div class="progress progress-xs mt-3 mb-0">
                <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-sm-6 col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="h1 text-muted text-right mb-4">
                <i class="icon-basket-loaded"></i>
              </div>
              <div class="text-value">1238</div>
              <small class="text-muted text-uppercase font-weight-bold">Products sold</small>
              <div class="progress progress-xs mt-3 mb-0">
                <div class="progress-bar bg-warning" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-sm-6 col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="h1 text-muted text-right mb-4">
                <i class="icon-pie-chart"></i>
              </div>
              <div class="text-value">28%</div>
              <small class="text-muted text-uppercase font-weight-bold">Returning Visitors</small>
              <div class="progress progress-xs mt-3 mb-0">
                <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
              </div>
          </div>
          </div>
        </div>
        
        
        
        </div>
    </div>
</div>
@endsection
