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
              <form action="{{ url('/admin')}}/update_{{$url_slug}}/{{$data['per_id']}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="role_name">Select Role<span style="color:red;" >*</span></label>
                         <select name="role_id" id="role_id" class="form-control" required="true">
                         <option value="">-Select-</option>  
                           @foreach($role as $rvalue)
                              @php $seleced = ($data['role_id']==$rvalue->role_id)? 'selected':'';@endphp
                             <option value="{{$rvalue->role_id}}" {{$seleced}}>{{$rvalue->role_name}}</option>  
                           @endforeach
                         </select>
                      </div>
                    </div>
                  </div>
                  </div>
                  <div class="col-md-12">
                      <div class="col-md-6">
                    <div class="box-body">
                       <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Sr.No</th>
                            <th>Module Name</th>
                          </tr>
                        </thead>
                        <?php $i =1; $permission_arr = explode(",",$data['permission_access']); ?>
                        @foreach($module as $mvalue)
                          <tr>
                            @if($mvalue->parent_id==0)
                             <td><b>{{$i}}</b></td>
                             <td><input type="checkbox" class="form-check-input {{$mvalue->module_id}}checkboxall" name="permission_access[]"  value="{{$mvalue->module_id}}" <?php echo (in_array($mvalue->module_id, $permission_arr) ? 'checked' : '')?> onclick="all_click(<?php echo $mvalue->module_id;?>);"> <strong>{{ucfirst($mvalue->module_name)}}</strong> </td> 
                            @else
                             <td></td>
                             <td style="padding-left: 25px !important;"> <input type="checkbox" class="form-check-input  @if($mvalue->parent_id!=0) {{$mvalue->parent_id}}checkbox @endif"  name="permission_access[]" <?php echo (in_array($mvalue->module_id, $permission_arr) ? 'checked' : '')?> onclick="allrm_click(<?php echo $mvalue->parent_id;?>)" value="{{$mvalue->module_id}}"> {{$mvalue->module_name}}</td> 
                            @endif 
                          </tr>  @if($mvalue->parent_id==0)
                           @php $i++; @endphp
                             @endif 
                        @endforeach
                        </table>
                     </div>
                   </div>
                 </div>
                </div> 
                
              <!-- /.box-body -->
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
  
  <script type="text/javascript">
     get_menu();
function get_menu()
{
   // var type_id = '';
      $.ajax({
        type: "post",
        url: "{{url('/admin')}}/getmenu"
      
      }).done(function(data) {
           var result = data.split('|');
           $("#menudiv").html(result[0]);
      });
}

function all_click(value)
{
    var chk_value = $("."+value+"checkbox").prop("checked");
    if(chk_value==true){
       $("."+value+"checkbox").prop("checked",false);
    }
    else
    {
      $("."+value+"checkbox").prop('checked', true);
    }
}

function allrm_click(value)
{
  $("."+value+"checkboxall").prop('checked', true);
}
</script>
@endsection