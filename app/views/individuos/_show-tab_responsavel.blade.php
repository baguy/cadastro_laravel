<!-- Responsável -->
@if( isset($individuo->parentescos[0]) )
  <h5 style='padding-left: 64px;'><i class="fas fa-child"></i><b> Parente ou Responsável</b></h5>
    @foreach( $individuo->parentescos as $key => $value )
      <p>
        <div class='row'>
          <div class='col-9'>
            {{ $value->nome }}
            @if($value->telefone)
              —
              {{ $value->telefone }}
            @endif
          </div>
          <div class='col-3'>
            <b>Vínculo</b> {{ $value->tipoParentesco->nome }}
          </div>
      </div>
    </p>
    @endforeach

  <hr>
@endif

<!-- Interditado judicialmente -->
@if( $individuo->interditado != '' )
  @if( $individuo->interditado->curador != '' )
    <h5 style='padding-left: 64px;'><i class="fas fa-gavel"></i><b> Interditado Judicialmente</b></h5>
    <p><b>Curador </b> {{ $individuo->interditado->curador }}</p>

  @endif
@endif
