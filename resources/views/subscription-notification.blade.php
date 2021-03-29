<?php $seo_title = "";?>
@extends('layouts.subscriber_master')
@section('content')
<style>
   .user-panel {
       margin-top: 4.5rem;
   }
</style>
<main>
   <section class="user-panel">
      <div class="container mt-3">
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