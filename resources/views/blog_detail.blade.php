@extends('layouts.master') @section('content')<section class="breadcrumbs-custom"><div class="parallax-container"data-parallax-img="{{url('')}}/public/front/img/bg-blog.jpg"><div class="material-parallax parallax"><img src="{{url('')}}/public/front/img/bg-blog.jpg"alt=""style="display:block;transform:translate3d(-50%,149px,0)"></div><div class="breadcrumbs-custom-body context-dark parallax-content"><div class="container"><h2 class="breadcrumbs-custom-title">Blog Post</h2></div></div></div><div class="breadcrumbs-custom-footer"style="display:block"><div class="container"><ul class="breadcrumbs-custom-path"><li><a href="{{url('')}}/blog">Blog</a></li><li class="active">Blog Detail</li></ul></div></div></section><?php foreach($arr_data as $row);$category_id=$row->category_id;$blog_id=$row->id;$value=\DB::table('categories')->where('id',$category_id)->get();foreach($value as $cate_row); ?><main><section class="bg-default mb-5 pt-5 section section-xl text-md-left"><div class="container"><div class="row row-50 row-md-60"><div class="col-lg-8 col-xl-9"><div class="inset-xl-right-70"><div class="row row-50 row-md-60 row-lg-80 row-xl-100"><div class="col-12"><article class="post box-xxl post-modern" style="text-align: justify;"><div class="post-modern-panel"><div><a href="javascript:;"class="post-modern-tag">{{$cate_row->name}}</a></div><div><time datetime="2020-08-09"class="post-modern-time">{{ date('F d, Y', strtotime($row->created_at)) }}</time></div></div><h1 class="post-modern-title"><a href="javascript:;">{{$row->blog_title}}</a></h1><a href="javascript:;"class="post-modern-figure"><img src="{{url('')}}/uploads/images/{{$row->image}}"alt=""height="394"width="800"></a><p class="post-modern-text" ><?php echo stripslashes($row->blog_description); ?></p></article><div class="single-post-bottom-panel"><div class="group-sm group-justify"><div class="mobile-size-adjut"><div class="group-sm group-tags"><a href="#"class="link-tag">Fruits</a> <a href="#"class="link-tag">Vegetables</a><a href="#"class="link-tag">Drinks</a></div></div><div>
    <div class="group-middle group-xs"><span class="list-social-title">Share</span>
<div>
<ul class="list-inline list-inline-sm list-social">
<li><?php $actual_link=(isset($_SERVER['HTTPS'])?"https:":"https:")."//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>
<div id="fb-root"></div>
<script async src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v9.0" crossorigin="anonymous" defer nonce="qhWcjDrJ"></script>
<div data-href="<?php echo stripslashes($actual_link); ?>" data-layout="button" data-size="small">
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo stripslashes($actual_link); ?>" class="fb-xfbml-parse-ignore" target="_blank"><i class="fa fa-facebook"></i>
    </a>
