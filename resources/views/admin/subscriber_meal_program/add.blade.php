@extends('admin.layout.master')
@section('content')
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
<!--     <section class="content-header">
      <h1>
        {{ $page_name." ".$title }}
        {{-- <small>Preview</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{url('/admin')}}/manage_category">Manage {{ $title }}</a></li>
        <li class="active">{{ $page_name." ".$title }}</li>
      </ol>
    </section> -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">

           @include('admin.layout._status_msg')
             <div class="box">
            <div class="box-header">
              <h3 class="box-title">
               <!--  {{ $page_name." ".$title }}
                {{-- <small>Preview</small> --}} -->
                <b>Subscriber Name: </b> {{ucfirst($subscriber->subscriber_name)}}
              </h3>
              <ol class="breadcrumb">
                <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{url('/admin')}}/manage_subscriber">Manage Subscriber</a></li>
                <li class="active">{{ $page_name." ".$title }}</li>
              </ol>
            </div>
          <div class="box box-primary">
            <!-- form start -->
            <form action="{{ url('/admin')}}/store_{{$url_slug}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}
                <div class="row">  
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="">BMI<span style="color:red;" >*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon btn-default">
                              BMI
                            </div>
                            <input type="text" class="form-control" placeholder="Enter BMI" id="bmi" name="bmi" required="true" data-parsley-errors-container="#bmi_error" data-parsley-error-message="Please enter bmi.">
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
                          <input type="text" class="form-control" placeholder="Enter BMR" id="bmr" name="bmr" required="true" data-parsley-errors-container="#bmr_error" data-parsley-error-message="Please enter bmr.">
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
                          <input type="text" class="form-control" placeholder="Enter Current Weight" id="current_wt" name="current_wt" required="true" data-parsley-errors-container="#weight_error" data-parsley-error-message="Please enter weight.">
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
                          <input type="text" class="form-control" placeholder="Enter Body Fats" id="fat" name="fat" required="true" data-parsley-errors-container="#fats_error" data-parsley-error-message="Please enter body fats.">
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
                        <input type="text" class="form-control" placeholder="Enter required calories" id="calories" name="calories" required="true" data-parsley-errors-container="#calories_error" data-parsley-error-message="Please enter calories."></div>
                       <div id="calories_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
              </div>
              <hr/>
              <div class="row">  
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="">Protine<span style="color:red;" >*</span></label>
                      <div class="input-group">
                        <div class="input-group-addon btn-default"> <img  src="{{ url('/')}}/uploads/images/protein.jpg" alt="your image" width="20" height="20"/></div>
                        <input type="text" class="form-control" placeholder="Enter required protein" id="protein" name="protein" required="true" data-parsley-errors-container="#protein_error" data-parsley-error-message="Please enter protein."></div>
                       <div id="protein_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="">fat<span style="color:red;" >*</span></label>
                      <div class="input-group">
                        <div class="input-group-addon btn-default"><img  src="{{ url('/')}}/uploads/images/fat.png" alt="your image" width="20" height="20"/></div>
                        <input type="text" class="form-control" placeholder="Enter required fat" id="fat" name="fat" required="true" data-parsley-errors-container="#fts_error" data-parsley-error-message="Please enter fat."></div>
                       <div id="fts_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="">Fiber<span style="color:red;" >*</span></label>
                      <div class="input-group">
                        <div class="input-group-addon btn-default"><i class="fa fab fa-pagelines"></i></div>
                        <input type="text" class="form-control" placeholder="Enter required fiber" id="fiber" name="fiber" required="true" data-parsley-errors-container="#Fiber_error" data-parsley-error-message="Please enter fiber."></div>
                       <div id="Fiber_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="">Carbohydrates<span style="color:red;" >*</span></label>
                      <div class="input-group">
                        <div class="input-group-addon btn-default"><img  src="{{ url('/')}}/uploads/images/carbohydrates.png" alt="your image" width="20" height="20"/></div>
                        <input type="text" class="form-control" placeholder="Enter required carbohydrates" id="carbs" name="carbs" required="true" data-parsley-errors-container="#carbs_error" data-parsley-error-message="Please enter carbohydrates."></div>
                       <div id="carbs_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
              </div>
              <hr/>

              <div class="row">
                <div class="col-md-12"> 
                  <div class="box-body">
                      <div class="table-responsive">
                         
                         <table class="table">
                             <thead class="bg-info">
                                <tr>
                                  <th colspan="3"> Start Date :<?php echo date('d-m-Y',strtotime($subscriber->start_date));?></th> 
                                  <th  colspan="3"> End Date  :<?php echo date('d-m-Y',strtotime($subscriber->expiry_date));?></th>
                                </tr>
                                <tr>
                                   <th class="bg-default text-center">Day</th>
                                   <th class="bg-default text-center">Date</th>
                              <!--      <th class="bg-default">Subscription Plan</th> -->
                                   @foreach($meal_type as $mtvalue)
                                    <th class="bg-default text-center">{{ucfirst($mtvalue->meal_type_name)}}</th>
                                   @endforeach
                                   <th class="bg-default text-center">Total Calories</th>
                                </tr>
                             </thead>
                             <tbody>
                                @for($i=0;$i<$program_days;$i++)
                                <?php 
                                if($i >= 1){$days ="+".$i." day";
                                 $date = date('d-m-Y', strtotime($days,strtotime($subscriber->start_date))); 
                                }else{ $date = date('d-m-Y', strtotime($subscriber->start_date));}
                                ?>
                                <tr>
                                  <td>{{$i+1}} Day</td>
                                   <td>
                                      <input type="textbox" name="day_date{{$i+1}}" class="form-control" id="day_date{{$i+1}}" 
                                      value="{{$date}}" readonly>
                                   </td>
                                  <!--  <td>
                                     <select name="sub_plan_id{{$i+1}}" class="form-control" id="sub_plan_id{{$i+1}}">
                                       <option value="">-select Subscription plan-</option>
                                       <option value="0">All</option>
                                       <option value="{{$subscriber->sub_plan_id}}">{{$subscriber->sub_name}}</option>
                                     </select>
                                     500
                                   </td> -->
                                    @foreach($meal_type as $mtvalue)
                                     <td>
                                      <select name="{{lcfirst($mtvalue->meal_type_name)}}{{$i+1}}" class="form-control" id="{{lcfirst($mtvalue->meal_type_name)}}{{$i+1}}" data-parsley-errors-container="#{{lcfirst($mtvalue->meal_type_name)}}{{$i+1}}_error" data-parsley-error-message="Please select {{lcfirst($mtvalue->meal_type_name)}}." required="true">
                                        <option value=" ">-Select {{ucfirst($mtvalue->meal_type_name)}}-</option>
                                      </select>
                                       <div id="{{lcfirst($mtvalue->meal_type_name)}}{{$i+1}}_error" style="color:red;"></div>
                                       <div id="{{lcfirst($mtvalue->meal_type_name)}}{{$i+1}}_details"></div>
                                     </td>
                                    @endforeach
                                    <td>
                                      <input type="textbox" name="total_cal_Sum{{$i+1}}" class="form-control" id="total_cal_Sum{{$i+1}}" 
                                      readonly>
                                    </td>
                                </tr> 
                                @endfor <input type="text" name="row_cnt" value="{{$i}}">
                             </tbody>
                         </table>
                      </div>
                    </div>
                </div>
              </div>
                
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                 <a href="{{url('/admin')}}/manage_subscriber"  class="btn btn-default">Back</a>
              </div>
            </form>
          </div>
        </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<style type="text/css">
  .bg-default{
    background-color: #d0c4c4 !important;
  }
</style>
@endsection