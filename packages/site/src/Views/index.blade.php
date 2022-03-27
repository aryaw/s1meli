@extends('site::layouts.default')


@section('metadata')
@parent
<link href="{{ asset('assets/css/swiper.min.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('content')
<main class="hp">

    <section class="love-banner homepage">
      <div class="container">	
        <span class="text">
          JADIKAN
        </span>
        <span class="text large">
          VALENTINE
        </span>
        <h1 class="ripley">
          Special
        </h1>
        <p>
          Kencan spesial menantimu </br>dan pasanganmu! Tahun ini, </br>serahkan rencana Valentine-mu kepada kami.
        </p>
        <div class="btn-wrapper">
          <a href="{{ route('site.planmydate') }}" class="btn btn--primary btn--large" onclick="gaEvent('planmydate', 'planmydate home top', 'Planmydate Top Homepage')"> Rencana Kencan </br> Spesialku</a>
        </div>
      </div>
    </section>

    <section class="prize">
      <div class="container">
        <h2 class="bg">Hadiah</h2>
        <div class="prize__banner">
          <div class="swiper-container">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <img src="{{ asset('assets/img/prize (1).png') }}" alt="price 1">
              </div>
              <div class="swiper-slide">
                <img src="{{ asset('assets/img/prize (2).png') }}" alt="price 2">
              </div>
              <div class="swiper-slide">
                <img src="{{ asset('assets/img/prize (3).png') }}" alt="price 3">
              </div>
              <div class="swiper-slide">
                <img src="{{ asset('assets/img/prize (4).png') }}" alt="price 4">
              </div>
              <div class="swiper-slide">
                <img src="{{ asset('assets/img/prize (5).png') }}" alt="price 5">
              </div>
              <div class="swiper-slide">
                <img src="{{ asset('assets/img/prize (7).png') }}" alt="price 7">
              </div>
              <div class="swiper-slide">
                <img src="{{ asset('assets/img/prize (9).png') }}" alt="price 9">
              </div>
              <div class="swiper-slide">
                <img src="{{ asset('assets/img/prize (12).png') }}" alt="price 12">
              </div>
            </div>
            <button class="prev"></button>
            <button class="next"></button>
            <div class="swiper-pagination"></div>
          </div>
        </div>
        <p>
          7 Kencan Valentine Spesial</br>Total hadiah RATUSAN JUTA RUPIAH
        </p>
        <hr>
        <h2>Cara Untuk Ikut</h2>
        <div class="row steps">
          <div class="dc4 mc12">
            <figure>
              <img src="{{ asset('assets/img/step-1.png') }}" alt="step 1">
            </figure>
            <h6>
              RENCANAKAN
            </h6>
            <p>
              Rencanakan kencan </br> spesialmu disini.
            </p>
          </div>
          <div class="dc4 mc12">
            <figure>
              <img src="{{ asset('assets/img/step-2.png') }}" alt="step 2">
            </figure>
            <h6>
              DAFTAR
            </h6>
            <p>
              Daftarkan data dirimu.
            </p>
          </div>
          <div class="dc4 mc12">
            <figure>
              <img src="{{ asset('assets/img/step-3.png') }}" alt="step 3">
            </figure>
            <h6>
              BAGIKAN
            </h6>
            <p>
              Upload kencan special yang</br>
              kamu dapat ke media sosial!
            </p>
          </div>
        </div>
        <div class="btn-wrapper">
          <p>
            <a href="{{ route('site.term') }}">Syarat & Ketentuan</a>	
          </p>				
        </div>
        <div class="btn-wrapper">
          <a href="{{ route('site.planmydate') }}" class="btn btn--primary btn--large" onclick="gaEvent('planmydate', 'planmydate home bottom', 'Planmydate Bottom Homepage')">rencana kencan</br>spesialku</a>
        </div>
      </div>
    </section>
  </main>
@endsection

@section('site_script')
@parent
<script type="text/javascript" src="{{ asset('assets/js/swiper.min.js') }}"></script>
@endsection