</div>
</li>
<li>
<a href="https://www.instagram.com/nutri_dock/?igshid=1iz93rjouag24/"target="_blank"><i class="fa fa-instagram"></i></a></li>
<li><a href="https://twitter.com/share?ref_src=twsrc%5Etfw"class="twitter-share-button"target="_tab"data-show-count="false"><i class="fa fa-twitter"></i></a><script async src="<?php echo $actual_link; ?>"charset="utf-8"></script></li>
<li><a href="http://plus.google.com/share?url=<?php echo $actual_link; ?>"class="icon mdi mdi-google-plus"target="_tab"><i class="fa fa-google-plus"></i></a></li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div><?php if($benefits_data){ ?><div class="col-12"><?php if($benefits_data){ ?>
<div class="mb-3"><h3 class="text-dark">Top 9 Benefits of Cabbage</h3>
</div><?php } ?>@foreach($benefits_data as $row)<div class="mb-3"><h5 class="mb-2 mt-2"style="font-family:Ruda,sans-serif;color:#333">{{$row->title}}</h5>
<img src="{{url('')}}/uploads/images/{{$row->image}}"class="mb-3 d-block img-fluid mt-4 mx-auto"><p class="mt-2">{{$row->title_description}}</p>
</div>@endforeach</div><?php } ?>
<div class="col-12">
<h6 class="single-post-title">Related Posts</h6><div class="row row-30"><?php $random_value=\DB::table('blog')->where('category_id',$category_id)->inRandomOrder()->limit(2)->get();foreach($random_value as $random_blog_row): $link = $random_blog_row->link;
                           				$dashedTitle = str_replace(" ", "-", $link); ?><div class="col-sm-6"><article class="post box-md post-classic"><a href="{{url('')}}/blog_detail/{{$dashedTitle}}"class="post-classic-figure"><img src="{{url('')}}/uploads/images/{{$random_blog_row->image}}"alt=""height="239"width="370"></a><div class="post-classic-content"><div class="post-classic-time"><time datetime="2020-09-08">{{ date('F d, Y', strtotime($random_blog_row->created_at)) }}</time></div><h2 class="post-classic-title" style="font-size:1.25rem"><a href="{{url('')}}/blog_detail/{{$dashedTitle}}">{{$random_blog_row->blog_title}}</a></h2><p class="post-classic-text" style="text-align: justify;">{!! substr(strip_tags($random_blog_row->blog_description), 0, 150) !!}</p></div></article></div><?php endforeach; ?></div></div><?php if($comment){ ?><div class="col-12"><h6 class="single-post-title">Comments</h6><?php foreach($comment as $key=>$comment_row):foreach($comment_row as $key_dtl=>$row){$getname=\DB::table('comments')->select('name')->where('id',$row->comment_id)->get();foreach($getname as $row_name);$reply_data=end($comment_row);foreach($reply_data as $reply_row);$realArray=(array)$reply_data;$value=array_slice($realArray,4,1); ?><div class="box-comment"><div class="flex-column unit flex-sm-row unit-spacing-md"><div class="unit-body w-100 bg-gray"><?php if($key_dtl==0){ ?><div class="group-sm group-justify"><div><div class="group-middle group-xs"><h5 class="box-comment-author ml-0"><a href="#"><?php echo $row_name->name; ?></a></h5></div></div></div><?php } ?><div class="box-comment-text ml-2"><?php echo $row->message; ?><div class="box-comment-time"><i class="icofont-clock-time"style="font-size:13px"></i> <time datetime="2020-08-30">{{ date('F d, Y', strtotime($row->created_at)) }}</time></div></div></div></div><?php foreach($max_record as $max_row); ?><?php if($row->reply){ ?><div class="box-comment admin-reply border-0"><div class="flex-column unit flex-sm-row unit-spacing-md"><div class="unit-body w-100"><div class="group-sm group-justify"><div><div class="group-middle group-xs"><h5 class="box-comment-author ml-0 mb-2"><a href="javascript:;">Admin</a></h5></div></div></div><div class="box-comment-text ml-2"><?php echo $row->reply; ?><?php if($row->reply==$value['reply']){ ?><div class="box-comment-time custom-border-bottom"><i class="icofont-clock-time"style="font-size:15px"></i> <time datetime="2020-08-30">{{ date('F d, Y', strtotime($row->created_at)) }}</time> <button class="btn box-comment-reply reply"type="submit"data-val="<?php echo $row->comment_reply_id; ?>"><i class="icofont-chat"style="font-size:13px"></i> Reply</button></div><?php } ?></div></div></div></div><?php } ?></div><div class="divReplyComment divReply<?php echo $row->comment_reply_id; ?>"style="display:none"><form action="{{url('')}}/comment/new_comment"method="post"><div class="row form-row"><div class="mb-3 input-group"><input name="_token"type="hidden"value="{{ csrf_token() }}"id="token"> <textarea class="form-control"name="message_data"placeholder="Message"id="message_data"type="text"></textarea> <input name="blog_id"type="hidden"value="{{$row->blog_id}}"class="blog_id_data"> <input name="comment_id"type="hidden"value="{{$row->comment_id}}"class="comment_id_data"> <input name="id"type="hidden"value="{{$max_row->id}}"class="id_data"><div class="validate"></div><div class="input-group-append"><span class="input-group-text"style="height:62px"><button class="btn btn-success submitForm"type="submit"data-val="<?php echo $row->id; ?>">Submit</button></span></div></div></div></form></div><?php }endforeach; ?></div><?php } ?><div class="col-12"><h6 class="single-post-title">Leave a comment</h6><form action="{{url('')}}/comment/store_comment"method="post" onsubmit="return submitUserForm();">{{csrf_field()}}<div class="row form-row"><div class="col-12 col-md-6 form-group mb-3"><input name="name"class="form-control"data-msg="Please enter at least 4 chars"data-rule="minlen:4"id="name"placeholder="Your Name"required> <input name="blog_id"type="hidden"value="{{$blog_id}}"><div class="validate"></div></div><div class="col-12 col-md-6 form-group mb-3"><input name="email"type="email"class="form-control"data-msg="Please enter a valid email"data-rule="email"id="email"placeholder="Your Email"required>
                           				<div class="validate"></div></div></div><div class="mb-3 form-group mt-3"><textarea class="form-control"name="message"placeholder="Message"data-msg="Please write something for us"required rows="5"></textarea>
                           				<div class="validate"></div>
                           				</div>
                           				<div class="form-group col-md-4" style="margin-left: -15px;">
                                        <div class="g-recaptcha" data-sitekey="6LeUQvcZAAAAADPLG3rEpvKuzN8eIOdy1zrLdXoP" data-callback="verifyCaptcha"></div>
                                        <div id="g-recaptcha-error" style="color:red;"></div>
                                      </div>
                                     	<div class="text-left">
                           				<button class="button"type="submit">Send Message</button>
                           				</div>
                           				</form>
                           				</div>
                           				</div>
                           				</div>
                           				</div>
                           				
                           				<div class="col-lg-4 col-xl-3 mobile-issue-orlay"><div class="row row-30 aside justify-content-md-between row-md-50"><div class="col-lg-12 aside-item col-sm-6 col-md-5"><h6 class="aside-title">Categories</h6><ul class="list-categories">@foreach($cate_data as $cate_row)<?php $cate_id=$cate_row->id;$value=\DB::table('blog')->where('category_id',$cate_id)->get(); ?><li><a href="#">{{$cate_row->name}}</a><span class="list-categories-number">({{count($value)}})</span></li>@endforeach</ul></div><div class="col-lg-12 aside-item col-sm-6"><h6 class="aside-title">Latest Posts</h6><div class="row gutters-10 mt-4 row-20 row-lg-30"><?php foreach($recent_data as $row):  $link = $row->link;
                                        $dashedTitle = str_replace(" ", "-", $link);?><div class="col-lg-12 col-6"><article class="post post-minimal"><div class="flex-column unit align-items-lg-center flex-lg-row unit-spacing-sm"><div class="unit-left"><a href="{{url('')}}/blog_detail/{{$dashedTitle}}"class="post-minimal-figure"><img src="{{url('')}}/uploads/images/{{$row->image}}"alt=""height="104"width="106"></a></div><div class="unit-body"><p class="post-minimal-title"><a href="{{url('')}}/blog_detail/{{$dashedTitle}}"><!--{!! substr(strip_tags($row->blog_title), 0, 20) !!}-->{!! $row->blog_title !!}</a></p><div class="post-minimal-time"><time datetime="2020-03-15">{{ date('F d, Y', strtotime($row->created_at)) }}</time></div></div></div></article></div><?php endforeach; ?></div></div></div></div></div></div></section></main><script src='https://www.google.com/recaptcha/api.js'></script>
<script>
    function submitUserForm() {
        
    return 0 !=grecaptcha.getResponse().length||(document.getElementById("g-recaptcha-error").innerHTML='<span style="color:red;">This field is required.</span>',  !1)
}

function verifyCaptcha() {
    
    document.getElementById("g-recaptcha-error").innerHTML=""
}
</script>@endsection