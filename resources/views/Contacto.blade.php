@extends('layouts.HF')
<link href="{{ asset('css/ContactoStyle.css')}}" rel="stylesheet">
<head>
      <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

@section('Contacto')
<div class="container-fluid" id="fadebg">
<div id="map-container-demo-section" class="z-depth-1-half map-container-section mb-4" style="height: 500px;">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3599.8039022080693!2d-103.44418051167632!3d25.544908171934765!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x868fdb9a40f098f5%3A0xdf1f135609b1d9ab!2sEmpresa%20JosCir!5e0!3m2!1ses-419!2smx!4v1663617686649!5m2!1ses-419!2smx" style="margin-top: 50px"></iframe>
</div> 
<div class="container">
  <div class="row ">
    <div class="col-md-8 md-offset">
      <h1 class="text-light">@lang('contacto.title')</h1>
      <div class="card-body">
      @if (Session::get('mensaje_enviado'))
          <div class="alert alert-success" role="alert">
            {{Session::get('mensaje_enviado')}}
          </div>
          @elseif(Session::get('mensaje_error'))
            <div class="alert alert-danger" role="alert">
              {{Session::get('mensaje_error')}}
          </div>
        @endif 
      </div>
      <form action="{{route('Contacto.Enviado')}}" method="POST">
      @csrf
  <div class="mb-3">
      <label for="validationDefault01" class="form-label text-light">@lang('contacto.full_name') *</label>
    <input type="text" class="form-control" id="validationDefault01" minlength="10" name="nombre" placeholder="Ej. Juan López" required>
  </div>

</div>
<div class="mb-3">
      <label for="validationDefault02" class="form-label text-light">@lang('contacto.email') *</label>
    <input type="email" name="correo" class="form-control" id="validationDefault02" placeholder="nombre@example.com" required>
</div>
<div class="mb-3">
      <label for="validationDefault03" class="form-label text-light">@lang('contacto.phone_number') *</label>
    <input type="tel" name="telefono" id="phone" class="form-control" id="validationDefault03" maxlength="12" placeholder="871-904-6523" pattern="[0-9]{10}"  required>
</div>
<div class="mb-3">
  <label for="validationTextarea" class="form-label text-light">@lang('contacto.message') *</label>
  <textarea class="form-control" name="mensaje" id="validationTextarea" rows="3" required></textarea>
  <br>
</div>
<div class="mb-3">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
  <div class="g-recaptcha" id="feedback-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}" data-callback="recaptchaCallback"></div>
      <br/>
</div>
<div class="mb-3">
        <button type="submit" class="btn btn-block btn-lg d-none" id="button" >@lang('contacto.button')</button>
        <br>
        <br>
    </div>
</div>
      </form>
    </div>
  </div>

</div>
</div>
<script>
  function recaptchaCallback() {
        var btnSubmit = document.getElementById("button");

        if ( btnSubmit.classList.contains("d-none") ) {
        btnSubmit.classList.remove("d-none");
            btnSubmitclassList.add("show");
        }
    }
</script>
@endsection