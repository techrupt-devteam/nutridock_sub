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
          <div class="box box-primary">
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
           <!--  <div class="box-header with-border">
              <h3 class="box-title">{{ $page_name." ".$title }}</h3>
            </div> -->
            <!-- /.box-header -->
            <!-- form start --> 
             @include('admin.layout._status_msg')

              <form action="{{ url('/admin')}}/update_{{$url_slug}}/{{$data['subcriber_assign_id']}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}
               <div class="row">  
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="operation_manager_name">State<span style="color:red;" >*</span></label>
                        <select class="form-control select2"   data-parsley-errors-container="#state_error" data-parsley-error-message="Please select state." name="state_id" id="state_id" required="true" onchange="getCity();" disabled="">
                          <option value="">-Select State-</option>
                          @foreach($state as $svalue)
                          <option value="{{$svalue->id}}" @if($svalue->id == $data['state_id']) selected @endif>{{$svalue->name}}</option>
                          @endforeach
                        </select>
                       <div id="state_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div><div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="city_id">City<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="city_id" id="city_id" required="true"  data-parsley-errors-container="#city_error" data-parsley-error-message="Please select city." onchange="get_user_list();" disabled="">
                          <option value="">-Select City-</option>
                        </select>
                         <div id="city_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                   <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nutritionsit_id">Nutritionist<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="nutritionist_id" id="nutritionist_id" required="true"  data-parsley-errors-container="#nutritionsit_error" data-parsley-error-message="Please select Nutritionsit." disabled="">
                          <option value="">-Select Nutritionsit-</option>
                            @foreach($users as $key => $uvalue)
                             <option value="{{$uvalue->id}}" <?php if($data['nutritionist_id']==$uvalue->id){ echo "selected"; }?>>{{ucfirst($uvalue->name)}}</option>
                            @endforeach
                          </select>
                         <div id="nutritionsit_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                </div>
                  <div class="row"> 
                      <div class="col-md-6">
                        <div class="box-body">
                           <div class="form-group">
                           <table id="menu-item"  class="table ">
                              <thead class="btn-default">
                                   <tr><th>#</th>
                                   <th>Subscriber Name</th></tr>
                             </thead>
                              <tbody id="subscriber_body">
                                <?php $subscriber_id = explode(",",$data['subscriber_id']); ?> 
                                @foreach($subscriber as $key => $svalue)
                                  <tr>
                                       <td>
                                           <input type="checkbox" name="subscriber_id[]" class="checkbox_allmenu" id="Subscriber" value="{{$svalue->id}}" <?php echo (in_array($svalue->id, $subscriber_id) ? 'checked' : '')?> <?php echo (in_array($svalue->id, $assign_subcriber) ? 'disabled' : '')?> >
                                       </td>
                                     <td>{{ucfirst($svalue->subscriber_name)}}</td>
                                  </tr>  
                                @endforeach
                              </tbody>
                           </table>
                         </div>
                         </div>
                      </div>
                  </div> 
                   <div class="box-footer">
                  <button type="submit" class="btn btn-primary">Update</button>
                 <a href="{{url('/admin')}}/manage_{{$url_slug}}"  class="btn btn-default">Back</a>
              </div>
                </div>  
              <!-- /.box-footer-body -->
             
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

  $('input.chk_boxn').on('change', function() {
  $('input.chk_boxn').not(this).prop('checked', false);  
  });

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
  
  //state  city  wise user 
   function  get_user_list()
   {
      var city_id  = $("#city_id").val();
      $.ajax({
        type: "POST",
        url: "{{url('/admin')}}/get_user_list",
        data: {
          city  :  city_id,
        }
      }).done(function(data) {
           var data1=data.split(',');
           $("#subscriber_body").html(data1[1]);
           $("#nutritionist_id").html(data1[0]);
      });
  }

//mewnu
$('#menu-item').dataTable( {
 "scrollY": "200px",
 "searching":false,
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
