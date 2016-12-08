@extends('home.index')

@section('content')
<div class="row">
	<div class="col s12 m12 l12">
		<div class="card-panel">
			<span>
				<h5>Favoritos</h5>
				<hr>
				<table class="bordered highlight">
					<tbody>
						@forelse ($aResults as $result)
						<tr class="hide-on-small-only" style="display: block;">
							<td width="90"><img height="90" src="{{ route('getProductImage',[$result->id,'bcp_600x600.jpg']) }}"></td>
							<td>
								<h5><a href="{{ route('getShare',[$result->id_result]) }}">{{ $result->name }}</a></h5>
								<h6>Criado em {{ date('d/m/Y',strtotime($result->created_at)) }} ás {{ date('H:i:s',strtotime($result->created_at)) }}</h6>
							</td>
						</tr>

						<tr class="hide-on-med-and-up" style="display: block;">
							<td>
								<div class="row">
									<div class="col s12 center">
										<img width="80%" src="{{ route('getProductImage',[$result->id,'bcp_600x600.jpg']) }}">
									</div>
								</div>
								<div class="row">
									<div class="col s12">
										<h5><a href="{{ route('getShare',[$result->id_result]) }}">{{ $result->name }}</a></h5>
										<h6>Criado em {{ date('d/m/Y',strtotime($result->created_at)) }} ás {{ date('H:i:s',strtotime($result->created_at)) }}</h6>
									</div>
								</div>
							</td>
						</tr>
						@empty
						<tr>
							<td>Você ainda não favoritou nenhum produto :(</td>
						</tr>
						@endforelse
					</tbody>
				</table>
			</span>
		</div>
	</div>
</div>
@endsection
