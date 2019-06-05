@extends('templates.report')

@section('MAIN')

@if(count($atendimento) > 0)

  <table class="table-report">
    <thead>
      <tr>
        <th>{{ trans('atendimento.lbl.titulo') }}</th>
        <th>{{ trans('atendimento.lbl.status') }}</th>
        <th>{{ trans('atendimento.lbl.requerente') }}</th>
        <th>{{ trans('atendimento.lbl.categoria') }}</th>
        <th>{{ trans('setor.setor') }}</th>
        <th>{{ trans('individuos.lbl.endereco') }}</th>
        <th>{{ trans('individuos.lbl.bairro') }}</th>
        <th>{{ trans('individuos.lbl.cadastro') }}</th>
        <th>{{ trans('application.lbl.updated-at') }}</th>
        <th>{{ trans('atendimento.lbl.descricao') }}</th>
        <th>{{ trans('atendimento.lbl.assentamentos') }}</th>
        <th>{{ trans('individuos.lbl.total') }}</th>
      </tr>
    </thead>

    <tbody>

      @foreach ($atendimento as $key => $value)

        <tr>
          <td>
            {{ $value->titulo }}
          </td>
          <td>
            {{ $value->status->tipo }}
          </td>
          <td>
            {{ $value->individuo->nome }}
          </td>
          <td>
            {{ $value->tipoAtendimentoFormatado() }}
          </td>
          <td>
            @if(isset($value->setor[0]))
              {{ $value->setorFormatado() }}
            @else
              não cadastrado
            @endif
          </td>
          <td>
            @if(isset($value->endereco->logradouro) && ($value->endereco->logradouro != ''))
              {{ $value->endereco->logradouro }}, {{ $value->endereco->numero }}
            @else
              não cadastrado
            @endif
          </td>
          <td>
            @if(isset($value->endereco->bairro) && ($value->endereco->bairro != ''))
              {{ $value->endereco->bairro }}
            @else
              não cadastrado
            @endif
          </td>
          <td>
            {{ FormatterHelper::dateTimeToPtBR($value->created_at) }}
          </td>
          <td>
            {{ FormatterHelper::dateTimeToPtBR($value->updated_at) }}
          </td>
          <td>
            {{ $value->descricao }}
          </td>
          <td>
            {{ count($value->assentamentos) }}
          </td>
          <td>
            @if( $key == 0 )
              {{ count($atendimento) }}
            @endif
          </td>
        </tr>

      @endforeach

    </tbody>
  </table>

@else

  <table class="table-report">
    <tbody>
      <tr>
        <td>{{ trans('application.msg.warn.no-records-found') }}</td>
      </tr>
    </tbody>
  </table>

@endif

@stop
