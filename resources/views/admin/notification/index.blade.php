@extends('admin.layout.master')
 
@section('content')
 <link rel="stylesheet" href="{{url('/admin_css_js')}}/css_and_js/admin/dist/css/AdminLTE.min.css">
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ "Latest ".$title }} <i class="fa fa-bell"></i>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
           @include('admin.layout._status_msg')
        <div class="col-md-12">
          <!-- The time line -->
          <ul class="timeline">
               
            @foreach($notification as $value)  
           
            <li class="time-label">
              <span class="bg-green">
                {{ date('d M y',strtotime($value->created_at))}}
              </span>
            </li>
            <li>
              <i class="fa fa-bell bg-green"></i>
              <div class="timeline-item">
         
                <h3 class="timeline-header"> {!! html_entity_decode($value->message)!!} </h3>
              </div>
            </li>
           @endforeach
          </ul>
         
          </div> 
      </div>
    </section>
  </div>
@endsection