@extends('admin.layout.master')
@section('content')
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">


    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
           @include('admin.layout._status_msg')
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title"> {{ $page_name." ".$title }}
                {{-- <small>Preview</small> --}}</h3>
                <ol class="breadcrumb">
                  <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                  <li><a href="{{url('/admin')}}/manage_category">Manage {{ $title }}</a></li>
                  <li class="active">{{ $page_name." ".$title }}</li>
                </ol> 
            </div>
            <!-- form start -->
              <form action="{{ url('/admin')}}/update_{{$url_slug}}/{{$data['assign_sub_menu_id']}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
             
              {!! csrf_field() !!}
             
                <div class="row">  

                  <div class="col-md-12">
                      <div class="box-body">
                        <div class="alert alert-info alert-dismissible">
                          <h4><i class="fa fa-sticky-note"></i> Note!</h4>
                          <strong>Note: Red background row indicates, days currently inactive status for record .</strong>
                        </div>
                     </div>
                  </div> 
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="operation_manager_name">Select Subscription Plan<span style="color:red;" >*</span></label>
                        <select class="form-control select2"   data-parsley-errors-container="#subscription_error" data-parsley-error-message="Please select subscription." name="sub_plan_id" id="sub_plan_id" required="true" disabled>
                          <option value="">-Select Subscription Plan-</option>
                            @foreach($subscription_plan as $svalue)

                              <option value="{{$svalue->sub_plan_id}}" <?php if($svalue->sub_plan_id == $data['sub_plan_id']) { echo "selected";}?>>{{ucfirst($svalue->sub_name)}}</option>
                            @endforeach
                        </select>
                       <div id="subscription_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body" id="daylist">
                        <div class='form-group'><label>Add Default Menu<span style='color:red;' >*</span></label>
                         <table class='table table-bordered'>
                            <thead>
                                <tr>
                                    <th>Days</th>
                                    <th class='text-center'>Action</th>
                                </tr>
                            </thead>
                            <tbody>
<?php// dd($get_inactive_days);?>
                              @foreach($subscription_plan_dtl as $sdvalue)
                               
                               @php $style="" @endphp
                               @if(in_array($sdvalue->duration,$get_inactive_days))
                               @php $style ="#bf000052"; @endphp
                               @endif
                             <tr style="background-color: {{$style}}">
                              <td>{{$sdvalue->duration}} Days</td>
                           
                              <td class='text-center'>
                                @foreach($default_meal as $dm_value)


                                  @if($dm_value->duration_id == $sdvalue->duration_id)
                                    <a href='javascript:void(0)' class='btn btn-sm btn-warning' onclick='editviewDetails(<?php echo $sdvalue->duration_id;?>,<?php echo $sdvalue->duration;?>);'><i class='fa fa-pencil'></i> Edit Default Menu</a>
                                  @else 
                                      <a href='javascript:void(0)' class='btn btn-sm btn-success' onclick='viewDetails(<?php echo $sdvalue->duration_id;?>,<?php echo $sdvalue->duration;?>);'><i class='fa fa-plus'></i> Add Default Menu</a>
                                  @endif



                                @endforeach
                                </td>          
                             </tr>

                             @endforeach
                             </tbody>
                        </table>

                    </div>
                  </div>
                </div>
                </div> 
                
              <div class="box-footer">
               
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
    <div class="modal fade" id="modal-details" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div id="content">
          
        </div>
      </div>
    </div>
  </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
  /*get_days();
  function get_days(){
    var sub_plan_id = $("#sub_plan_id").val();
      $.ajax({
        type: "POST",
        url: "{{url('/admin')}}/getdays",
        data: {
          plan_id: sub_plan_id
        }
      }).done(function(data) {
           $("#daylist").html(data);
    });
  }*/
  function viewDetails(id,days) 
    { 
       var duration_id  = id ;
       var days         = days ;
       //alert("duration_id"+id+","+days+"days");
       $.ajax({
          url: "{{url('/admin')}}/default_menu_add",
          type: 'post',
          data: {id :duration_id , no_of_days:days },
          success: function (data) 
          {
          
            $('#modal-details').modal('show');
            $('#content').html(data);
          }
      });
    } 

    function editviewDetails(id,days) 
    { 
       var duration_id  = id ;
       var days         = days ;
       //alert("duration_id"+id+","+days+"days");
       $.ajax({
          url: "{{url('/admin')}}/default_menu_edit",
          type: 'post',
          data: {id :duration_id , no_of_days:days },
          success: function (data) 
          {
          
            $('#modal-details').modal('show');
            $('#content').html(data);
          }
      });
    }

   
  function chk_click(){
  $('#pm').parsley().validate()
  };
</script>
@endsection