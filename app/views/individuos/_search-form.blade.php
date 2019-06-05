@extends('templates.search-panel')

@section('FORM')

  {{ Form::open(array('url' => '', 'id' => 'individuosFilterForm', 'method' => 'PUT')) }}

  <div class="form-row">

    <div class="form-group col-md-3">
      {{ Form::label('individuo', trans('individuos.lbl.individuo')) }}
      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i data-tooltip="tooltip" data-placement="top" title='Pesquise por nome ou cpf' class="fas fa-user fa-fw"></i>
          </span>
        </div>

        {{ Form::text(
            'S_individuo_id',
            null,
            array(
              'title' => 'NOME OU CPF',
              'class' => 'form-control individuo',
              'placeholder' => 'NOME OU CPF'
            )
          )
        }}

      </div>
    </div>


    <div class="form-group col-md-3">

      {{ Form::label('pre_cadastro', trans('individuos.lbl.pre_cadastro')) }}
      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i data-tooltip="tooltip" data-placement="top" title='Pré-cadastro realizado online' class="fas fa-file-alt fa-fw"></i>
          </span>
        </div>

        {{ Form::select(
            'S_pre_cadastro',
            $data['sim_nao'],
            null,
            array(
              'class' => 'form-control selectpicker pre_cadastro',
              'placeholder' => 'PRE-CADASTRO'
            )
          )
        }}

      </div>
    </div>


    <div class="form-group col-md-3">

      {{ Form::label('parecer', trans('individuos.lbl.parecer')) }}
      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i data-tooltip="tooltip" data-placement="top" title='Com ou sem parecer' class="fas fa-stamp fa-fw"></i>
          </span>
        </div>

        {{ Form::select(
            'S_parecer',
            $data['sim_nao'],
            null,
            array(
              'class' => 'form-control selectpicker parecer',
              'placeholder' => 'PARECER'
            )
          )
        }}

      </div>
    </div>


    <div class="form-group col-md-3">

      {{ Form::label('individuo', trans('individuos.lbl.status')) }}
      <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">
            <i class="fas fa-layer-group fa-fw" data-tooltip="tooltip" data-placement="top" title='Status ativo ou inativo'></i>
          </span>
        </div>

        {{ Form::select(
            'S_status_id',
            $data['status'],
            null,
            array(
              'class' => 'form-control',
              'placeholder' => 'SELECIONE'
            )
          )
        }}

      </div>
    </div>

