@extends('admin.layout.master')
@section('content') 
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) --> 
<!-- <section class="content-header">
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
    <!-- general form elements --> 
    @include('admin.layout._status_msg')
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"> {{ $page_name." ".$title }}
          {{-- <small>Preview</small> --}}</h3>
        <ol class="breadcrumb">
          <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li><a href="{{url('/admin')}}/manage_{{$url_slug}}">Manage {{ $title }}</a></li>
          <li class="active">{{ $page_name." ".$title }}</li>
        </ol>
      </div>
      <div class="box-body"> 
        <!-- form start -->
        <form action="{{ url('/admin')}}/store_{{$url_slug}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
          {!! csrf_field() !!}
          <div class="row">
            <div class="col-md-6">
              <div class="box-body">
                <div class="form-group">
                  <label for="Kitchen_name">Kitechen Name<span style="color:red;" >*</span></label>
                  <input type="text" autocomplete="off" class="form-control" id="kitchen_name" name="kitchen_name" data-parsley-errors-container="#Kitchen_names" data-parsley-error-message="Please enter name."  placeholder="Kitchen Name" required>
                  <div id="Kitchen_names" style="color:red;"></div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="box-body">
                <div class="form-group">
                  <label for="operation_manager_name">Customer Key<span style="color:red;" >*</span></label>
                  <div class="input-group">
                    <div class="input-group-addon"> <i class="fa fa-key"></i> </div>
                    <input type="text" autocomplete="off"  class="form-control"  id="customer_key" name="customer_key" placeholder="Customer Key" required data-parsley-errors-container="#customer_key_error" data-parsley-error-message="Please enter customer key.">
                  </div>
                  <div id="customer_key_error" style="color:red;"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div class="box-body">
                <div class="form-group">
                  <label for="state_id">State<span style="color:red;" >*</span></label>
                  <select class="form-control select2" name="state_id" id="state_id" required="true" data-parsley-errors-container="#state_error" data-parsley-error-message="Please select state." onchange="getCity();">
                    <option value="">-Select State-</option>
                    
                          @foreach($state as $svalue)
                          
                    <option value="{{$svalue->id}}">{{$svalue->name}}</option>
                    
                          @endforeach
                        
                  </select>
                  <div id="state_error" style="color:red;"></div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="box-body">
                <div class="form-group">
                  <label for="operation_manager_name">City<span style="color:red;" >*</span></label>
                  <select class="form-control select2"  name="city_id" id="city_id"  data-parsley-errors-container="#city_error" data-parsley-error-message="Please select city." required="true" onchange="getArea();">
                    <option value="">-Select City-</option>
                    <option value=""></option>
                  </select>
                  <div id="city_error" style="color:red;"></div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="box-body">
                <div class="form-group">
                  <label for="area_id">Area<span style="color:red;" >*</span></label>
                  <select class="form-control select2"  name="area_id" id="area_id" required="true" data-parsley-errors-container="#area_error" data-parsley-error-message="Please select area.">
                    <option value="">-Select Area-</option>
                    <option value=""></option>
                  </select>
                  <div id="area_error" style="color:red;"></div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="box-body">
                <div class="form-group">
                  <label for="operation_manager_name">Pincode<span style="color:red;" >*</span></label>
                  <div class="input-group">
                    <div class="input-group-addon"> <i class="fa fa-map-marker"></i> </div>
                    <input type="text" autocomplete="off"  class="form-control"  id="pincode" name="pincode" placeholder="Pincode" required data-parsley-errors-container="#pincode_error" data-parsley-error-message="Please enter pincode.">
                  </div>
                  <div id="pincode_error" style="color:red;"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="Kitchen_name">Kitechen Latitude<span style="color:red;" >*</span></label>
                  <input type="text" autocomplete="off" class="form-control" id="lat" name="lat" data-parsley-errors-container="#lat_names" data-parsley-error-message="Please enter latitude."  placeholder="Kitchen Latitude" required>
                  <div id="lat_names" style="color:red;"></div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="Kitchen_name">Kitechen Longitude<span style="color:red;" >*</span></label>
                  <input type="text" autocomplete="off" class="form-control" id="lang" name="lang" data-parsley-errors-container="#long_names" data-parsley-error-message="Please enter logitude."  placeholder="Kitchen Longitude" required>
                  <div id="long_names" style="color:red;"></div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="Kitchen_name">Kitechen Dashboard progress bar color<span style="color:red;" >*</span></label>
                  <input type="color" autocomplete="off" class="form-control" id="process_color" name="process_color" data-parsley-errors-container="#_names" data-parsley-error-message="Please enter color."  placeholder="Dashboard progress bar color"  required>
                  <div id="_names" style="color:red;"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="box-body">
                <div class="form-group">
                  <label for="area_id">Address<span style="color:red;" >*</span></label>
                  <textarea name="address" class="form-control" id="address" rows="4" required data-parsley-errors-container="#address_error" data-parsley-error-message="Please select at least one"> </textarea>
                  <div id="address_error" style="color:red;"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="alert alert-warning col-md-12 mt-4 text-left" style="margin-top: 13px;color:#000000!important;background-color: #f39c1229 !important;">
                  <strong ><i class="glyphicon glyphicon-warning"></i> Note!</strong>
                 To add Cloud Kitchen, Please make sure you have <strong>"Assign User to Kitchen", "Add Subscription plan" and "Assign Menu To Kitchen".</strong><br/>
                 <strong><i class="glyphicon glyphicon-warning"></i> Note!</strong> Assign user show on <b>red color</b> background and not assign user show <b>green color</b> background </strong>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"><i class="fa fa-gear"></i> Kitchen settings</h3>
                </div>
                <div class="box-body">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="area_id">Assign User To Kitchen </label>
                      <div id="checkbox_error" style="color:red;"></div>
                      <table id="user-item"  class="table table-striped table-bordered ">
                        <thead class="btn-default">
                      <!--   <tr><td colspan="4">  </td></tr>   -->
                        <th width="5%"></th>
                          <th>Menu Name</th>
                          <th>Role</th>
                          <th>Details</th>
                            </thead>
                        <tbody>
                        
                        @foreach($users as $key => $uvalue)

                        @if(in_array($uvalue->id,$assign_user))
                        <tr style="background-color: #e80f0f1c !important;">     
                          <td><input type="checkbox" name="users[]" class="checkbox_allmenu" id="users" value="{{$uvalue->id}}" required data-parsley-errors-container="#checkbox_error" data-parsley-error-message="Please select at least one kitchen user" onclick="alert('this user already assign to kichen please select anather user');" tooltip="test" disabled=""></td>
                          <td>{{ucfirst($uvalue->name)}}</td>
                          <td>{{ucfirst($uvalue->role_name)}}</td>
                          <td><strong>State:</strong>{{ucfirst($uvalue->state_name)}}, <strong>city:</strong>{{ucfirst($uvalue->city_name)}} , <strong>Area:</strong> {{ucfirst($uvalue->area_name)}} </td>
                          </tr>
                        @else
                         <tr style="background-color: #38ff514a !important;">     
                           <td><input type="checkbox" name="users[]" class="checkbox_allmenu" id="users" value="{{$uvalue->id}}" required data-parsley-errors-container="#checkbox_error" data-parsley-error-message="Please select at least one kitchen user"></td>
                       
                          <td>{{ucfirst($uvalue->name)}}</td>
                          <td>{{ucfirst($uvalue->role_name)}}</td>
                          <td><strong>State:</strong>{{ucfirst($uvalue->state_name)}}, <strong>city:</strong>{{ucfirst($uvalue->city_name)}} , <strong>Area:</strong> {{ucfirst($uvalue->area_name)}} </td> </tr>

                        @endif     
                        
                        @endforeach
                          </tbody>
                        
                      </table>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="area_id">Assign Subscription Plan</label>
                  <div id="plan_error" style="color:red;"></div>
                      <table id="sub-item"  class="table table-striped table-bordered ">
                        <thead class="btn-default">
                       <!--  <tr><td colspan="3">  </td></tr>   -->
                        <th width="5%"></th>
                          <th>Subscription Plan</th>
                            </thead>
                        <tbody>
                        
                        @foreach($subscriptionplan as $key => $svalue)
                        <tr>
                          <td><input type="checkbox" name="subscription_plan[]" class="checkbox_allmenu" id="subscription_plan" value="{{$svalue->sub_plan_id}}" required data-parsley-errors-container="#plan_error" data-parsley-error-message="Please select at least one subscription plan">
                             </td>
                          <td>{{$svalue->sub_name}}</td>
                        </tr>
                        @endforeach
                          </tbody>
                        
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title"><i class="fa fa-gear"></i> Assign Menu To Kitchen </h3>
                </div>
                <div class="box-body">
                  <div class="form-group">
                     <div id="menu_error" style="color:red;"></div>  
                     
                    <table id="menu-item"  class="table table-striped table-bordered ">
                      <thead >
                      <th width="5%"></th>
                        <th>Menu Name</th>
                          </thead>
                      <tbody>
                      
                      @foreach($menu as $key => $mvalue)
                      <tr>
                        <td><input type="checkbox" name="menu[]" class="checkbox_allmenu" id="menu" value="{{$mvalue->id}}" required data-parsley-errors-container="#menu_error" data-parsley-error-message="Please select at least one menu">
                     
                        </td>
                        <td>{{$mvalue->menu_title}}</td>
                      </tr>
                      @endforeach
                        </tbody>
                      
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="box-footer">
            <div class="row">
              <div class="col-md-12">
                @php $disabled =""; @endphp
                @if(count($users)==0 || count($subscriptionplan) == 0 || count($menu)==0)
                  @php $disabled = "disabled"; @endphp 
                @endif
                <button type="submit" class="btn btn-primary" <?php echo $disabled; ?>>Submit</button>
                <a href="{{url('/admin')}}/manage_{{$url_slug}}"  class="btn btn-default">Back</a> </div>
            </div>
          </div>
        </form>
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
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/datatables.net/js/jquery.dataTables.min.js"></script> 
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
<script type="text/javascript">
  //datatable script 
  $('#user-item').dataTable({
      
      "scrollY": "200px",
      "info": false, 
      "scrollCollapse": true,
      "paging": false
  });

  $('#sub-item').dataTable({
    "searching": false,
     "scrollY": "200px",  
     "info": false, 
    "scrollCollapse": true,
    "paging": false
  });

  $('#menu-item').dataTable({
      "scrollY": "200px",
      "searching": false,     
      "info": false, 
      "scrollCollapse": true,
      "info": false, 
      "paging": false
  });  
  //load city drop down script 
    function  getCity(){
      var state_id = $("#state_id").val();
      $.ajax({
        type: "POST",
        url: "{{url('/admin')}}/getCity",
        data: {
          state: state_id
        }
      }).done(function(data) {
           $("#city_id").html(data);
      });
    }  
  //load area drop down script 
      function  getArea(){
      var city_id = $("#city_id").val();
      $.ajax({
        type: "POST",
        url: "{{url('/admin')}}/getArea",
        data: {
          city: city_id
        }
      }).done(function(data) {
           $("#area_id").html(data);
      });
    }
</script> 
@endsection