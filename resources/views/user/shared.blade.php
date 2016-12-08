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
						<tr style="display: block;">
							<td width="90"><img height="90" src="{{ route('getProductImage',[$result->id,'bcp_600x600.jpg']) }}"></td>
							<td>
								<h5><a href="{{ route('getShare',[$result->id_result]) }}">{{ $result->name }}</a></h5>
								<h6>Criado em {{ date('d/m/Y',strtotime($result->created_at)) }} ás {{ date('H:i:s',strtotime($result->created_at)) }}</h6>
								<h6>10 visualizações</h6>
								<br>
							</td>
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
