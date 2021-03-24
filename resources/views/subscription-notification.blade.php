<?php $seo_title = "";?>
@extends('layouts.subscriber_master')
@section('content')
<main>
   <section class="user-panel">
      <div class="container">
            @php $title ="notification"; @endphp 
            @include('layouts.bread_crum')
           <div class="row">
            @include('layouts.subscriber_sidebar')
               <div class="col-md-8 col-lg-9  my-account" >
                 @foreach($notification as $value)  
                  <div class="mobile-mapping-status">
                     <div class="alert-bar">
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
   </section>
</main>
@endsection