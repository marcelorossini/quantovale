@extends('home.index')

@section('content')
<div class="row">
	<div class="col s12 m12 l12">
		<div class="card-panel">
			<span>
				<h5>Compartilhados</h5>
				<hr>
				<table class="bordered highlight">
					<tbody>
						@forelse ($aResults as $result)
						<tr class="hide-on-small-only" style="display: block;">
							<td width="90"><img height="90" src="{{ route('getProductImage',[$result->id,'bcp_600x600.jpg']) }}"></td>
							<td>
								<a href="{{ route('getShare',[$result->id_result]) }}">
									<h5>{{ $result->name }}</h5>
									<h6>Criado em {{ date('d/m/Y',strtotime($result->created_at)) }} ás {{ date('H:i:s',strtotime($result->created_at)) }}</h6>
									<h6>{{ $result->views }} visualizações</h6>
								</a>
								<br>
							</td>
						</tr>

						<tr class="hide-on-med-and-up" style="display: block;">
							<td>
								<a href="{{ route('getShare',[$result->id_result]) }}">
									<div class="row">
										<div class="col s12 center">
											<img width="80%" src="{{ route('getProductImage',[$result->id,'bcp_600x600.jpg']) }}">
										</div>
									</div>
									<div class="row">
										<div class="col s12">
											<h5>{{ $result->name }}</h5>
											<h6>Criado em {{ date('d/m/Y',strtotime($result->created_at)) }} ás {{ date('H:i:s',strtotime($result->created_at)) }}</h6>
											<h6>{{ $result->views }} visualizações</h6>
										</div>
									</div>
								</a>
							</td>
						</tr>
						@empty
						<tr>
							<td>Você ainda não compartilhou nenhum produto :(</td>
						</tr>
						@endforelse
					</tbody>
				</table>
			</span>
		</div>
	</div>
</div>
@endsection
