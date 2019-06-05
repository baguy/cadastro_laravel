<!-- Estudo e trabalho -->
<div class="container">
  <div class="row">
    <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#interditadojudicialmente"><i class="fas fa-chevron-down"></i></button>
    <h5 style="margin-top:5px;margin-left:5px;"> <i class="fas fa-gavel"></i> {{trans('individuos.lbl.interditado')}}</h5>
  </div>

  <div id="interditadojudicialmente" class="collapse">

      <div class="form-group" >

        <p style="margin-top:10px;">
          {{trans('individuos.lbl.instrumento_judicial')}}
        </p>

          <div class='row'>

          <!-- Curador -->
            <div class="col-12 {{ ($errors->has('instituicao')) ? 'has-error' : '' }}">
              {{ Form::label('curador', trans('individuos.lbl.curador')) }}
              {{ Form::text(
                  'curador',
                  isset($data['individuo']->interditado->curador)? $data['individuo']->interditado->curador : null,
                  array(
                    'class' => 'form-control',
                  )
                )
              }}
            </div>

        </div><!-- .Row -->

     </div><!-- Form-group -->

  </div><!-- .Collapse -->

</div><!-- .Container -->
