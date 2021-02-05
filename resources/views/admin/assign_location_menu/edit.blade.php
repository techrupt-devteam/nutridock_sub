@extends('admin.layout.master')
 
@section('content')
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ $page_name." ".$title }}
        {{-- <small>Preview</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{url('/admin')}}/manage_category">Manage {{ $title }}</a></li>
        <li class="active">{{ $page_name." ".$title }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
           <!--  <div class="box-header with-border">
              <h3 class="box-title">{{ $page_name." ".$title }}</h3>
            </div> -->
            <!-- /.box-header -->
            <!-- form start --> 
             @include('admin.layout._status_msg')

              <form action="{{ url('/admin')}}/update_{{$url_slug}}/{{$data['assign_menu_id']}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}
                <div class="row">  
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="operation_manager_name">State<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="state_id" id="state_id" required="true"  data-parsley-errors-container="#state_error" data-parsley-error-message="Please select state." onchange="getCity();">
                          <option value="">-Select State-</option>
                          @foreach($state as $svalue)
                          @php 
                            $selected = "";
                            if($data['state_id'] == $svalue->id){
                             $selected ="selected";
                            }
                          @endphp
                          <option value="{{$svalue->id}}" {{$selected}}>{{$svalue->name}}</option>
                          @endforeach
                        </select>
                         <div id="state_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div><div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="operation_manager_name">City<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="city_id" id="city_id" data-parsley-errors-container="#city_error" data-parsley-error-message="Please select city." required="true" onchange="getArea();">
                          <option value="">-Select City-</option>
                          <option value=""></option>
                        </select>
                          <div id="city_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="area_id">Area<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="area_id" id="area_id" required="true"  data-parsley-errors-container="#area_error" data-parsley-error-message="Please select area.">
                          <option value="">-Select Area-</option>
                          <option value=""></option>
                        </select>
                            <div id="area_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                 
                </div>
                  <div class="row">
                    <?php $menu_id = explode(",",$data['menu_id']); ?> 
                      <div class="col-md-12">
                        <div class="box-body">
                           <table id="menu-item"  class="table table-striped table-bordered ">
                              <thead class="btn-default">
                              <!--   <th><input type="checkbox" name="menu[]" class="all" id="menu" value="0" <?php echo (in_array(0, $menu_id) ? 'checked' : '')?> onclick="all_click();">&nbsp;&nbsp;All  </th> -->

                              <th><input type="checkbox" name="menu[]" class="all" id="menu" value="0">&nbsp;&nbsp;All  </th>
                                <th>Menu Name</th>
                             </thead>
                              <tbody>
                                @foreach($menu as $key => $mvalue)
                                  <tr>
                                    <td><input type="checkbox" name="menu[]"  class="checkbox_allmenu" id="menu" <?php echo (in_array($mvalue->id, $menu_id) ? 'checked' : '')?> value="{{$mvalue->id}}"></td>
                                    <td>{{$mvalue->menu_title}}</td>
                                  </tr>  
                                @endforeach
                              </tbody>
                           </table>
                         </div>
                      </div>
                    </div> 
              <!-- /.box-footer-body -->
              <div class="box-footer">
               
                <button type="submit" class="btn btn-primary">Update</button>
                 <a href="{{url('/admin')}}/manage_{{$url_slug}}"  class="btn btn-default">Back</a>
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
    $(document).ready(function() {
       get_City(); 
       get_Area();   



    });

    function get_City() 
    {        
        var state_id = $('#state_id').val()                   
        var city_id  = <?php echo  $data['city_id'];?>;            
        $.ajax({
            url: "{{url('/admin')}}/getCity",
            type: 'post',
            data: { state: state_id ,city:city_id},
            success: function (data) 
            {
              $("#city_id").html(data);
            }
        });
    };

    function get_Area() 
    {        
        var city_id = <?php echo  $data['city_id'];?>;   
        var area_id = <?php echo  $data['area_id'];?>;
        $.ajax({
            url: "{{url('/admin')}}/getArea",
            type: 'post',
            data: {city: city_id,area:area_id},
            success: function (data) 
            {
              $("#area_id").html(data);
            }
        });
    };

  //load city drop down script 
 
    function getCity(){
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
    function getArea(){
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
  
//chjeckbnox
function all_click()
{
    var chk_value = $(".checkbox_allmenu").prop("checked");
    if(chk_value==true){
       $(".checkbox_allmenu").prop("checked",false);
    }
    else
    {
      $(".checkbox_allmenu").prop('checked', true);
    }
}  


function allrm_click()
{
    var chk_value = $(".all").prop("checked");
    if(chk_value==true){
       $(".all").prop("checked",false);
    }
    else
    {
      $(".all").prop('checked', true);
    }
}

//mewnu
$('#menu-item').dataTable( {
 "scrollY": "200px",
"scrollCollapse": true,
"paging": false
} );

</script>
@endsection
