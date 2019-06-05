<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Notificação — SEPEDI</h2>

		<div>

				{{-- Título --}}
				<h2>{{ $key['titulo'] }}</h2>

				{{-- <p><b>Categoria: </b> {{ ucwords(mb_strtolower($key->tipoAtendimentoFormatado(), 'UTF-8')) }}</p> --}}

				{{-- Descrição Atendimento --}}
				<div class="descricao">
					<b>Descrição: </b> {{ $key->descricao }}
				</div>

				<p>
					<b>Endereço: </b>
					@if(isset($key->endereco->logradouro))
						{{ ucwords(mb_strtolower($key->endereco->logradouro), 'UTF-8')}},
						{{ $key->endereco->numero }} —
						{{ $key->endereco->bairro }}
					@else
						Não informado
					@endif
				</p>
				@if(isset($key->endereco->complemento))
					<p> {{ $key->endereco->complemento }} </p>
				@endif

				{{-- Datas --}}
				<div>
					<span class="col-md-12">
						<b>{{ trans('application.lbl.created-at') }}: </b>
						<a>{{ FormatterHelper::dateTimeToPtBR($key->created_at) }}</a>
					</span>

					<span class="col-md-12">
						@if(strtotime($key->updated_at) > 0)
						<b>{{ trans('application.lbl.updated-at') }}: </b>
						<a>{{ FormatterHelper::dateTimeToPtBR($key->updated_at) }}</a>
						@endif
					</span>

					@if($key->deleted_at)
					<span class="col-md-12">
						<b>{{ trans('application.lbl.deleted-at') }}: </b>
						<a>{{ FormatterHelper::dateTimeToPtBR($key->deleted_at) }}</a>
					</span>
					@endif

					{{-- Autoria do atendimento --}}
					<span class="col-md-12">
						<b>{{ trans('atendimento.lbl.created-by') }}: </b>
						<a>{{ $key->user->name }}</a>
					</span>
				</div>

				<hr>

				{{-- Assentamentos --}}
				<h3>Assentamentos</h3>
				@if(count($key->assentamentos) >= 1)
					@foreach($key->assentamentos as $key => $assentamento)

					<div class="assentamento">
						<div class="row">
							<strong class="col-md-2">{{ $key+1 }}º {{ trans('atendimento.lbl.assentamento') }}</strong>

							<span class="col-md-10" style="text-align:right;">
								<b> — Criado em: </b>
								<a>{{ FormatterHelper::dateTimeToPtBR($assentamento->created_at) }}</a>
							</span>
						</div>

							<p>{{ $assentamento->descricao }}</p> <hr>

					</div>

					@endforeach
				@endif


		</div>
	</body>
</html>
