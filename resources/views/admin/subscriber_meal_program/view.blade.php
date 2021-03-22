
<div class="modal-header">
   <h4 class="text-center">Meal Program from <b>{{date('d-m-Y',strtotime($subscriber->start_date))}}</b>  to  <b>{{date('d-m-Y',strtotime($subscriber->expiry_date))}}</b></h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body" style="
    border: 5px double;
    margin: 20px;
">
   <div class="row"> 
                  <div class="col-md-12">
                        <div class="box-body">
                           <div class="form-group">
                           <h4 class="box-title">
                              <b>Subscriber Name: </b> {{ucfirst($subscriber->subscriber_name)}} 
                           </h4>
                          </div>
                        </div>
                     </div>
                     <div class="col-md-12">
                        <div class="box-body">
                           <div class="form-group">
                           <label for="">Subscription Plan: </label> {{$subscriber->sub_name}} 
                          </div>
                        </div>
                     </div>
                  </div>
                  <div class="row">  
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="">BMI<span style="color:red;" >*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon btn-default">
                              BMI
                            </div>
                            <input type="text" class="form-control"  id="bmi" name="bmi" required="true" data-parsley-errors-container="#bmi_error" data-parsley-error-message="Please enter bmi." value="{{ isset($health_details) ? ($health_details->bmi) : ('NA') }}" disabled>
                            <input type="hidden" name="subscriber_id" value="{{$subscriber_id}}">
                            <input type="hidden" name="nutritionist_id" value="{{$nutritionist_id}}">
                          </div>
                          <div id="bmi_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="">BMR<span style="color:red;" >*</span></label>
                         <div class="input-group">
                          <div class="input-group-addon btn-default">
                            BRM
                          </div>
                          <input type="text" class="form-control" "Enter BMR" id="bmr" name="bmr" required="true" data-parsley-errors-container="#bmr_error" data-parsley-error-message="Please enter bmr." value="{{ isset($health_details) ? ($health_details->bmr) : ('NA') }}" disabled>
                        </div>
                        <div id="bmr_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="">Current Weight<span style="color:red;" >*</span></label>
                        <div class="input-group">
                          <div class="input-group-addon btn-default">
                            <i class="fa fa-balance-scale"></i>
                          </div>
                          <input type="text" class="form-control" "Enter Current Weight" id="current_wt" name="current_wt" required="true" data-parsley-errors-container="#weight_error" data-parsley-error-message="Please enter weight." value="{{ isset($health_details) ? ($health_details->current_wt) : ('NA') }}" disabled>
                        </div>
                        <div id="weight_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
              </div>
              <div class="row">  
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="">Body Fat<span style="color:red;" >*</span></label>
                     <div class="input-group">
                          <div class="input-group-addon btn-default">
                            <img  src="{{ url('/')}}/uploads/images/fat.png" alt="your image" width="20" height="20"/>
                          </div>
                          <input type="text" class="form-control" "Enter Body Fats" id="body_fat" name="body_fat" required="true" data-parsley-errors-container="#fats_error" data-parsley-error-message="Please enter body fats." value="{{ isset($health_details) ? ($health_details->body_fat) : ('NA') }}" disabled>
                        </div>
                        <div id="fats_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="">Req.Calories<span style="color:red;" >*</span></label>
                      <div class="input-group">
                        <div class="input-group-addon btn-default"><img  src="{{ url('/')}}/uploads/images/calories.svg" alt="your image" width="20" height="20"/></div>
                        <input type="text" class="form-control" "Enter required calories" id="req_calories" name="req_calories" required="true" data-parsley-errors-container="#calories_error" data-parsley-error-message="Please enter calories." value="{{ isset($health_details) ? ($health_details->req_calories) : ('NA') }}" disabled></div>
                       <div id="calories_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
              </div>
              <hr/>
              <div class="row">  
                <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="">Protine<span style="color:red;" >*</span></label>
                      <div class="input-group">
                        <div class="input-group-addon btn-default"> <img  src="{{ url('/')}}/uploads/images/protein.svg" alt="your image" width="20" height="20"/></div>
                        <input type="text" class="form-control" "Enter required protein" id="protein" name="protein" required="true" data-parsley-errors-container="#protein_error" data-parsley-error-message="Please enter protein." value="{{ isset($health_details) ? ($health_details->protein) : ('NA') }}" disabled></div>
                       <div id="protein_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="">fat<span style="color:red;" >*</span></label>
                      <div class="input-group">
                        <div class="input-group-addon btn-default"><img  src="{{ url('/')}}/uploads/images/fat.png" alt="your image" width="20" height="20"/></div>
                        <input type="text" class="form-control" "Enter required fat" id="fat" name="fat" required="true" data-parsley-errors-container="#fts_error" data-parsley-error-message="Please enter fat." value="{{ isset($health_details) ? ($health_details->fat) : ('NA') }}" disabled></div>
                       <div id="fts_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="">Fiber<span style="color:red;" >*</span></label>
                      <div class="input-group">
                        <div class="input-group-addon btn-default"><i class="fa fab fa-pagelines"></i></div>
                        <input type="text" class="form-control" "Enter required fiber" id="fiber" name="fiber" required="true" data-parsley-errors-container="#Fiber_error" data-parsley-error-message="Please enter fiber." value="{{ isset($health_details) ? ($health_details->fiber) : ('NA') }}" disabled></div>
                       <div id="Fiber_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="">Carbohydrates<span style="color:red;" >*</span></label>
                      <div class="input-group">
                        <div class="input-group-addon btn-default"><img  src="{{ url('/')}}/uploads/images/carbohydrates.svg" alt="your image" width="20" height="20"/></div>
                        <input type="text" class="form-control" "Enter required carbohydrates" id="carbs" name="carbs" required="true" data-parsley-errors-container="#carbs_error" data-parsley-error-message="Please enter carbohydrates." value="{{ isset($health_details) ? ($health_details->carbs) : ('NA') }}" disabled></div>
                       <div id="carbs_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                 <div class="col-md-12">
                  <div class="box-body table-responsive">
                  
                    <table id="menu-item" class="table table-bordered table-striped" style="border: 1px solid #607d8b !important;">
                      <tbody>
                         @php 
                         $i=0; 
                         $j=0; 
                         $calories=[];
                         $proteins=[];
                         $carbohydrates=[];
                         $fats=[];
                         $total=0;
                         @endphp
                         @foreach($get_default_menu as $key => $gdmvalue)
                       
                          @if($i!=$gdmvalue->day)
                          <tr style="background-color:#cacaca!important;">
                              <td><strong>{{date('d-M-Y',strtotime($gdmvalue->meal_on_date))}} [ Day {{$gdmvalue->day}}]</strong></td>
                              <td width="20%"><strong>Menu Name</strong></td>
                              <td width="10%"><strong>Calories</strong></td>
                              <td width="10%"><strong>Proteins</strong></td>
                              <td width="10%"><strong>Carbohydrates</strong></td>
                              <td width="10%"><strong>Fats</strong></td>
                              <td width="10%"><strong>Total</strong></td> 
                          </tr>
                            @php 
                              $i=$gdmvalue->day;
                            @endphp

                          @endif
                             @if($gdmvalue->skip_meal_flag=="y")
                             @php $style="background-color:#ff000030 !important";@endphp
                            @else
                             @php $style=""; @endphp
                            @endif 
                          <tr  style="{{$style}}">
                             <td><strong>{{ucfirst($gdmvalue->meal_type_name)}}</strong><br/>@if($gdmvalue->skip_meal_flag=="y")
                              <small><b style="color:red">Compensation Date: {{date('d-m-Y',strtotime($gdmvalue->compenset_date))}}</b></small>
                              @endif</td>
                             <td><strong>{{$gdmvalue->menu_title}}</strong></td>
                           
                              <td>
                                  <img src="{{ URL('') }}/uploads/images/calories.svg"" alt="your image" width="15" height="15">  <strong>{{$gdmvalue->calories}}</strong> 
                                 @php 
                                 $calories[]=$gdmvalue->calories; 
                                 $total += $gdmvalue->calories;
                                 @endphp
                              </td>
                              <td>
                                  <img src="{{ URL('') }}/uploads/images/protein.svg"" alt="your image" width="15" height="15">  <strong>{{$gdmvalue->proteins}}</strong>
                                 @php 
                                 $proteins[]=$gdmvalue->proteins;
                                 $total += $gdmvalue->proteins; @endphp
                              </td>
                              <td>
                                  <img src="{{ URL('') }}/uploads/images/carbohydrates.svg" alt="your image" width="15" height="15">    <strong>{{$gdmvalue->carbohydrates}}</strong>
                                 @php $carbohydrates[]=$gdmvalue->carbohydrates;
                                 $total += $gdmvalue->carbohydrates; 
                                 @endphp
                              </td>
                              <td>
                                  <img src="{{ URL('') }}/uploads/images/fat.png" alt="your image" width="15" height="15"> <strong>{{$gdmvalue->fats}}</strong>
                                 @php $fats[]=$gdmvalue->fats;
                                      $total +=$gdmvalue->fats 
                                 @endphp
                              </td>
                               
                             <td>
                             <strong>{{$total}}</strong>
                             <?php $total =0;?>
                             </td>
                          </tr>
                         @endforeach 
                      </tbody>
                    </table>
                 </div>
              </div>
              </div>
          </div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>        