</div>
<div class="form-row">

   <div class="form-group col-md-3">
     {{ Form::label('individuo', trans('individuos.lbl.sexo')) }}
      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i data-tooltip="tooltip" data-placement="top" title='SEXO' class="fas fa-transgender mr-1"></i>
          </span>
        </div>

        {{ Form::select(
            'S_sexo',
            $data['sexo'],
            null,
            array(
              'title' => 'SEXO',
              'data-live-search' => 'true',
              'class' => 'form-control selectpicker sexo'
            )
          )
        }}

      </div>
    </div>


    <div class="form-group col-md-3">

      {{ Form::label('individuo', trans('individuos.lbl.bairro')) }}
      <div class="input-group">

        <div class="input-group-prepend">
          <span class="input-group-text">
            <i data-tooltip="tooltip" data-placement="top" title='DIGITE AO MENOS TRÊS LETRAS DO BAIRRO' class="fas fa-city fa-fw"></i>
          </span>
        </div>

        {{ Form::text(
            'S_bairro',
            null,
            array(
              'class' => 'form-control selectpicker bairro',
              'data-live-search' => 'true',
              'placeholder' => 'INSIRA O BAIRRO'
            )
          )
        }}

      </div>
    </div>


    <div class="form-group col-md-3">
      {{ Form::label('mobilidade', trans('individuos.lbl.prob_mobilidade')) }}
       <div class="input-group">

         <div class="input-group-prepend">
           <span class="input-group-text">
             <i data-tooltip="tooltip" data-placement="top" title='PROBLEMA DE MOBILIDADE' class="fas fa-walking"></i>
           </span>
         </div>

         {{ Form::select(
             'S_mobilidade',
             $data['sim_nao'],
             null,
             array(
               'title' => 'PROBLEMA DE MOBILIDADE',
               'data-live-search' => 'true',
               'class' => 'form-control selectpicker mobilidade'
             )
           )
         }}

       </div>
     </div>


    <div class="form-group col-md-3">
      {{ Form::label('individuo', trans('individuos.lbl.deficiencia_fisica')) }}
       <div class="input-group">

         <div class="input-group-prepend">
           <span class="input-group-text">
             <i data-tooltip="tooltip" data-placement="top" title='DEFICIÊNCIA FÍSICA' class="fas fa-wheelchair"></i>
           </span>
         </div>

         {{ Form::select(
             'S_def_fisica',
             $data['sim_nao'],
             null,
             array(
               'title' => 'DEFICIÊNCIA FÍSICA',
               'data-live-search' => 'true',
               'class' => 'form-control selectpicker deficiencia_fisica'
             )
           )
         }}

       </div>
     </div>


  </div>
  <div class="form-row">

    <div class="form-group col-md-3">
      {{ Form::label('individuo', trans('individuos.lbl.deficiencia_auditiva')) }}
       <div class="input-group">

         <div class="input-group-prepend">
           <span class="input-group-text">
             <i data-tooltip="tooltip" data-placement="top" title='DEFICIÊNCIA AUDITIVA' class="fas fa-deaf"></i>
           </span>
         </div>

         {{ Form::select(
             'S_def_auditiva',
             $data['sim_nao'],
             null,
             array(
               'title' => 'DEFICIÊNCIA AUDITIVA',
               'data-live-search' => 'true',
               'class' => 'form-control selectpicker deficiencia_auditiva'
             )
           )
         }}

       </div>
     </div>


     <div class="form-group col-md-3">
       {{ Form::label('individuo', trans('individuos.lbl.deficiencia_visual')) }}
        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i data-tooltip="tooltip" data-placement="top" title='DEFICIÊNCIA VISUAL' class="fas fa-blind"></i>
            </span>
          </div>

          {{ Form::select(
              'S_def_visual',
              $data['sim_nao'],
              null,
              array(
                'title' => 'DEFICIÊNCIA FÍSICA',
                'data-live-search' => 'true',
                'class' => 'form-control selectpicker deficiencia_visual'
              )
            )
          }}

        </div>
      </div>


     <div class="form-group col-md-3">
       {{ Form::label('individuo', trans('individuos.lbl.deficiencia_mental')) }}
        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i data-tooltip="tooltip" data-placement="top" title='DEFICIÊNCIA MENTAL' class="fas fa-brain"></i>
            </span>
          </div>

          {{ Form::select(
              'S_def_mental',
              $data['sim_nao'],
              null,
              array(
                'title' => 'DEFICIÊNCIA MENTAL',
                'data-live-search' => 'true',
                'placeholder' => 'MENTAL',
                'class' => 'form-control selectpicker deficiencia_mental'
              )
            )
          }}

        </div>
      </div>


      <div class="form-group col-md-3">
        {{ Form::label('individuo', trans('individuos.lbl.deficiencia_psicossocial')) }}
         <div class="input-group">

           <div class="input-group-prepend">
             <span class="input-group-text">
               <i data-tooltip="tooltip" data-placement="top" title='DEFICIÊNCIA PSICOSSOCIAL' class="fas fa-user-circle"></i>
             </span>
           </div>

           {{ Form::select(
               'S_def_psicossocial',
               $data['sim_nao'],
               null,
               array(
                 'title' => 'DEFICIÊNCIA PSICOSSOCIAL',
                 'placeholder' => 'MENTAL',
                 'class' => 'form-control selectpicker deficiencia_psicossocial'
               )
             )
           }}

         </div>
       </div>


  </div>

  <div class='form-row'>

    <div class="form-group col-md-3">
      {{ Form::label('interditado', trans('individuos.lbl.interditado')) }}
       <div class="input-group">

         <div class="input-group-prepend">
           <span class="input-group-text">
             <i data-tooltip="tooltip" data-placement="top" title='POSSUI CURADOR(A)' class="fas fa-gavel"></i>
           </span>
         </div>

         {{ Form::select(
             'S_interditado',
             $data['sim_nao'],
             null,
             array(
               'title' => 'data',
               'class' => 'form-control',
             )
           )
         }}

       </div>
     </div>


    <div class="form-group col-md-3">
      {{ Form::label('individuo', trans('individuos.lbl.idoso')) }}
       <div class="input-group">

         <div class="input-group-prepend">
           <span class="input-group-text">
             <i data-tooltip="tooltip" data-placement="top" title='Idoso ou não' class="fas fa-hourglass-half"></i>
           </span>
         </div>

         {{ Form::select(
             'S_ano_nascimento',
             $data['sim_nao'],
             null,
             array(
               'title' => 'data',
               'placeholder' => '0000',
               'class' => 'form-control',
               'maxlength' => '4'
             )
           )
         }}

       </div>
     </div>


     <div class="form-group col-md-3">
       {{ Form::label('individuo', trans('individuos.lbl.data_nascimento')) }}
        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i data-tooltip="tooltip" data-placement="top" title='Data de nascimento' class="fas fa-calendar-alt"></i>
            </span>
          </div>

          {{ Form::text(
              'S_data_nascimento',
              null,
              array(
                'title' => 'data',
                'placeholder' => '00/00/0000',
                'class' => 'form-control datas',
              )
            )
          }}

        </div>
      </div>


     <div class="form-group col-md-3">
       {{ Form::label('individuo', trans('individuos.lbl.cadastro')) }}
        <div class="input-group">

          <div class="input-group-prepend">
            <span class="input-group-text">
              <i data-tooltip="tooltip" data-placement="top" title='Data de cadastro do indivíduo' class="fas fa-calendar-day"></i>
            </span>
          </div>

          {{ Form::text(
              'S_data_cadastro',
              null,
              array(
                'title' => 'data',
                'placeholder' => '00/00/0000',
                'class' => 'form-control datas',
              )
            )
          }}

        </div>
      </div>


  </div>

  <div class="form-row">

    <div class="form-group col-md-12">

      {{ Form::submit(
          trans('application.btn.search'),
          array(
            'id' => 'individuosFilterSubmit',
            'class' => 'btn btn-info btn-sm float-right'
          )
        )
      }}

      {{ link_to_route(
          'individuos.index',
          trans('application.btn.clean'),
          null,
          array(
            'id'    => 'individuosFilterClean',
            'class' => 'btn btn-secondary btn-sm float-right mr-1'
          )
        )
      }}

      {{ link_to_route(
          'mapa_individuo.index',
          trans('application.btn.mapa'),
          null,
          array(
            'id'    => 'mapa_individuo',
            'class' => 'btn btn-secondary btn-sm float-right mr-1'
          )
        )
      }}

      <button onclick="printPage()" data-tooltip="tooltip" data-placement="top" title="{{ trans('application.lbl.print-this') }}" class="btn btn-secondary btn-sm float-right mr-1"><i class="fas fa-print"></i></button>

    </div>


  </div>

  {{ Form::close() }}

  @stop

<script>
  function printPage() {
    window.print();
  }
</script>
