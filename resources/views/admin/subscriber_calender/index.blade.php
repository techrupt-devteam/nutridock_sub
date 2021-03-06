@extends('admin.layout.master')
<?php 
  $login_city_id       = Session::get('login_city_id'); 
  $login_city_state    = Session::get('login_city_state'); 
?>
@section('content')

  <div class="content-wrapper">
    <section class="content">
      <div class="row">
        
       
         <!--  <div class="box-body">
             <div class="col-md-12">
              <div class="alert alert-info alert-dismissible">
                <h4><i class="fa fa-sticky-note"></i> Note!</h4>
                <strong>Please select state, city and choose subscriber to detail view meal program !!</strong>
              </div>
          </div>
        </div>
       -->

        <div class="col-md-12">
          
          <!-- /. box -->
          <div class="box box-solid">
            <div class="box-header with-border" style="background-color: #66b31e4d;">
              <h3 class="box-title">View Subscriber Meal Plan</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-info alert-dismissible">
                      <h4><i class="fa fa-sticky-note"></i> Note!</h4>
                      <strong>Please select state, city and choose subscriber to detail view meal program !!</strong>
                    </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="state_id">State<span style="color:red;" >*</span></label>
                      <select class="form-control select2" name="state_id" id="state_id" required="true" data-parsley-errors-container="#state_error" data-parsley-error-message="Please select state." onchange="getCity();">
                        <option value="">-Select State-</option>
                        @foreach($state as $svalue)

                          <?php if(isset($login_city_state) && !empty($login_city_state) && $login_city_state == $svalue->id){
                            $selected ="selected";
                          }else{
                            $selected ="";
                          }?>

                        <option value="{{$svalue->id}}" {{$selected}}>{{$svalue->name}}</option>
                        @endforeach
                      </select>
                      <div id="state_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="state_id">City<span style="color:red;" >*</span></label>
                      <select class="form-control select2" name="city_id" id="city_id" required="true" data-parsley-errors-container="#city_error" data-parsley-error-message="Please select City." onchange="getSubscriber();" disabled="">
                        <option value="">-Select City-</option>
                       
                      </select>
                      <div id="city_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="state_id">Subscriber<span style="color:red;" >*</span></label>
                      <select class="form-control select2" name="subscriber_id" id="subscriber_id" required="true" data-parsley-errors-container="#subscriber_error" data-parsley-error-message="Please select Subscriber." onchange="getCalender();" disabled="">
                        <option value="">-Select State-</option>
                       
                      </select>
                      <div id="subscriber_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
              </div>
                <div class="row">
                  <div class="col-md-12">
                    
                  </div>
              <!-- <div class="input-group">
                <input id="new-event" type="text" class="form-control" placeholder="Event Title">
                <div class="input-group-btn">
                  <button id="add-new-event" type="button" class="btn btn-primary btn-flat">Add</button>
                </div>
              </div> -->
            </div>
          </div>
        </div>
       <!--------------Calender Data Load Div------------->
        <div class="row" id="old_calender">
          <div class="col-md-12">
          
          <div class="box box-primary">
            <div class="box-body no-padding">
              <!-- THE CALENDAR -->
              <div id="calendar_old"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
       <div class="row" id="new_calender">
       </div>
      </div>
        
      <!-- /.row -->
    </section>
  </div>
<script src="{{url('/admin_css_js')}}/css_and_js/admin/jquery/dist/jquery.min.js"></script>
<script src="{{url('/admin_css_js')}}/css_and_js/admin/jquery-ui/jquery-ui.min.js"></script>
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.css' rel='stylesheet' />
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='https://cdn.jsdelivr.net/npm/moment@2.24.0/min/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.js'></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/select2/dist/js/select2.full.min.js"></script>
<link rel="stylesheet" href="{{ url('/admin_css_js')}}/css_and_js/admin/select2/dist/css/select2.min.css">

<script>

<?php  if(isset($login_city_state) && !empty($login_city_state)) {?>
 getCity();

 getSubscriber1();
 function  getSubscriber1(){
   //   alert("test");
      $.ajax({
        type: "POST",
        url: "{{url('/admin')}}/getSubscriber",
        data: {
          state: <?php echo $login_city_state?>,
          city : <?php echo $login_city_id?>
        }
      }).done(function(data) {
           $("#subscriber_id").html(data);
           $('#subscriber_id').removeAttr("disabled");
          
      });
    }  

    $("#state_id").attr("disabled", true);

<?php }?>

//City  load 
  function  getCity(){
      var state_id = $("#state_id").val();
      $.ajax({
        type: "POST",
        url: "{{url('/admin')}}/getCity",
        data: {
          state: state_id
        }
      }).done(function(data) {
           $("#city_id").html(data);
           $('#city_id').removeAttr("disabled")
           <?php  if(isset($login_city_state) && !empty($login_city_state)) {?>
           $('#city_id').val(<?php echo $login_city_id; ?>);
               $("#city_id").attr("disabled", true);
         <?php } ?>
      });
    } 
  
  //Subscriber load
  function  getSubscriber(){
      var city_id = $("#city_id").val();
      var state_id = $("#state_id").val();
      $.ajax({
        type: "POST",
        url: "{{url('/admin')}}/getSubscriber",
        data: {
          state: state_id,
          city : city_id
        }
      }).done(function(data) {
           $("#subscriber_id").html(data);
           $('#subscriber_id').removeAttr("disabled")
      });
    }  
 //
  function getCalender(){
    var subscriber_id =$('#subscriber_id').val();
    $.ajax({
      type: "POST",
      url: "{{url('/admin')}}/getMealDetails",
      data: {
        subscriber_id: subscriber_id
      }
    }).done(function(data) {
 
    $('#old_calender').hide();
    $('#new_calender').html(data);
  });
}  



   $(function () {
   
      jq223 = jQuery.noConflict(false);
       
        function init_events(ele) {
          ele.each(function () {
            var eventObject = {
              title: $.trim($(this).text())
            }

            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject)
            // make the event draggable using jQuery UI
            $(this).draggable({
              zIndex        : 1070,
              revert        : true, // will cause the event to go back to its
              revertDuration: 0  //  original position after the drag
            })
          })
        }
          init_events($('#external-events div.external-event'))
     
        var date = new Date()

        var d    = date.getDate(),
            m    = date.getMonth(),
            y    = date.getFullYear()   
          
        $('#calendar_old').fullCalendar({
          header    : {
            left    : 'prev,next',
            center  : 'title',
            right   : 'month'
          },
          buttonText: {
            today   : 'today',
            month   : 'month',
            },
       
         
          events    : [ 

          ],

          editable  : false,
          droppable : false,

        })
     
      })

 $('.select2').select2();
</script>
<style type="text/css">
  .fc-time{
    display: none !important;
  }
</style>
@endsection
