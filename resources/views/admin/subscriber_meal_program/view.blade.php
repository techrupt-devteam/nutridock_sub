
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
                            <input type="text" class="form-control" placeholder="Enter BMI" id="bmi" name="bmi" required="true" data-parsley-errors-container="#bmi_error" data-parsley-error-message="Please enter bmi." value="{{ isset($health_details) ? ($health_details->bmi) : ('') }}" disabled>
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
                          <input type="text" class="form-control" placeholder="Enter BMR" id="bmr" name="bmr" required="true" data-parsley-errors-container="#bmr_error" data-parsley-error-message="Please enter bmr." value="{{ isset($health_details) ? ($health_details->bmr) : ('') }}" disabled>
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
                          <input type="text" class="form-control" placeholder="Enter Current Weight" id="current_wt" name="current_wt" required="true" data-parsley-errors-container="#weight_error" data-parsley-error-message="Please enter weight." value="{{ isset($health_details) ? ($health_details->current_wt) : ('') }}" disabled>
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
                          <input type="text" class="form-control" placeholder="Enter Body Fats" id="body_fat" name="body_fat" required="true" data-parsley-errors-container="#fats_error" data-parsley-error-message="Please enter body fats." value="{{ isset($health_details) ? ($health_details->body_fat) : ('') }}" disabled>
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
                        <div class="input-group-addon btn-default"><img  src="{{ url('/')}}/uploads/images/calories.png" alt="your image" width="20" height="20"/></div>
                        <input type="text" class="form-control" placeholder="Enter required calories" id="req_calories" name="req_calories" required="true" data-parsley-errors-container="#calories_error" data-parsley-error-message="Please enter calories." value="{{ isset($health_details) ? ($health_details->req_calories) : ('') }}" disabled></div>
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
                        <div class="input-group-addon btn-default"> <img  src="{{ url('/')}}/uploads/images/protein.jpg" alt="your image" width="20" height="20"/></div>
                        <input type="text" class="form-control" placeholder="Enter required protein" id="protein" name="protein" required="true" data-parsley-errors-container="#protein_error" data-parsley-error-message="Please enter protein." value="{{ isset($health_details) ? ($health_details->protein) : ('') }}" disabled></div>
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
                        <input type="text" class="form-control" placeholder="Enter required fat" id="fat" name="fat" required="true" data-parsley-errors-container="#fts_error" data-parsley-error-message="Please enter fat." value="{{ isset($health_details) ? ($health_details->fat) : ('') }}" disabled></div>
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
                        <input type="text" class="form-control" placeholder="Enter required fiber" id="fiber" name="fiber" required="true" data-parsley-errors-container="#Fiber_error" data-parsley-error-message="Please enter fiber." value="{{ isset($health_details) ? ($health_details->fiber) : ('') }}" disabled></div>
                       <div id="Fiber_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="">Carbohydrates<span style="color:red;" >*</span></label>
                      <div class="input-group">
                        <div class="input-group-addon btn-default"><img  src="{{ url('/')}}/uploads/images/carbohydrates.png" alt="your image" width="20" height="20"/></div>
                        <input type="text" class="form-control" placeholder="Enter required carbohydrates" id="carbs" name="carbs" required="true" data-parsley-errors-container="#carbs_error" data-parsley-error-message="Please enter carbohydrates." value="{{ isset($health_details) ? ($health_details->carbs) : ('') }}" disabled></div>
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
                              <td><strong>Day {{$gdmvalue->day}}</strong></td>
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

                          <tr>
                             <td><strong>{{ucfirst($gdmvalue->meal_type_name)}}</strong></td>
                             <td><strong>{{$gdmvalue->menu_title}}</strong></td>
                           
                              <td>
                                   <strong>{{$gdmvalue->calories}}</strong> 
                                 @php 
                                 $calories[]=$gdmvalue->calories; 
                                 $total += $gdmvalue->calories;
                                 @endphp
                              </td>
                              <td>
                                  <strong>{{$gdmvalue->proteins}}</strong>
                                 @php 
                                 $proteins[]=$gdmvalue->proteins;
                                 $total += $gdmvalue->proteins; @endphp
                              </td>
                              <td>
                                  <strong>{{$gdmvalue->carbohydrates}}</strong>
                                 @php $carbohydrates[]=$gdmvalue->carbohydrates;
                                 $total += $gdmvalue->carbohydrates; 
                                 @endphp
                              </td>
                              <td>
                                  <strong>{{$gdmvalue->fats}}</strong>
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

