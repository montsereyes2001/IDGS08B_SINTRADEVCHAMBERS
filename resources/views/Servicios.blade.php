@extends('layouts.HF')
@section('Servicios')
<link href="{{ asset('css/ServiciosStyle.css') }}" rel="stylesheet">
<section class="hero-card-section" >
  <div class="container my-5">
    <div class="row">
      <div class="col-12 col-md-8 hero-card-container" style="margin-top: 50px;"> 
        <div class="card">
          <div class="card-body">
            {{-- <h3 class="card-title">@lang('servicios.telecom')</h3> --}}
            <h3 class="card-title">@lang('servicios.gpon')</h3>
            {{-- <p class="card-text">@lang('servicios.telecom_desc')</p> --}}
            <p class="card-text">@lang('servicios.gpon_desc')</p>
            <a href="{{route('contacto')}}" id="serv" class="btn btn-link btn-card">@lang('servicios.contact')</a>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-8 hero-card-container mx-auto " style="margin-top: 20px">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title">@lang('servicios.post')</h3>
            <p class="card-text">@lang('servicios.post_desc') </p>
            <a href="{{route('contacto')}}" id="serv" class="btn btn-link btn-card ">@lang('servicios.contact')</a>
          </div>
        </div>
      </div>
        <div class="col-12 col-md-8 hero-card-container" style="margin-top: 50px;"> 
        <div class="card">
          <div class="card-body">
          <h3 class="card-title">@lang('servicios.civil')</h3>
            <p class="card-text">@lang('servicios.civil_desc')</p>
            
            <a href="{{route('contacto')}}" id="serv" class="btn btn-link btn-card">@lang('servicios.contact')</a>
          </div>
        </div>
      </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection