@extends('layouts.HF')
@section('Galeria')
<link href="{{ asset('css/GaleriaStyle.css') }}" rel="stylesheet">
<div class="container-fluid">
<section id="projects" class="projects">
    <div class="container aos-init aos-animate" data-aos="fade-up">
        <div class="portfolio-isotope" data-portfolio-filter="*" data-portfolio-layout="masonry"
            data-portfolio-sort="original-order">

            <ul class="portfolio-flters aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
                <li data-filter="*" class="filter-active">@lang('galeria.tipos_trabajo')</li>
                <li data-filter=".filter-gpon">@lang('galeria.tipos_trabajo2')</li>
                <li data-filter=".filter-civilwork">@lang('galeria.tipos_trabajo4')</li>
                <li data-filter=".filter-poles">@lang('galeria.tipos_trabajo3')</li>
            </ul>

            <div class="row gy-4 portfolio-container aos-init aos-animate" data-aos="fade-up" data-aos-delay="200"
>
                <div class="col-lg-4 col-md-6 portfolio-item filter-civilwork">
                    <div class="portfolio-content h-100">
                        <a class="linktoservices" href="{{route('servicios')}}">
                        <img src="{{URL::asset('/assets/ObraCivil/galeria-4.jpg')}}" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>@lang('galeria.tipos_trabajo4')</h4>
                            {{-- <p>Lorem ipsum, dolor sit amet consectetur</p> --}}
                <a href="{{URL::asset('/assets//ObraCivil/galeria-4.jpg')}}" title="@lang('galeria.tipos_trabajo4')"
                                data-gallery="portfolio-civilwork" class="glightbox preview-link"><i
                                    class="bi bi-zoom-in"></i></a>
                        </div>|
                    </div>
                    </a>
                </div>
                <!-- End Projects Item -->
                <div class="col-lg-4 col-md-6 portfolio-item filter-civilwork">
                    <div class="portfolio-content h-100">
                        <a class="linktoservices" href="{{route('servicios')}}">
                      <img src="{{URL::asset('/assets/ObraCivil/galeria-6.jpg')}}">
                        <div class="portfolio-info">
                           <h4>@lang('galeria.tipos_trabajo4')</h4>
                            {{-- <p>Lorem ipsum, dolor sit amet consectetur</p> --}}
                            <a href="{{URL::asset('/assets/ObraCivil/galeria-6.jpg')}}" title="Construction 1"
                                data-gallery="portfolio-civilwork" class="glightbox preview-link"><i
                                    class="bi bi-zoom-in"></i></a>
                        </div>
                    </div>
                    </a>
                </div><!-- End Projects Item -->

                <div class="col-lg-4 col-md-6 portfolio-item filter-civilwork">
                    <div class="portfolio-content h-100">
                        <a class="linktoservices" href="{{route('servicios')}}">
                     <img src="{{URL::asset('/assets/ObraCivil/OC-6.jpg')}}">
                        <div class="portfolio-info">
                            <h4>@lang('galeria.tipos_trabajo4')</h4>
                            {{-- <p>Lorem ipsum, dolor sit amet consectetur</p> --}}
                            <a href="{{URL::asset('/assets/ObraCivil/OC-6.jpg')}}" title="Repairs 1"
                                data-gallery="portfolio-gallery-poles" class="glightbox preview-link"><i
                                    class="bi bi-zoom-in"></i></a>
                        </div>
                    </div>
                    </a>
                </div>
                <!-- End Projects Item -->

                <div class="col-lg-4 col-md-6 portfolio-item filter-civilwork"
>                    <div class="portfolio-content h-100">
    <a class="linktoservices" href="{{route('servicios')}}">
                        <img src="{{URL::asset('/assets/ObraCivil/galeria-1.jpg')}}" class="img-fluid"alt="">                        
                            <div class="portfolio-info">
                            <h4>@lang('galeria.tipos_trabajo4')</h4>
                            {{-- <p>Lorem ipsum, dolor sit amet consectetur</p> --}}
                            <a href="{{URL::asset('/assets/ObraCivil/galeria-1.jpg')}}" title="Repairs 1"
                                data-gallery="portfolio-gallery-civilwork" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                          </a>
                        </div>
                    </div>
                </div><!-- End Projects Item -->

                <div class="col-lg-4 col-md-6 portfolio-item filter-civilwork"
>                    <div class="portfolio-content h-100">
    <a class="linktoservices" href="{{route('servicios')}}">
                        <img src="{{URL::asset('/assets/ObraCivil/OC-3.jpg')}}" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>@lang('galeria.tipos_trabajo4')</h4>
                            {{-- <p>Lorem ipsum, dolor sit amet consectetur</p> --}}
                            <a href="{{URL::asset('/assets/ObraCivil/OC-3.jpg')}}" title="Remodeling 2"
                                data-gallery="portfolio-gallery-civilwork" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                          </a>
                        </div>
                    </div>
                </div><!-- End Projects Item -->

                <div class="col-lg-4 col-md-6 portfolio-item filter-poles"
>                    <div class="portfolio-content h-100">
    <a class="linktoservices" href="{{route('servicios')}}">
                        <img src="{{URL::asset('/assets/Posteria/P-7.jpg')}}" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>@lang('galeria.tipos_trabajo3')</h4>
                            {{-- <p>Lorem ipsum, dolor sit amet consectetur</p> --}}
                            <a href="{{URL::asset('/assets/Posteria/P-7.jpg')}}" title="Construction 2"
                                data-gallery="portfolio-gallery-poles" class="glightbox preview-link"><i
                           class="bi bi-zoom-in"></i></a>
                          </a>
                        </div>
                    </div>
                </div><!-- End Projects Item -->

                <div class="col-lg-4 col-md-6 portfolio-item filter-poles"
>                    <div class="portfolio-content h-100">
    <a class="linktoservices" href="{{route('servicios')}}">
                        <img src="{{URL::asset('/assets/Posteria/P-1.jpg')}}" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>@lang('galeria.tipos_trabajo3')</h4>
                            {{-- <p>Lorem ipsum, dolor sit amet consectetur</p> --}}
                            <a href="{{URL::asset('/assets/Posteria/P-1.jpg')}}" title="Repairs 2"
                                data-gallery="portfolio-gallery-poles" class="glightbox preview-link"><i
                                    class="bi bi-zoom-in"></i></a>
      
                                    </a>
                        </div>
                    </div>
                </div><!-- End Projects Item -->

                <div class="col-lg-4 col-md-6 portfolio-item filter-poles"
>                    <div class="portfolio-content h-100">
    <a class="linktoservices" href="{{route('servicios')}}">
                        <img src="{{URL::asset('/assets/Posteria/P-10.jpg')}}" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>@lang('galeria.tipos_trabajo3')</h4>
                            {{-- <p>Lorem ipsum, dolor sit amet consectetur</p> --}}
                            <a href="{{URL::asset('/assets/Posteria/P-10.jpg')}}" title="Repairs 2"
                                data-gallery="portfolio-gallery-poles" class="glightbox preview-link"><i
                                    class="bi bi-zoom-in"></i></a>
      
                                    </a>
                        </div>
                    </div>
                </div><!-- End Projects Item -->

                <div class="col-lg-4 col-md-6 portfolio-item filter-gpon"
>                    <div class="portfolio-content h-100">
    <a class="linktoservices" href="{{route('servicios')}}">
                        <img src="{{URL::asset('/assets/Fusion/F-1.jpg')}}" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>@lang('galeria.tipos_trabajo2')</h4>
                            {{-- <p>Lorem ipsum, dolor sit amet consectetur</p> --}}
                            <a href="{{URL::asset('/assets/Fusion/F-1.jpg')}}" title="Remodeling 3"
                                data-gallery="portfolio-gallery-gpon" class="glightbox preview-link"><i
                                    class="bi bi-zoom-in"></i></a>
                          
      
      </a>                          </div>
                    </div>
                </div><!-- End Projects Item -->

                <div class="col-lg-4 col-md-6 portfolio-item filter-gpon"
>                    <div class="portfolio-content h-100">
    <a class="linktoservices" href="{{route('servicios')}}">
                        <img src="{{URL::asset('/assets/Fusion/CA-6.jpg')}}" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>@lang('galeria.tipos_trabajo2')</h4>
                            {{-- <p>Lorem ipsum, dolor sit amet consectetur</p> --}}
                    <a href="{{URL::asset('/assets/Fusion/CA-6.jpg')}}" title="Construction 3"
                                data-gallery="portfolio-gallery-gpon" class="glightbox preview-link"><i
                                    class="bi bi-zoom-in"></i></a>
                          
      
      </a>                          </div>
                    </div>
                </div><!-- End Projects Item -->

                <div class="col-lg-4 col-md-6 portfolio-item filter-gpon"
>                    <div class="portfolio-content h-100">
    <a class="linktoservices" href="{{route('servicios')}}">
                        <img src="{{URL::asset('/assets/Fusion/F-2.jpg')}}" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>@lang('galeria.tipos_trabajo2')</h4>
                            {{-- <p>Lorem ipsum, dolor sit amet consectetur</p> --}}
                            <a href="{{URL::asset('/assets/Fusion/F-2.jpg')}}" title="Repairs 2"
                                data-gallery="portfolio-gallery-gpon" class="glightbox preview-link"><i
                                    class="bi bi-zoom-in"></i></a>
                          
      
      </a>                          </div>
                    </div>
                </div><!-- End Projects Item -->

                <div class="col-lg-4 col-md-6 portfolio-item filter-gpon"
>                    <div class="portfolio-content h-100">
    <a class="linktoservices" href="{{route('servicios')}}">
                        <img src="{{URL::asset('/assets/Fusion/F-8.jpg')}}" class="img-fluid" alt="">
                        <div class="portfolio-info">
                            <h4>@lang('galeria.tipos_trabajo2')</h4>
                            {{-- <p>Lorem ipsum, dolor sit amet consectetur</p> --}}
                            <a href="{{URL::asset('/assets/Fusion/F-8.jpg')}}" title="Repairs 3"
                                data-gallery="portfolio-gallery-gpon" class="glightbox preview-link"><i
                                    class="bi bi-zoom-in"></i></a>
                          
      
      </a>                          </div>
                    </div>
                </div><!-- End Projects Item -->

            </div><!-- End Projects Container -->

        </div>

    </div>
</section>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
  $('.portfolio-flters li').on('click', function() {
    $('.portfolio-flters li').removeClass('filter-active');
    $(this).addClass('filter-active');

    var selectedFilter = $(this).data('filter');
    if (selectedFilter === '*') {
      $('.portfolio-item').show();
    } else {
      $('.portfolio-item').hide();
      $(selectedFilter).show();
    }
  });
});
</script>
@endsection