@extends('layouts.master') 
@section('content')

<main id="main">
  <section>
    <div class="container" style="margin-top: 4rem;">
      <div class="section-title"style="max-width:626px;margin:0 auto">
      	<img class="img-fluid"src="{{url('')}}/public/front/img/failed.png"/>
      	<h2 style="color: #fc7878;">Oops Payment Failed</h2>
        <p class="lead">
        	Sorry transaction is Failed !! <br/>
            please try again.
        </p>
      </div>
    </div>
  </section>
</main>



@endsection