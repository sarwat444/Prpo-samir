
<?php foreach ($datas as $key => $value): ?>

  <div class="form-group">
        <div class="n-chk">
        <label class="new-control new-checkbox checkbox-primary">
          <input type="checkbox" class="new-control-input" value="{{$value->id}}" name="characters[]" >
          <span class="new-control-indicator"></span>{{$value->character_name}}
        </label>
      </div>
  </div>

<?php endforeach; ?>

@if($motive->animal == 1)

                                    <div class="form-group">


                                         <label> Animal </label>


                                             <div class="n-chk">
                                                     <label class="new-control new-radio radio-success">
                                                       <input type="radio" class="new-control-input" name="animal[]" value="1">
                                                       <span class="new-control-indicator"></span>Yes
                                                     </label>
                                               </div>

                                               <div class="n-chk">
                                                       <label class="new-control new-radio radio-primary">
                                                         <input type="radio" class="new-control-input" name="animal[]" value="2" >
                                                         <span class="new-control-indicator"></span>No
                                                       </label>
                                                 </div>





                                       </div>


@endif
