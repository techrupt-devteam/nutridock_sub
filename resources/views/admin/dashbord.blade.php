@extends('admin.layout.master')
<?php  
  $session_user = Session::get('user');
  if($session_user->roles!='admin'){
      $session_module = Session::get('module_data');
      $session_permissions = Session::get('permissions');
      $session_parent_menu = Session::get('parent_menu');
      $session_sub_menu = Session::get('sub_menu');
  }
?>
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="min-height: auto !important;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard   Login-city : <?php echo Session::get('login_city_name'); ?>
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      @if(empty($session_permissions) && $session_user->roles!='admin')
      <div class="col-md-12">
          <div class="alert alert-danger" role="alert">
            <strong>Sorry!</strong>  Admin not approve your access permission please contact with us.
          </div>
      </div>
      @endif
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection