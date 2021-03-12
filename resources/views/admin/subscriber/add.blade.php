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
                {{ $page_name." ".$title }}
                {{-- <small>Preview</small> --}}
              </h3>
              <ol class="breadcrumb">
                <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{url('/admin')}}/manage_{{$url_slug}}">Manage {{ $title }}</a></li>
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
                        <label for="operation_manager_name">State<span style="color:red;" >*</span></label>
                        <select class="form-control select2"   data-parsley-errors-container="#state_error" data-parsley-error-message="Please select state." name="state_id" id="state_id" required="true" onchange="getCity();">
                          <option value="">-Select State-</option>
                          @foreach($state as $svalue)
                          <option value="{{$svalue->id}}">{{$svalue->name}}</option>
                          @endforeach
                        </select>
                       <div id="state_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div><div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="city_id">City<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="city_id" id="city_id" required="true"  data-parsley-errors-container="#city_error" data-parsley-error-message="Please select city." onchange="get_nutritionist();">
                          <option value="">-Select City-</option>
                        </select>
                         <div id="city_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                </div>
                  <div class="row"> 
                      <div class="col-md-6">
                        <div class="box-body">
                           <div class="form-group">
                           <table id="menu-item"  class="table table-striped table-bordered ">
                              <thead class="btn-default">
                                <th>Subscriber Name</th>
                                <th>State</th>
                                <th>City</th>
                             </thead>
                              <tbody id="subscriber_body">
                               <!--  @foreach($subscriber as $key => $svalue)
                                  <tr>
                                    <td><input type="checkbox" name="subscriber_id[]" class="checkbox_allmenu" id="Subscriber" value="{{$svalue->id}}"> {{ucfirst($svalue->name)}}</td>
                                    <td></td>
                                    <td></td>
                                  </tr>  
                                @endforeach -->
                              </tbody>
                           </table>
                         </div>
                         </div>
                      </div>
                      <div class="col-md-6">
                        <div class="box-body">
                           <div class="form-group">
                           <table id="item2"  class="table table-striped table-bordered ">
                              <thead class="btn-default">
                                <th>Nutritionist Name</th>
                             </thead>
                              <tbody id="nutritionist_tbody">
                              <!--   @foreach($users as $key => $svalue)
                                  <tr>
                                    <td><input type="checkbox" name="nutritionist_id[]" class="chk_boxn" id="Subscriber" value="{{$svalue->id}}"> {{ucfirst($svalue->name)}}</td>
                                  </tr>  
                                @endforeach -->
                              </tbody>
                           </table>
                         </div>
                         </div>
                      </div>
                  </div> 
                </div>  
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                 <a href="{{url('/admin')}}/manage_{{$url_slug}}"  class="btn btn-default">Back</a>
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
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
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
  //load city drop down area   
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

   function  get_nutritionist();(){
     
      var state_id = $("#state_id").val();
      var city_id = $("#city_id").val();
      $.ajax({
        type: "POST",
        url: "{{url('/admin')}}/get_list",
        data: {
          city  :  city_id,
          state :  state_id
        }
      }).done(function(data) {
        
           $("#subscriber_body").html(data);
           $("#nutritionist_tbody").html(data);
      });
  }

  $('input.chk_boxn').on('change', function() {
     $('input.chk_boxn').not(this).prop('checked', false);  
  });
 
  //mewnu
  $('#menu-item').dataTable( {
   "scrollY": "200px",
  "scrollCollapse": true,
  "paging": false
  } );  

  $('#item2').dataTable( {
   "scrollY": "200px",
  "scrollCollapse": true,
  "paging": false
  } );

</script>
@endsection