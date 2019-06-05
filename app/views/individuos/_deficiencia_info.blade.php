<div class='row'>
  <!-- Data do laudo — text com máscara -->
        <div class="col-4 {{ ($errors->has('data_laudo')) ? 'has-error' : '' }}">
          {{ Form::label('data_laudo', trans('individuos.lbl.data_laudo')) }}
            {{ Form::text(
              'data_laudo_'.$var.'['.$offset.']',
              !empty($deficiencia->data_laudo) ? $deficiencia->data_laudo : null,
              array(
                'class'       => 'form-control data_laudo datas',
                'placeholder' => trans('individuos.plh.data_nascimento'),
              )
            )
          }}

        </div>

        <div class="col-4">

          {{ Form::label('quando_deficiencia', trans('individuos.lbl.quando_deficiencia')) }}

          {{ Form::select(
            'quando_'.$var.'['.$offset.']',
            $data['quando_deficiencia'],
            !empty($deficiencia->quando_id) ? $deficiencia->quando_id : null,
            array(
              'class' => 'form-control tipo_saude',
              'title' => 'SELECIONE'
              )
            )
          }}

        </div>

        <div class="col-4">

          {{ Form::label('causa_deficiencia', trans('individuos.lbl.causa_deficiencia')) }}

          {{ Form::select(
            'causa_'.$var.'['.$offset.']',
            $data['causa_deficiencia'],
            !empty($deficiencia->causa_id) ? ($deficiencia->causa_id) : null,
            array(
              'class' => 'form-control causa_deficiencia',
              'title' => 'SELECIONE'
              )
            )
          }}

        </div>
      </div><!-- .row -->

      <div class="row">
        <!-- Outro -->
        <div class="col-11 {{ ($errors->has('outro_deficiencia')) ? 'has-error' : '' }}">
          {{ Form::label('outro_tecnologia', trans('individuos.lbl.outro')) }}
          {{ Form::text(
              'outro_'.$var.'['.$offset.']',
              !empty($deficiencia->outro) ? $deficiencia->outro : null,
              array(
                'class' => 'form-control',
              )
            )
          }}
        </div>

        <div class="col-md-1">
          {{
            Form::button(
              '<span><i class="fas fa-trash-alt"></i> '. $icone .'</span>',
              array(
                'class' => 'btn delCloned',
                'style' => 'margin-bottom:20px;margin-top:32px;margin-left:10px'
              )
            )
          }}
        </div>

      </div><!-- .row -->
