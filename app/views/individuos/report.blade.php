@extends('templates.report')

@section('MAIN')

@if(count($individuo) > 0)

  <table class="table-report">
    <thead>
      <tr>
        <th>{{ trans('individuos.lbl.individuo') }}</th>
        <th>{{ trans('individuos.lbl.sexo') }}</th>
        <th>{{ trans('individuos.lbl.telefone') }}</th>
        <th>{{ trans('individuos.lbl.bairro') }}</th>
        <th>{{ trans('individuos.lbl.data_nascimento') }}</th>
        <th>{{ trans('individuos.lbl.acompanhante') }}</th>
        <th>{{ trans('individuos.lbl.comportamento_funcional') }}</th>
        <th>{{ trans('individuos.lbl.parecer') }}</th>
        <th>{{ trans('individuos.lbl.tecnico') }}</th>
        <th>{{ trans('individuos.lbl.data_parecer') }}</th>
        <th>{{ trans('individuos.lbl.total') }}</th>
      </tr>
    </thead>

    <tbody>

      @foreach ($individuo as $key => $value)

        <tr>
          <td>
            {{ $value->nome }}
          </td>
          <td>
            {{ $value->sexo->tipo }}
          </td>
          <td>
            {{ $value->telefonesFormatados() }}
          </td>
          <td>
            @if(isset($value->endereco->bairro))
              {{ $value->endereco->bairro }}
            @else
              não cadastrado
            @endif
          </td>
          <td>
            {{ $value->data_nascimento }}
          </td>
          <td>
            @if(isset($value->parecerTecnico->acompanhante) && $value->parecerTecnico->acompanhante != '')
              Necessita de acompanhante
            @elseif(isset($value->parecerTecnico->parecer) && $value->parecerTecnico->acompanhante == '')
              Não necessita de acompanhante
            @elseif(!isset($value->parecerTecnico->parecer))
              Sem parecer
            @endif
          </td>
          <td>
            @if(isset($value->parecerTecnico->comportamento_funcional) && $value->parecerTecnico->comportamento_funcional != '')
              Apresenta comportamento funcional
            @elseif(isset($value->parecerTecnico->parecer) && $value->parecerTecnico->comportamento_funcional == '')
              Não tem comportamento funcional
            @elseif(!isset($value->parecerTecnico->parecer))
              Sem parecer
            @endif
          </td>
          <td>
            @if(isset($value->parecerTecnico->parecer) && $value->parecerTecnico->parecer != '')
              {{ $value->parecerTecnico->parecer }}
            @else
              Sem parecer
            @endif
          </td>
          <td>
            @if(isset($value->parecerTecnico->user_id) && $value->parecerTecnico->user_id != '')
              {{ $value->parecerTecnico->user->name }}
            @else
              Sem técnico
            @endif
          </td>
          <td>
            @if(isset($value->parecerTecnico->created_at) && $value->parecerTecnico->created_at != '')
              {{ FormatterHelper::dateToPtBR($value->parecerTecnico->created_at) }}
            @else
              Sem data de parecer
            @endif
          </td>
          <td>
            @if( $key == 0 )
              {{ count($individuo) }}
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
