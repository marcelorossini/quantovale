@extends('home.index')

@section('content')
<div class="row">
	<div class="col s12 m12 l12">
		<div class="card-panel">
			<span>
				<h5>Resultados para: "{{ $keyword }}"</h5>
				<hr>
				<table class="bordered highlight">
					<tbody>
						@forelse ($products as $product)
						<tr style="display: block;">
							<td width="90"><img height="90" src="{{ route('getProductImage',[$product->id,'bcp_600x600.jpg']) }}"></td>
							<td><h5><a href="{{ route('getProduct',[$product->id,$product->name]) }}">{{ $product->name }}</a></h5></td>
							<td></td>
						</tr>
						@empty
						<tr>
							<td>Desculpe, não encontramos nada :(</td>
						</tr>
						@endforelse
					</tbody>
				</table>
			</span>
		</div>
	</div>
</div>
@endsection
