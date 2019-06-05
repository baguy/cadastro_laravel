<!-- Parentesco -->
  <div class="container">
    <div class="row">
      <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#parentesco"><i class="fas fa-chevron-down"></i></button>
      <h5 style="margin-top:5px;margin-left:5px;"> <i class="fas fa-child"></i> {{trans('individuos.lbl.parentesco_responsavel')}}</h5><span class="obrigatorio">*</span>
    </div>

    <div id="parentesco" class="collapse">

      <?php $parentesco = ['parentesco'];
      if(Input::old('nome_parente')!= NULL){$parentesco = Input::old('nome_parente');}
      if(isset($data['individuo'])){if (!empty($data['parentes'][0])) { $parentesco = $data['parentes'];}}
      ?>

        <div class="form-group cloned-main">

          @foreach ($parentesco as $key => $parente)

            <div class="parentesco cloned-div">

              <div class="row">
                <!-- Nome -->
                <div class="col-8 {{ ($errors->has('nome_parente')) ? 'has-error' : '' }}">
                  {{ Form::label('nome_parente', trans('individuos.lbl.nome')) }}<span class="obrigatorio">*</span>
                  {{ Form::text(
                      'nome_parente['.$key.']',
                      isset($parente->nome)? $parente->nome : null,
                      array(
                        'class'       => 'form-control nome do-not-ignore required',
                      )
                    )
                  }}
                  @if ($errors->has('nome_parente'))
                  <div class="invalid-feedback">
                    {{ $errors->first('nome_parente') }}
                  </div>
                  @endif
                </div>

                <!-- Vínculo -->
                <div class="col-4 {{ ($errors->has('vinculo')) ? 'has-error' : '' }}">
                  {{ Form::label('tipo_parentesco_id', trans('individuos.lbl.tipo_parentesco')) }}<span class="obrigatorio">*</span>
                  {{
                    Form::select(
                      'tipo_parentesco_id['.$key.']',
                      $data['tipo_parentesco'],
                      isset($parente->tipo_parentesco_id)? $parente->tipo_parentesco_id : null,
                      array("class"=>'form-control tipo_parentesco_id do-not-ignore required',
                  )
                    )
                  }}
                </div>

              </div><!-- .Row -->

              <div class='row'>

                <div class="col-8 {{ ($errors->has('endereco_parente')) ? 'has-error' : '' }}">
                  {{ Form::label('endereco_parente', trans('individuos.lbl.endereco')) }}
                  {{ Form::text(
                      'endereco_parente['.$key.']',
                      isset($parente->endereco)? $parente->endereco : null,
                      array(
                        'class' => 'form-control endereco_parente',
                      )
                    )
                  }}
                </div>

                <div class="col-4 {{ ($errors->has('bairro_parente')) ? 'has-error' : '' }}">
                  {{ Form::label('bairro_parente', trans('individuos.lbl.bairro')) }}
                  {{ Form::text(
                      'bairro_parente['.$key.']',
                      isset($parente->bairro)? $parente->bairro : null,
                      array(
                        'class'       => 'form-control bairro_parente',
                      )
                    )
                  }}
                </div>

              </div>

              <div class='row'>

                  <!-- Número do telefone — texto com máscara -->
                  <div class="col-5 {{ ($errors->has('telefone')) ? 'has-error' : '' }}">
                  {{ Form::label('telefone_parente', trans('individuos.lbl.telefone')) }}
                    <div>
                      {{
                        Form::text(
                          'telefone_parente['.$key.']',
                          isset($parente->telefone) ? $parente->telefone : null,
                          array(
                            'class' => 'form-control telefone_mask',
                            'placeholder' => trans('individuos.plh.telefone'),
                            'style' => 'margin-bottom:20px;',
                            'id' => 'telefone',
                          )
                        )
                      }}
                    </div>
                  </div>

                  <div class="col-6 {{ ($errors->has('email_parente')) ? 'has-error' : '' }}">
                    {{ Form::label('email_parente', trans('individuos.lbl.email')) }}
                    {{ Form::text(
                        'email_parente['.$key.']',
                        isset($parente->email) ? $parente->email : null,
                        array(
                          'class'       => 'form-control email_parente',
                          'placeholder' => trans('individuos.plh.email'),
                        )
                      )
                    }}
                  </div>

              <div class="col-md-1">
                {{
                  Form::button(
                    '<span><i class="fas fa-trash-alt"></i> <i class="fas fa-child"></i></span>',
                    array(
                      'class' => 'btn delCloned',
                      'style' => 'margin-bottom:20px;margin-top:32px;margin-left:10px'
                    )
                  )
                }}
              </div>

            </div><!-- .Row -->


          </div><!-- .cloned-div -->

          @endforeach

          @include('individuos/_add-clone', array('icone'=>'<i class="fas fa-child"></i>'))

        </div><!-- .cloned-main -->

    </div><!-- .Collapse -->

</div><!-- .Container -->
