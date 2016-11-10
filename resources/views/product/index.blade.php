@extends('home.index')

@section('content')
<div class="row">
  <div class="col s12 m12 l12">
    <div class="card-panel">
      <span>
        <div class="row">
          <div class="col s12 l4">
            <img style="width: 100%;" src="{{ $image }}">
          </div>
          <div class="col l8">
            <div class="">
              <h5>{{ $product->name }}</h5>
              @foreach ($tags as $tag)
              <div class="chip">
                {{ $tag }}
              </div>
              @endforeach

              <!--<div style="position: absolute; bottom: 20%;">-->
              <div class="">
                <h5>Seu produto vale:</h5>
                <h1 style="margin: 0 0 6px 0;">R$ {{ $valor }}</h1>
              </div>

            </div>
            <div class="card-action">
              <a href="#"><i class="mdi mdi-heart mdi-24px"></i></a>
              <a href="#"><i class="mdi mdi-share-variant mdi-24px"></i></a>
            </div>
          </div>
        </div>
      </span>
    </div>
  </div>
</div>
@endsection
