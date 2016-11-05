@extends('home.index')

@section('content')
		<h5>Resultados para: "{{ $keyword }}"</h5> <br>
		<br>
		@forelse ($products as $product)

				<div class="col s12 m7">
				    <div class="card horizontal">
				      <div class="card-image">
				        <img src="">
				      </div>
				      <div class="card-stacked">
				        <div class="card-content">
									<h5><a href="{{ route('getProduct',$product->id) }}">{{ $product->name }}</a></h5>
				        </div>
				      </div>
				    </div>

			  </div>
		@empty
		    <p>Desculpe, não encontramos nada :(</p>
		@endforelse
@endsection
