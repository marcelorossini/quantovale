@extends('home.index')

@section('content')
		<br>
		<h5>Resultados para: "{{ $keyword }}"</h5>

		@forelse ($products as $product)

				<div class="col s12 m7">
				    <div class="card horizontal">
				      <div class="card-image">
				        <img height="90" style="padding: 6px;" src="{{ route('getProductImage',[$product->id,'bcp_600x600.jpg']) }}">
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
