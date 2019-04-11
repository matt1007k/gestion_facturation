@extends('layouts.app')
@section('title', 'Generar Nota')
@section('content')
<ol class="breadcrumb">
    <li class="breadcrumb-item">Admin</li>
    <li class="breadcrumb-item">
      <a href="{{route('home')}}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Generar Nota</li>
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
        <generar-nota num_comprobant="{{$num_comprobant}}"></generar-nota>   
    </div>
</div>
@endsection