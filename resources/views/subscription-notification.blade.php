<?php $seo_title = "";?>
@extends('layouts.subscriber_master')
@section('content')

<main>
<section class="breadcum">
    <div class="container-fluid">
      <div class="col-sm-6">
        <!-- <h4 class="mb-0">Notification</h4> -->
        <ol class="breadcrumb product_des-breadcrumb bg-white mb-0 pl-0">
          <li><a href="http://localhost/nutridock_sub">Dashboard &nbsp;</a></li>
          <li class="breadcrumb-item active breadCrumbLevel"> / &nbsp; <span>Notification</span></li>
        </ol>
      </div>
    </div>
  </section>
   <section class="user-panel" style="margin-top: 0.8rem;">
      <div class="container-fluid mt-3">
            @php $title ="notification"; @endphp 
            <!-- @include('layouts.bread_crum') -->
           <div class="row">
            @include('layouts.subscriber_sidebar')
               <div class="col-md-8 col-lg-9  my-account">
                  <div class="profile-container box box-success">
                     <div class="box-header with-border">
                        Notification
                     </div>
                     <div class="box-body p-3">
                 @foreach($notification as $value)  
                  <div class="mobile-mapping-status">
                     <div class="alert-bar d-flex mb-2 pb-2 border-bottom">
                        <div class="icon-wrap">
                           <i class="fa fa-bell" aria-hidden="true"></i>
                        </div>
                        <div class="message"> 
                           {{ $value->message }} 
                        </div>
                     </div>
                  </div>
                @endforeach
               </div>
           </div> 
      </div>
      </div>
   </section>
</main>
@endsection