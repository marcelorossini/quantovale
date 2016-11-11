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
                <div class="flow-text">Valor novo: R$ {{ $valor }}</div>
              </div>

            </div>
            <!--
            <div class="card-action">
              <a href="#"><i class="mdi mdi-heart mdi-24px"></i></a>
              <a href="#"><i class="mdi mdi-share-variant mdi-24px"></i></a>
            </div>
            -->
          </div>
        </div>
        <hr>
        <form action="#">
          <div class="row">
              <div class="col s12 l4">
                  <select>
                    <option value="" disabled selected>Estado da tela</option>
                    <option value="1">Perfeita</option>
                    <option value="2">Pequenos riscos</option>
                    <option value="3">Vários riscos</option>
                    <option value="3">Tricada</option>
                  </select>
              </div>
              <div class="col s12 l4">
                <p>
                    <input type="checkbox" id="test5" />
                    <label for="test5" style="display: block;">Red</label>
                </p>
              </div>
              <div class="col s12 l4">
                <input type="date" class="datepicker" placeholder="Data de compra">
              </div>
          </div>
        </form>
      </span>
    </div>
  </div>
</div>
@endsection
