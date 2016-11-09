@extends('home.index')

@section('content')
<div class="row">
  <div class="col s12 l12">
    <div class="card horizontal">
      <div class="card-image">
        <img height="400" src="{{ $image }}">
      </div>
      <div class="card-stacked">
        <div class="card-content">
          <h5>{{ $product->name }}</h5>
          @foreach ($tags as $tag)
              <div class="chip">
                {{ $tag }}
              </div>
          @endforeach

          <br>
          <h1>{{ $valor }}</h1>



        </div>
        <div class="card-action">
          <a href="#">COMPARTILHAR</a>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection
