<div class="container">
  <div class="row">
    <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#deficiencia"><i class="fas fa-chevron-down"></i></button>
    <h5 style="margin-top:5px;margin-left:5px;"> <i class="fas fa-wheelchair"></i> {{trans('individuos.lbl.deficiencia')}}</h5>
  </div>

  <div id="deficiencia" class="collapse">


    <!-- DEFICIÊNCIA AUDITIVA -->

  <br>
  <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
    <h5> <i class="fas fa-deaf"></i> {{trans('individuos.lbl.deficiencia_auditiva')}}</h5>
  </div>

  <?php $deficiencia_auditiva = ['deficiencia_auditiva'];
  if(Input::old('tipo_deficiencia_auditiva_id')!= NULL){$deficiencia_auditiva = Input::old('tipo_deficiencia_auditiva_id');}
  if( isset($data['individuo']) ){ if (!empty($deficiencia_auditiva_individuo[0]))
    { $deficiencia_auditiva = $deficiencia_auditiva_individuo; } }
  ?>

  <div class="form-group cloned-main">

    @foreach ($deficiencia_auditiva as $offset => $def_auditiva)

      <div class="deficiencia_auditiva cloned-div">

        <div class='form-row'>

           <div class="col-12">
             {{ Form::select(
               'tipo_deficiencia_auditiva_id['.$offset.']',
               $data['tipo_deficiencia_auditiva'],
               isset($def_auditiva->auditiva_id) ? $def_auditiva->auditiva_id : null,
               array(
                 'class' => 'form-control tipo_deficiencia_auditiva_id',
                 'title' => trans('individuos.plh.select_def')
                 )
               )
             }}
           </div>

         </div><!-- .row -->

       <div>
         @if(!empty($def_auditiva))
           @include('individuos/_deficiencia_info', array('deficiencia'=>$def_auditiva, 'offset' => $offset, 'var' => 'deficienciaAuditiva', 'icone'=>'<i class="fas fa-deaf"></i>'))
         @else
           <?php $def_auditiva = null; ?>
           @include('individuos/_deficiencia_info', array('deficiencia'=>$def_auditiva, 'offset' => $offset, 'var' => 'deficienciaAuditiva', 'icone'=>'<i class="fas fa-deaf"></i>'))
         @endif
       </div>

     </div><!-- .cloned-div -->

      @endforeach

      @include('individuos/_add-clone', array('icone'=>'<i class="fas fa-deaf"></i>'))

    </div><!-- .cloned-main -->


    <!-- DEFICIÊNCIA FÍSICA -->

    <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
      <h5> <i class="fas fa-wheelchair"></i> {{trans('individuos.lbl.deficiencia_fisica')}}</h5>
    </div>

    <?php $deficiencia_fisica = ['deficiencia_fisica'];
    if(Input::old('tipo_deficiencia_fisica_id')!= NULL){$deficiencia_fisica = Input::old('tipo_deficiencia_fisica_id');}
    if( isset($data['individuo']) ){ if (!empty($deficiencia_fisica_individuo[0]))
      { $deficiencia_fisica = $deficiencia_fisica_individuo; } }
    ?>

    <div class="form-group cloned-main">

      @foreach ($deficiencia_fisica as $offset => $def_fisica)

        <div class="deficiencia_fisica cloned-div">

          <div class='form-row'>

             <div class="col-12">
               {{ Form::select(
                 'tipo_deficiencia_fisica_id['.$offset.']',
                 $data['tipo_deficiencia_fisica'],
                 isset($def_fisica->fisica_id) ? $def_fisica->fisica_id : null,
                 array(
                   'class' => 'form-control tipo_deficiencia_fisica_id',
                   'title' => trans('individuos.plh.select_def')
                   )
                 )
               }}
             </div>

           </div><!-- .row -->

           <div>
             @if(!empty($def_fisica))
               @include('individuos/_deficiencia_info', array('deficiencia'=>$def_fisica, 'offset' => $offset, 'var' => 'deficienciaFisica', 'icone'=>'<i class="fas fa-wheelchair"></i>'))
             @else
               <?php $def_fisica = null; ?>
               @include('individuos/_deficiencia_info', array('deficiencia'=>$def_fisica, 'offset' => $offset, 'var' => 'deficienciaFisica', 'icone'=>'<i class="fas fa-wheelchair"></i>'))
             @endif
           </div>

        </div><!-- .cloned-div -->

        @endforeach

        @include('individuos/_add-clone', array('icone'=>'<i class="fas fa-wheelchair"></i>'))

      </div><!-- .cloned-main -->


      <!-- DEFICIÊNCIA MENTAL -->

      <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
        <h5> <i class="fas fa-brain"></i> {{trans('individuos.lbl.deficiencia_mental')}}</h5>
      </div>

      <?php $deficiencia_mental = ['deficiencia_mental'];
      if(Input::old('tipo_deficiencia_mental_id')!= NULL){$deficiencia_mental = Input::old('tipo_deficiencia_mental_id');}
      if( isset($data['individuo']) ){ if (!empty($deficiencia_mental_individuo[0]))
        { $deficiencia_mental = $deficiencia_mental_individuo; } }
      ?>

      <div class="form-group cloned-main">

        @foreach ($deficiencia_mental as $offset => $def_mental)

          <div class="deficiencia_mental cloned-div">

            <div class='form-row'>

               <div class="col-12">
                 {{ Form::select(
                   'tipo_deficiencia_mental_id['.$offset.']',
                   $data['tipo_deficiencia_mental'],
                   isset($def_mental->mental_id) ? $def_mental->mental_id : null,
                   array(
                     'class' => 'form-control tipo_deficiencia_mental_id',
                     'title' => trans('individuos.plh.select_def')
                     )
                   )
                 }}
               </div>

             </div><!-- .row -->

             <div>
               @if(!empty($def_mental))
                 @include('individuos/_deficiencia_info', array('deficiencia'=>$def_mental, 'offset' => $offset, 'var' => 'deficienciaMental', 'icone'=>'<i class="fas fa-brain"></i>'))
               @else
                 <?php $def_mental = null; ?>
                 @include('individuos/_deficiencia_info', array('deficiencia'=>$def_mental, 'offset' => $offset, 'var' => 'deficienciaMental', 'icone'=>'<i class="fas fa-brain"></i>'))
               @endif
             </div>

          </div><!-- .cloned-div -->

          @endforeach

          @include('individuos/_add-clone', array('icone'=>'<i class="fas fa-brain"></i>'))

        </div><!-- .cloned-main -->


        <!-- DEFICIÊNCIA PSICOSSOCIAL -->

        <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
          <h5> <i class="fas fa-user-circle"></i> {{trans('individuos.lbl.deficiencia_psicossocial')}}</h5>
        </div>

        <?php $deficiencia_psicossocial = ['deficiencia_psicossocial'];
        if(Input::old('tipo_deficiencia_psicossocial_id')!= NULL){$deficiencia_psicossocial = Input::old('tipo_deficiencia_psicossocial_id');}
        if( isset($data['individuo']) ){ if (!empty($deficiencia_psicossocial_individuo[0]))
          { $deficiencia_psicossocial = $deficiencia_psicossocial_individuo; } }
        ?>

        <div class="form-group cloned-main">

          @foreach ($deficiencia_psicossocial as $offset => $def_psico)

            <div class="deficiencia_psicossocial cloned-div">

              <div class='form-row'>

                 <div class="col-12">
                   {{ Form::select(
                     'tipo_deficiencia_psicossocial_id['.$offset.']',
                     $data['tipo_deficiencia_psicossocial'],
                     isset($def_psico->psicossocial_id) ? $def_psico->psicossocial_id : null,
                     array(
                       'class' => 'form-control tipo_deficiencia_psicossocial_id',
                       'title' => trans('individuos.plh.select_def')
                       )
                     )
                   }}
                 </div>

               </div><!-- .row -->

               <div>
                 @if(!empty($def_psico))
                   @include('individuos/_deficiencia_info', array('deficiencia'=>$def_psico, 'offset' => $offset, 'var' => 'deficienciaPsicossocial', 'icone'=>'<i class="fas fa-user-circle"></i>'))
                 @else
                   <?php $def_psico = null; ?>
                   @include('individuos/_deficiencia_info', array('deficiencia'=>$def_psico, 'offset' => $offset, 'var' => 'deficienciaPsicossocial', 'icone'=>'<i class="fas fa-user-circle"></i>'))
                 @endif
               </div>

            </div><!-- .cloned-div -->

            @endforeach

            @include('individuos/_add-clone', array('icone'=>'<i class="fas fa-user-circle"></i>'))

          </div><!-- .cloned-main -->


          <!-- DEFICIÊNCIA VISUAL -->

          <div class="form-group" style="background-color:#02302b; height:35px; width:100%; padding-top:5px; padding-left:20px; color:white;">
            <h5> <i class="fas fa-blind"></i> {{trans('individuos.lbl.deficiencia_visual')}}</h5>
          </div>

          <?php $deficiencia_visual = ['deficiencia_visual'];
          if(Input::old('tipo_deficiencia_visual_id')!= NULL){$deficiencia_visual = Input::old('tipo_deficiencia_visual_id');}
          if( isset($data['individuo']) ){ if (!empty($deficiencia_visual_individuo[0]))
            { $deficiencia_visual = $deficiencia_visual_individuo; } }
          ?>

          <div class="form-group cloned-main">

            @foreach ($deficiencia_visual as $offset => $def_visual)

              <div class="deficiencia_visual cloned-div">

                <div class='form-row'>

                   <div class="col-12">
                     {{ Form::select(
                       'tipo_deficiencia_visual_id['.$offset.']',
                       $data['tipo_deficiencia_visual'],
                       isset($def_visual->visual_id) ? $def_visual->visual_id : null,
                       array(
                         'class' => 'form-control tipo_deficiencia_visual_id',
                         'title' => trans('individuos.plh.select_def')
                         )
                       )
                     }}
                   </div>

                 </div><!-- .row -->

                 <div>
                   @if(!empty($def_visual))
                     @include('individuos/_deficiencia_info', array('deficiencia'=>$def_visual, 'offset' => $offset, 'var' => 'deficienciaVisual', 'icone'=>'<i class="fas fa-blind"></i>'))
                   @else
                     <?php $def_visual = null; ?>
                     @include('individuos/_deficiencia_info', array('deficiencia'=>$def_psico, 'offset' => $offset, 'var' => 'deficienciaVisual', 'icone'=>'<i class="fas fa-blind"></i>'))
                   @endif
                 </div>

              </div><!-- .cloned-div -->

              @endforeach

              @include('individuos/_add-clone', array('icone'=>'<i class="fas fa-blind"></i>'))

            </div><!-- .cloned-main -->


  </div><!-- .Collapse -->

</div><!-- .Container -->
