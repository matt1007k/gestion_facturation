@extends('layouts.app')

@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item">
      <a href="{{route('home')}}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Editar datos de empresa</li>
    <!-- Breadcrumb Menu-->
    <li class="breadcrumb-menu d-md-down-none">
      <div class="btn-group" role="group" aria-label="Button group">
        <a class="btn" href="#">
          <i class="icon-speech"></i>
        </a>
        <a class="btn" href=" {{route('home')}} ">
          <i class="icon-graph"></i>  Dashboard</a>
       
      </div>
    </li>
</ol>
<div class="container-fluid">
    <div class="animated fadeIn">
    <profile-view ></profile-view>
    </div>
</div>
@endsection