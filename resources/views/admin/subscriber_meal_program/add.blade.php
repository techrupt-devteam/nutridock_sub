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

            @if($default_menu_not_Assign == "No")
            <div class="row">
                <div class="col-md-12"> 
                    <div class="box-body">
                        <div class="alert alert-danger alert-dismissible">
                           <!--  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            Default meal program is not assign please contact operation manager.
                        </div>
                    </div>
                </div>
            </div>
            @else
            <form action="{{ url('/admin')}}/store_subscriber_health_details" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}

             
                <div class="row"> 
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
                            <input type="text" class="form-control" placeholder="Enter BMI" id="bmi" name="bmi" required="true" data-parsley-errors-container="#bmi_error" data-parsley-error-message="Please enter bmi." value="{{ isset($health_details) ? ($health_details->bmi) : ('') }}">
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
                          <input type="text" class="form-control" placeholder="Enter BMR" id="bmr" name="bmr" required="true" data-parsley-errors-container="#bmr_error" data-parsley-error-message="Please enter bmr." value="{{ isset($health_details) ? ($health_details->bmr) : ('') }}">
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
                          <input type="text" class="form-control" placeholder="Enter Current Weight" id="current_wt" name="current_wt" required="true" data-parsley-errors-container="#weight_error" data-parsley-error-message="Please enter weight." value="{{ isset($health_details) ? ($health_details->current_wt) : ('') }}">
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
                          <input type="text" class="form-control" placeholder="Enter Body Fats" id="body_fat" name="body_fat" required="true" data-parsley-errors-container="#fats_error" data-parsley-error-message="Please enter body fats." value="{{ isset($health_details) ? ($health_details->body_fat) : ('') }}">
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
                        <input type="text" class="form-control" placeholder="Enter required calories" id="req_calories" name="req_calories" required="true" data-parsley-errors-container="#calories_error" data-parsley-error-message="Please enter calories." value="{{ isset($health_details) ? ($health_details->req_calories) : ('') }}"></div>
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
                        <input type="text" class="form-control" placeholder="Enter required protein" id="protein" name="protein" required="true" data-parsley-errors-container="#protein_error" data-parsley-error-message="Please enter protein." value="{{ isset($health_details) ? ($health_details->protein) : ('') }}"></div>
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
                        <input type="text" class="form-control" placeholder="Enter required fat" id="fat" name="fat" required="true" data-parsley-errors-container="#fts_error" data-parsley-error-message="Please enter fat." value="{{ isset($health_details) ? ($health_details->fat) : ('') }}"></div>
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
                        <input type="text" class="form-control" placeholder="Enter required fiber" id="fiber" name="fiber" required="true" data-parsley-errors-container="#Fiber_error" data-parsley-error-message="Please enter fiber." value="{{ isset($health_details) ? ($health_details->fiber) : ('') }}"></div>
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
                        <input type="text" class="form-control" placeholder="Enter required carbohydrates" id="carbs" name="carbs" required="true" data-parsley-errors-container="#carbs_error" data-parsley-error-message="Please enter carbohydrates." value="{{ isset($health_details) ? ($health_details->carbs) : ('') }}"></div>
                       <div id="carbs_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
              </div>
              <hr/>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{url('/admin')}}/manage_subscriber"  class="btn btn-default">Back</a>
                  </div>
                </div> 
              </div>
            </form>
              <hr/>
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
                              <td class="text-center"><strong>Action</strong></td> 
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
                          <tr style="{{$style}}">
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
                                 <img src="{{ URL('') }}/uploads/images/carbohydrates.svg" alt="your image" width="15" height="15">   <strong>{{$gdmvalue->carbohydrates}}</strong>
                                 @php $carbohydrates[]=$gdmvalue->carbohydrates;
                                 $total += $gdmvalue->carbohydrates; 
                                 @endphp
                              </td>
                              <td>
                                  <img src="{{ URL('') }}/uploads/images/fat.png" alt="your image" width="15" height="15">  <strong>{{$gdmvalue->fats}}</strong>
                                 @php $fats[]=$gdmvalue->fats;
                                      $total +=$gdmvalue->fats 
                                 @endphp
                              </td>
                               
                             <td>
                             <strong>{{$total}}</strong>
                             <?php $total =0;?>
                             </td>
                             <td class="text-center"> 
                                <a href="javascript:void(0);" class="btn btn-success btn-sm" data-toggle='modal' data-target='#modal-details' title="Edit" onclick="viewDetails(<?php echo $gdmvalue->program_id;?>)">
                                    <i class="fa fa-edit"></i>
                                </a>
                              </td>  
                          </tr>
                         @endforeach 
                      </tbody>
                    </table>
                 
                 </div>
              </div>
              </div>
            <!--   <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                 <a href="{{url('/admin')}}/manage_subscriber"  class="btn btn-default">Back</a>
              </div> -->

           @endif


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
<div class="modal fade" id="modal-details" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div id="content">
          
        </div>
      </div>
    </div>
  </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<style type="text/css">
  .bg-default{
    background-color: #d0c4c4 !important;
  }
</style>
<script type="text/javascript">
  function viewDetails(program_id) 
    { 

       var program_id = program_id;
     
       $.ajax({
            url: "{{url('/admin')}}/edit_subscriber_default_menu",
            type: 'post',
            data: { program_id:program_id },
            success: function (data) 
            {
              $('#content').html(data);
            }
        });
    }
</script>
@endsection