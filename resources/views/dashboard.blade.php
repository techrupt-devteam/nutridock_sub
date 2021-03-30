@extends('layouts.subscriber_master')
@section('content')
<main>
   <section class="user-panel">
      <div class="container">
          @php $title ="Profile"; @endphp 
          <!-- @include('layouts.bread_crum') -->
           <div class="row">
               @include('layouts.subscriber_sidebar')
              <div class="col-md-8 col-lg-9  my-account">
               <div class="profile-container">
                  <div class="mobile-mapping-status">
                     <div class="alert alert-info">
                        <div class="icon-wrap float-left">
                           <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        </div>
                        <div class="message" style="width: calc(100% - 28px);display: inline-block;"> 
                           Your phone number is still verified! For security reasons, we recommend you to verify  your mobile number now! 
                        </div>
                     </div>
                  </div> 
                  <div class="user-details">
                  <div class="inner">
                     <div>
                        <img src="{{url('')}}/public/front/img/no-image.jpeg" alt="user" class="profile-img">
                     </div>
                     <div>
                        <div class="name">Surendra Singh Rathore</div>
                        <div class="contact-info"><div>
                           <span class="key">Email:&nbsp;</span> surendrajnvu@gmail.com </div>
                           <div>
                              <span class="key">Mobile:&nbsp;</span> 7028102190</div>
                              <div>
                                 <span class="key">Date of Birth:&nbsp;</span>
                                 <input type="date" readonly="" value="1992-02-17" style="border: medium none;"></div>
                                 <div class="change-password"><span>
                                    <i class="padlock fa fa-unlock-alt"></i> change password </span>
                                 </div>
                              </div>
                           </div>
                          <a href="" data-toggle="modal" data-target="#edit-profile"> <span class="edit-link"><i class="icon fa fa-pencil"></i> EDIT </span> </a>
                        </div>
                     </div> 
                    <div class="address-coupon-container clearfix mt-3"><div>
                       <div class="heading pt20"> My Address 
                        <span class="add-address">Add New Address </span>
                      </div>
                      <div class="card-view">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="content">
                                 <span class="tag">Nashik</span>
                                 <div class="description pb5">
                                    <div class="name"> Surendra Singh</div> B-7 Hari Om appartment Shikhrewadi&amp;#10;Nashik Road, Nashik&amp;#10;Maharashtra,  Nashik -  422101,  Maharashtra 
                                    <div class="contact">+91-7028102190</div>
                                   </div>
                                   <div class="actions">
                                      <span class="action-link" title="Edit">
                                         <i class="icon fa fa-pencil"></i> EDIT 
                                      </span>
                                      <span class="action-link" title="Remove">
                                         <i class="icon fa fa-trash-o"></i> REMOVE 
                                      </span>
                                  </div>
                                </div>
                           </div>
                           <div class="col-md-6">
                              <div class="content">
                                 <span class="tag">Jayal</span>
                                 <div class="description pb5">
                                    <div class="name"> Surendra Singh</div> W-2 Near Patrol Pump dugoli,  Jayal -  341023,  Rajasthan 
                                    <div class="contact"> +91-9413477711 </div>
                                 </div>
                                 <div class="actions">
                                    <span class="action-link" title="Edit"><i class="icon fa fa-pencil"></i> EDIT </span><span class="action-link" title="Remove"><i class="icon fa fa-trash-o"></i> REMOVE </span>
                                 </div>
                              </div>
                           </div>
                        </div> 
                        </div>
                     </div>
                  </div> 
               </div>
              </div>
           </div> 
      </div>
   </section>
</main>
<!-- The Modal -->
<div class="modal" id="edit-profile">
   <div class="modal-dialog">
     <div class="modal-content">
 
       <!-- Modal Header -->
       <div class="modal-header p-2">
         <h4 class="modal-title" style="font-size: 21px;">Edit Profile</h4>
         <button type="button" class="close" data-dismiss="modal">&times;</button>
       </div>
 
       <!-- Modal body -->
       <div class="modal-body">
         <div class="user-pic">
            <img src="http://www.nykaa.com/media/profilepic/1782591.jpg?2017-02-0704:20:30" alt="user" class="img">
         </div>
         <div class="form-group">
            <label class="font-weight-bold">Full Name</label>
            <input type="text" class="form-control" placeholder="fullname">
         </div>
         
         <div class="form-group">
            <label class="font-weight-bold">Email Id</label>
            <input type="email" class="form-control" placeholder="email">
         </div>
         
         <div class="row">
            <div class="col-sm-6">
               <div class="form-group">
                  <label class="font-weight-bold">Phone No.</label>
                  <input type="text" class="form-control" maxlength="10" minlength="10" placeholder="phone no">
               </div>
            </div>
            <div class="col-sm-6">
               <div class="form-group">
                  <label class="font-weight-bold">Date of Birth</label>
                  <input type="date" class="form-control">
               </div>
            </div>
         </div>
         <div class="form-group">
            <label class="font-weight-bold d-block">Gender</label>
            <div class="form-check-inline">
               <label class="form-check-label">
                 <input type="radio" class="form-check-input" name="optradio">Male
               </label>
             </div>
             <div class="form-check-inline">
               <label class="form-check-label">
                 <input type="radio" class="form-check-input" name="optradio">Female
               </label>
             </div>
         </div>
         
       </div>
 
       <!-- Modal footer -->
       <div class="modal-footer text-center" style="justify-content: center;">
         <button class="btn btn-dark rounded-0">Submit Detail</button>
       </div>
 
     </div>
   </div>
 </div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

@endsection