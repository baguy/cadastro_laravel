{{ Form::model($data['individuo'], array('id' => 'IndividuoFormParecer', 'data-individuo_id' => $data['individuo']->id, 'method' => 'PUT', 'route' => array('individuos.parecer_update', $data['individuo']->id))) }}

  <div class="card">
    <div class="card-header">
      <h3 class="card-title" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">

          {{ trim(trans('application.action.parecer', ['icon' => '<i class="fas fa-stamp"></i>'])) }}

      </h3>
    </div>

    <div class="card-body">

      <!-- Parecer -->
      <?php $pareceres = ['parecer'];
        if(Input::old('parecer')!= NULL){$pareceres = Input::old('parecer');}
        if( isset($data['individuo']) ){ if (!empty($data['parecer'][0])) { $pareceres = $data['parecer'];} }
      ?>

        @foreach ($pareceres as $offset => $parecer)

          <!-- Parecer -->
          <div class="form-group {{ ($errors->has('parecer')) ? 'has-error' : '' }}">
            <div class='row'>
              <div class='col-4'>{{ Form::label('parecer', trans('individuos.lbl.parecer')) }} <b>{{$offset+1}}</b> <span class="obrigatorio"> *</span></div>
              @if(isset($parecer->user_id))
                <div class='col-6'>{{trans('individuos.lbl.tecnico')}} {{$parecer->user->name}}</div>
              @endif
              @if(isset($parecer->created_at))
                <div class='col-2'>{{ FormatterHelper::dateTimeToPtBR($parecer->created_at) }}</div>
              @endif
            </div>
            {{ Form::textarea(
                'parecer['.$offset.']',
                isset($parecer->parecer)? $parecer->parecer : null,
                array(
                  'class' => 'form-control parecer',
                  'rows' => 5,
                  'required',
                )
              )
            }}
          </div>

          <div class='row'>
            <div class='col-4'>

              {{ Form::checkbox(
                'acompanhante['.$offset.']',
                true, isset($parecer->acompanhante) ? true : null
              ) }}
              {{ Form::label('status_ensino', trans('individuos.lbl.acompanhante')) }}

            </div>

            <div class='col-4'>

              {{ Form::checkbox(
                'comportamento_funcional['.$offset.']',
                true, isset($parecer->comportamento_funcional) ? true : null
              ) }}
              {{ Form::label('status_ensino', trans('individuos.lbl.comportamento_funcional')) }}

            </div>

          </div>
          <br>
         @endforeach


         @if (!empty($data['parecer'][0]))
           <br>
           <hr>
           <?php $offset2 = (count($data['parecer'])) ?>

           <!-- Parecer -->
           <div class="form-group">
             <div class='row'>
               <div class='col-10'>{{ Form::label('parecer', trans('individuos.lbl.parecer')) }} <b>{{ 'novo' }}</b></div>
             </div>
             {{ Form::textarea(
                 'parecer['.$offset2.']',
                 null,
                 array(
                   'class' => 'form-control',
                   'rows' => 5,
                 )
               )
             }}
           </div>

           <div class='row'>
             <div class='col-4'>

               {{ Form::checkbox(
                 'acompanhante['.$offset2.']',
                 true, null
               ) }}
               {{ Form::label('status_ensino', trans('individuos.lbl.acompanhante')) }}

             </div>

             <div class='col-4'>

               {{ Form::checkbox(
                 'comportamento_funcional['.$offset2.']',
                 true, null
               ) }}
               {{ Form::label('status_ensino', trans('individuos.lbl.comportamento_funcional')) }}

             </div>
           </div>

         @endif


    <div class="card-footer text-right">
      <small>{{trans('application.msg.obrigatorio')}}<small> <span class="obrigatorio" style='padding-right:10px;'>*</span>

      {{
        link_to_route(
          'individuos.index',
          trans('application.btn.cancel'),
          null,
          array(
            'class' => 'btn btn-default'
          )
        )
      }}

      {{ Form::submit(trans('application.btn.save'), array('class' => 'btn btn-primary')) }}
    </div><!--.card-footer-->

  </div><!-- .card-body -->

</div><!--.card-->

{{ Form::close() }}
