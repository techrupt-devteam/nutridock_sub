<style>
.section-error{
	font-size: 14px;
	color: #4caf50;
	background-image:url(public/front/img/noise.png);
	background-repeat: repeat;
	background-repeat: repeat;
	padding: 160px 0px 30px;
}
.f1 {
    font-size: 30px;
}
.capital {
    text-transform: uppercase;
}
#error {
    font-size: 110px;
    margin-top: 0px;
}
.row1 p {
    font-size: 30px;
}
#cflask-holder span {
    min-width: 150px;
    min-height: 150px;
    width: 150px;
    display: block;
    background-color: #fff;
    margin: 0px auto;
    text-align: center;
    border-radius: 150px;
    position: relative;
    overflow: hidden;
    border: 2px solid #fff;
}
#cflask-holder span img {
    height: 150px;
    width: auto;
    object-fit: cover;
}
.tada {
    -webkit-animation-name: tada;
    animation-name: tada;
}

.links-wrapper{
    margin-top: 20px;
}

ul.links{
    float: none;
    display: block;
    margin: 0px auto;
}
ul.links li{
    list-style-type: none;
    display: block;
    float: left;
    margin-right: 10px;
    margin-bottom: 20px;
}


ul.links li a{
    height: 50px;
    width: 50px;
    min-width: 50px;
    display: inline-block;
    padding: 3px 0px;
    background-color: #fff;
    border-radius: 50%;
    text-align: center;
    color: #4caf50;
    transition: all .2s linear; -moz-transition: all .2s linear; -webkit-transition : all .2s linear; -o-transition: all .2s linear;
}

ul.links li a:hover{
    background-color: #4caf50;
    color: #fff;
}

ul.links li a i{
    padding: 7px 0px;
}
</style>
@extends('layouts.master')
@section('content')
<section class="section-error">
  <div class="container">
    <div class="row row1">
      <div class="col-md-12 text-center">
        <h3 class="f1">Something went Wrong!</h3>
        <h1 id="error">404</h1>
        <p>Page not Found!</p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div id="cflask-holder" class="wow fadeIn animated"> 
        <span class="wow tada  animated">
        	<!--<i class="fa fa-flask fa-5x flask wow flip animated"></i> -->
         <!--   <i id="b1" class="bubble"></i> <i id="b2" class="bubble"></i> -->
         <!--   <i id="b3" class="bubble"></i> </span> -->
         <img src="public/front/img/food-gif.gif">
        </div>
      </div>
    </div>

    
    <div class="row"> <!--Links Start-->
        <div class="links-wrapper col-md-6 mx-auto">
          <ul class="links d-flex justify-content-center">
            <li class="wow fadeInRight animated">
            	<a href="https://rushabh2w.com/"><i class="fa fa-home fa-2x"></i></a>
            </li>
            <li class="wow fadeInRight animated">
            	<a href="https://www.facebook.com/nutridock0/" target="_blank"><i class="fa fa-facebook fa-2x"></i></a>
            </li>
            <li class="wow fadeInRight animated">
            	<a href="https://www.instagram.com/nutri_dock/?igshid=1iz93rjouag24" target="_blank"><i class="fa fa-instagram fa-2x"></i></a>
            </li>
          </ul>
        </div>
    </div>
    <!-- Links End--> 
  </div>
</section>
@endsection