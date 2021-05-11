@extends('layouts.master')
@section('content')
<section class="breadcrumbs-custom">
    <div class="parallax-container"data-parallax-img="{{url('')}}/public/front/img/faq-bg.jpg">
        <div class="material-parallax parallax">
            <img alt=""src="{{url('')}}/public/front/img/faq-bg.jpg"style="display:block;transform:translate3d(-50%,149px,0)">
        </div>
        <div class="breadcrumbs-custom-body context-dark parallax-content"><div class="container"><h2 class="breadcrumbs-custom-title">About Us</h2>
        </div>
    </div>
    </div>
        <div class="breadcrumbs-custom-footer"><div class="container">
            <ul class="breadcrumbs-custom-path">
                <li><a href="{{url('')}}">Home</a></li>
                <li class="active">About Us</li>
            </ul>
        </div>
    </div>
</section>
            <main>
                <section class="mt-4 bg-default section section-xl text-md-left">
                    <div class="container">
                        <div class="row row-40 row-md-60">
                    <div class="col-lg-6 col-md-11 col-xl-5">
                        <article class="quote-classic-big">
                            <div class="heading-3 pt-1 quote-classic-big-text">
                                <div class="q">{{ $arr_data['title'] ?? ''}}</div></div>
                            </article>
                            <div class="tabs-custom tabs-horizontal tabs-line"id="tabs-1">
                                <div class="nav-tabs-wrap"><ul class="nav nav-tabs"><li class="nav-item"role="presentation"><a href="#tabs-1-1"class="active nav-link"data-toggle="tab">About</a></li><li class="nav-item"role="presentation"><a href="#tabs-1-2"class="nav-link"data-toggle="tab">Our mission</a></li><li class="nav-item"role="presentation"><a href="#tabs-1-3"class="nav-link"data-toggle="tab">Our goals</a></li></ul></div><div class="tab-content"><div class="active fade show tab-pane"id="tabs-1-1"><p style="text-align:justify"><?php echo stripslashes($arr_data['about']); ?></p></div><div class="fade tab-pane"id="tabs-1-2"><p style="text-align:justify"><?php echo stripslashes($arr_data['our_mission']); ?></p></div><div class="fade tab-pane"id="tabs-1-3"><p style="text-align:justify"><?php echo stripslashes($arr_data['our_goals']); ?></p></div></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-11 col-xl-7">
                            <div class="about-img position-relative px-4"><img alt="About Image"src="{{url('')}}/uploads/images/{{$arr_data['image1']}}"> <img alt="About Image"src="{{url('')}}/uploads/images/{{$arr_data['image2']}}">
                            </div>
                        </div>
                        </div>
                        </div>
                    </section>

                        <section class="section-how_we_work gap-up-2">
                            <div class="container">
                                    <div class="bottommargin-sm mb-3 border-bottom-0 heading-block mt-4 text-center">
                                        <h3 class="ls0 nott"style="font-size:35px;line-height:1.3">How We Work</h3></div><div class="row clearfix"><?php if(count($how_we_work)==3){ ?>@foreach($how_we_work as $row)<div class="bottommargin-sm mb-3 col-sm-6 col-md-4"><div class="feature-box media-box "><div class="fbox-media mx-auto"style="width:50px;height:50px"><img alt="Image"src="{{url('')}}/uploads/images/{{$row->icon_image}}"></div><div class="fbox-content px-0"><h3>{{$row->title}}</h3><p style="text-align:justify">{{$row->description}}</p></div></div></div>@endforeach<?php }elseif(count($how_we_work)==4){ ?>@foreach($how_we_work as $row)<div class="bottommargin-sm mb-3 col-sm-6 col-md-3"><div class="feature-box media-box "><div class="fbox-media mx-auto"style="width:50px;height:50px"><img alt="Image"src="{{url('')}}/uploads/images/{{$row->icon_image}}"></div><div class="fbox-content px-0"><h3>{{$row->title}}</h3><p style="text-align:justify">{{$row->description}}</p></div></div></div>@endforeach<?php }elseif(count($how_we_work)==2){ ?>@foreach($how_we_work as $row)<div class="bottommargin-sm mb-3 col-sm-6 col-md-6"><div class="feature-box media-box "><div class="fbox-media mx-auto"style="width:50px;height:50px"><img alt="Image"src="{{url('')}}/uploads/images/{{$row->icon_image}}"></div><div class="fbox-content px-0"><h3>{{$row->title}}</h3><p style="text-align:justify">{{$row->description}}</p></div></div></div>@endforeach<?php }else{ ?>@foreach($how_we_work as $row)<div class="bottommargin-sm mb-3 col-sm-6 col-lg-3"><div class="feature-box media-box "><div class="fbox-media mx-auto"style="width:50px;height:50px"><img alt="Image"src="{{url('')}}/uploads/images/{{$row->icon_image}}"></div><div class="fbox-content px-0"><h3>{{$row->title}}</h3><p>{{$row->description}}</p></div></div></div>@endforeach<?php } ?></div><div class="line mt-5"></div>
                                    </div>
                        </section>

                        <section class="what_we_stand">
                                        <div class="section mb-3">
                                            <div class="container">
                                                <div class="mx-auto heading-block text-center"style="max-width:700px"><h2 class="mb-3">What we stand for</h2>
                                                </div>
                                                <div class="clear"></div>
                                                <div class="row align-items-stretch justify-content-center">
                                                    @foreach($our_services as $row)
                                                    <div class="mt-4 col-lg-4 col-md-6">
                                                        <div class="card h-100 shadow-sm">
                                                            <div class="card-body p-2 pb-4 pt-4">
                                                                <div class="feature-box fbox-light fbox-plain flex-column">
                                                                    <div class="bottommargin-sm fbox-icon text-center">
                                                                        <img alt="Icon"src="{{url('')}}/uploads/images/{{$row->icon_image}}"style="height:60px">
                                                                    </div>
                                                                    <div class="fbox-content">
                                                                        <h3 class="ls0 nott mb-2">{{$row->title}}</h3>
                                                                        <p style="text-align:justify">{{$row->title_description}}</p>
                                                                    </div>
                                                                </div>
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