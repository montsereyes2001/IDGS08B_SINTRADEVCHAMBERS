@extends('layouts.HF')
@section('Inicio')
<style> 
h1{
    font-family: 'Poppins', sans-serif;
  font-size: 40px;
}
</style>
<link href="{{ asset('css/InicioStyle.css') }}" rel="stylesheet">
<div class="container-fluid">
  <div id="myCarousel" class="carousel slide" data-bs-ride="carousel" style="margin-start: 0%">
    <div class="carousel-inner">
      <div class="carousel-item active" data-bs-interval="2000">
        <img class="d-block w-100" src="{{URL::asset('/assets/Telecom.png')}}" alt="First slide">
        <div class="carousel-caption d-md-block text-center">
          <h1 style="font-size:30px; font-height:40px;">@lang('inicio.gpon_title')</h1>
          <p><a id="btnwhite" class="btn btn-lg btn-outline-light"
              href="{{route('servicios')}}">@lang('inicio.see_more')</a></p>
        </div>
      </div>
      <div class="carousel-item" data-bs-interval="2000">
        <img class="d-block w-100" src="{{URL::asset('/assets/construccion.png')}}" alt="Second slide">
        <div class="carousel-caption d-md-block text-center">
          <h1 style="font-size:30px; font-height:40px;">@lang('inicio.obra_title')</h1>
          <p><a id="btnwhite" class="btn btn-lg btn-outline-light"
              href="{{route('servicios')}}">@lang('inicio.see_more')</a></p>
        </div>
      </div>
      <div class="carousel-item" data-bs-interval="2000">
        <img class="d-block w-100" src="{{URL::asset('/assets/Poste.png')}}" alt="Third slide">
        <div class="carousel-caption d-md-block text-center">
          <h1 style="font-size:30px; font-height:40px;">@lang('inicio.poste_title')</h1>
          <p><a id="btnwhite" class="btn btn-lg btn-outline-light"
              href="{{route('servicios')}}">@lang('inicio.see_more')</a></p>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">@lang('inicio.previous')</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">@lang('inicio.next')</span>
    </button>
  </div>
</div>
<div class="container-fluid" id="sectionwhite">
  <br>
  <div class="container px-4 px-lg-5 my-5">
    <div class="row gx-4 gx-lg-5 align-items-center">
      <h1 class="text-center">@lang('inicio.about_us')</h1>
      <div class="col-md-6 order-md-1"><img class="card-img-top mb-5 mb-md-0"
          src="{{URL::asset('/assets/mision.webp')}}" alt="..." /></div>
      <div class="col-md-6 order-md-2 text-center">
        <p class="lead">@lang('inicio.about_us_desc')</p>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-md-6 order-md-3 text-center">
        <div class="row align-items-center">
          <div class="col-md-12 mb-5 mb-md-0">
            <h2>@lang('inicio.mission')</h2>
            <p class="lead">@lang('inicio.mission_desc')</p>
          </div>
          <div class="col-md-12">
            <h2>@lang('inicio.vision')</h2>
            <p class="lead">@lang('inicio.vision_desc')</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 order-md-4"><img class="card-img-top mb-5 mb-md-0 img-fluid"
          src="{{URL::asset('/assets/misionvision.png')}}" alt="..." /></div>
    </div>
  </div>
  <br>
</div>

{{-- <div class="container-fluid">
<div id="myCarousel" class="carousel slide" data-bs-ride="carousel" style="margin-start: 0%">
  <div class="carousel-inner">
    <div class="carousel-item active" data-bs-interval="2000">
      <img class="d-block w-100" src="{{URL::asset('/assets/Telecom.png')}}" alt="First slide">
      <div class="carousel-caption d-md-block text-center">
        <h1 style="font-size:30px; font-height:40px;">@lang('inicio.telecom_title')</h1>
        <p><a id="btnwhite" class="btn btn-lg btn-outline-light"
            href="{{route('servicios')}}">@lang('inicio.see_more')</a></p>
      </div>
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img class="d-block w-100" src="{{URL::asset('/assets/autotransporte.png')}}" alt="Second slide">
      <div class="carousel-caption d-md-block text-center">
        <h1 style="font-size:30px; font-height:40px;">@lang('inicio.autotrans_title')</h1>
        <p><a id="btnwhite" class="btn btn-lg btn-outline-light"
            href="{{route('servicios')}}">@lang('inicio.see_more')</a></p>
      </div>
    </div>
    <div class="carousel-item" data-bs-interval="2000">
      <img class="d-block w-100" src="{{URL::asset('/assets/construccion.png')}}" alt="Third slide">
      <div class="carousel-caption d-md-block text-center">
        <h1 style="font-size:30px; font-height:40px;">@lang('inicio.construction_title')</h1>
        <p><a id="btnwhite" class="btn btn-lg btn-outline-light"
            href="{{route('servicios')}}">@lang('inicio.see_more')</a></p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">@lang('inicio.previous')</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">@lang('inicio.next')</span>
  </button>
</div>
</div>
<div class="container-fluid" id="sectionwhite">
  <br>
  <div class="container px-4 px-lg-5 my-5">
    <div class="row gx-4 gx-lg-5 align-items-center">
        <h1 class="text-center">@lang('inicio.about_us')</h1>
      <div class="col-md-6 order-md-1"><img class="card-img-top mb-5 mb-md-0"
          src="{{URL::asset('/assets/mision.webp')}}" alt="..." /></div>
      <div class="col-md-6 order-md-2 text-center">
        <p class="lead">@lang('inicio.about_us_desc')</p>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-md-6 order-md-3 text-center">
        <div class="row align-items-center">
          <div class="col-md-12 mb-5 mb-md-0">
            <h2>@lang('inicio.mission')</h2>
            <p class="lead">@lang('inicio.mission_desc')</p>
          </div>
          <div class="col-md-12">
            <h2>@lang('inicio.vision')</h2>
            <p class="lead">@lang('inicio.vision_desc')</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 order-md-4"><img class="card-img-top mb-5 mb-md-0 img-fluid"
          src="{{URL::asset('/assets/misionvision.png')}}" alt="..." /></div>
    </div>
  </div>
  <br>
</div> --}}
@endsection