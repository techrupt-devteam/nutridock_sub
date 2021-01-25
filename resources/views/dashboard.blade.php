@extends('layouts.master')
@section('content')
 <section class="breadcrumbs-custom">
   <div class="parallax-container"data-parallax-img="{{url('')}}/public/front/img/faq-bg.jpg">
      <div class="material-parallax parallax"><img alt=""src="{{url('')}}/public/front/img/faq-bg.jpg"style="display:block;transform:translate3d(-50%,149px,0)"></div>
      <div class="breadcrumbs-custom-body context-dark parallax-content">
         <div class="container">
            <h2 class="breadcrumbs-custom-title">Dashboard</h2>
         </div>
      </div>
   </div>
   <div class="breadcrumbs-custom-footer">
      <div class="container">
         <ul class="breadcrumbs-custom-path">
            <li><a href="{{url('')}}">Home</a></li>
            <li class="active">Dashboard</li>
         </ul>
      </div>
   </div>
</section>
<main>
   <section class="mt-4 bg-default section section-xl text-md-left">
      <div class="container">

      </div>
   </section>
</main>
@endsection