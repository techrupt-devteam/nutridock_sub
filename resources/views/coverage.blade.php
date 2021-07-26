<?php $seo_title ="coverage"; ?>
@extends('layouts.master')
<?php session_start();?>
@section('content')
<section class="breadcrumbs-custom">
    <div class="parallax-container"data-parallax-img="{{url('')}}/public/front/img/faq-bg.jpg">
        <div class="material-parallax parallax">
            <img alt=""src="{{url('')}}/public/front/img/faq-bg.jpg"style="display:block;transform:translate3d(-50%,149px,0)">
        </div>
        <div class="breadcrumbs-custom-body context-dark parallax-content"><div class="container"><h2 class="breadcrumbs-custom-title">Coverage</h2>
        </div>
    </div>
    </div>
        <div class="breadcrumbs-custom-footer"><div class="container">
            <ul class="breadcrumbs-custom-path">
                <li><a href="{{url('')}}">Home</a></li>
                <li class="active">Coverage</li>
            </ul>
        </div>
    </div>
</section>
<main>
    <section class="mt-4 bg-default section section-xl text-md-left">
        <div class="container">
           <div class="row">
      @foreach($data as $dvalue)     
      <div class="col-md-6">
         <div class="card flex-md-row mb-4 shadow-sm h-md-250">
            <div class="card-body d-flex flex-column align-items-start">
               <strong class="d-inline-block mb-2 text-primary">{{$dvalue->link_name}}</strong>
              <!--  <h6 class="mb-0">
                  <a class="text-dark" href="#">40 Percent of People Can’t Afford Basics</a>
               </h6> -->
               <div class="mb-1 text-muted small">{{date('M-d',strtotime($dvalue->cdate))}}</div>
               <p class="card-text mb-auto">{{$dvalue->short_description}}</p>
               <a class="btn btn-outline-primary btn-sm" target="_blank" role="button" href="{{$dvalue->link}}">Continue reading</a>
            </div>
            <img class="card-img-right flex-auto d-none d-lg-block" alt="Thumbnail [200x250]" src="{{url('/')}}/uploads/link/thumb/{{$dvalue->image}}" style="width: 200px; height: 250px;">
         </div>
      </div>
      @endforeach
      <!-- <div class="col-md-6">
         <div class="card flex-md-row mb-4 shadow-sm h-md-250">
            <div class="card-body d-flex flex-column align-items-start">
               <strong class="d-inline-block mb-2 text-success">Health</strong>
               <h6 class="mb-0">
                  <a class="text-dark" href="#">Food for Thought: Diet and Brain Health</a>
               </h6>
               <div class="mb-1 text-muted small">Nov 11</div>
               <p class="card-text mb-auto">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
               <a class="btn btn-outline-success btn-sm" href="http://www.jquery2dotnet.com/">Continue reading</a>
            </div>
            <img class="card-img-right flex-auto d-none d-lg-block" alt="Thumbnail [200x250]" src="//placeimg.com/250/250/nature" style="width: 200px; height: 250px;">
         </div>
      </div> -->
   </div>
        </div>
    </section>
</main>
@endsection
<style type="text/css">
.social-card-header{position:relative;display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;-ms-flex-pack:center;justify-content:center;height:96px}.social-card-header i{font-size:32px;color:#fff}.bg-facebook{background-color:#3b5998}.text-facebook{color:#3b5998}.bg-google-plus{background-color:#dd4b39}.text-google-plus{color:#dd4b39}.bg-twitter{background-color:#1da1f2}.text-twitter{color:#1da1f2}.bg-pinterest{background-color:#bd081c}.text-pinterest{color:#bd081c}.share:hover{text-decoration:none;opacity:.8}
</style>