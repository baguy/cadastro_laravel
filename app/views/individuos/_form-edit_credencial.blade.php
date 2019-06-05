<!-- Credencial -->

  <div class="container">
    <div class="row">
      <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#credencial"><i class="fas fa-chevron-down"></i></button>
      <h5 style="margin-top:5px;margin-left:5px;"> <i class="fas fa-id-badge"></i> {{trans('individuos.lbl.credencial')}}</h5>
    </div>

    <div id="credencial" class="collapse">

        <div class="form-group">

          <div class='row'>

              @foreach( $data['tipo_credencial'] as $key => $tipo_credencial )
                <?php
                 $verdadeDesafio = 0 ;
                 $credencial = null;
                 if( isset($tipo_credencial->credencial->tipo_credencial_id) ){
                   if( $tipo_credencial->credencial->individuo_id == $data['individuo']->id ){
                     $verdadeDesafio = 1;
                     $credencial = $tipo_credencial->credencial->credencial;
                   }
                 }
               ?>


                <div class="form-group col-6">
                  {{ Form::checkbox('tipo_credencial_id[]',
                                  $tipo_credencial->id,
                                  $verdadeDesafio,
                                  array(
                                    'style' => 'margin-right:0px;margin-left:2px',
                                  ))
                  }}
                  {{ Form::label('tipo_credencial', $tipo_credencial->nome) }}
                </div>

                <div class="col-6">
                  {{ Form::text(
                      'credencial[]',
                      $credencial,
                      array(
                        'class' => 'form-control',
                      )
                    )
                  }}
                </div>

              @endforeach

            </div><!-- .Row -->


         </div><!-- Form-group -->

      </div><!-- .Collapse -->

    </div><!-- .Container -->
