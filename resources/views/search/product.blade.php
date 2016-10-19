@extends('home.index')

@section('content')
		Resultados para: "{{ $keyword }}" <br>
		<br>
		@forelse ($products as $product)
				<a href="{{ route('getProduct',$product->id) }}">{{ $product->name }}</a><br>
		@empty
		    <p>Desculpe, não encontramos nada :(</p>
		@endforelse
@endsection
