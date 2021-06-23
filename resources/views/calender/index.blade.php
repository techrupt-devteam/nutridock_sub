
       <!--------------Calender Data Load Div------------->

   <?php if($data['datacount']==0){?>
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-body"><br/>
            <div class="alert alert-info alert-dismissible">
              <h4><i class="icon fa fa-warning"></i> Alert!</h4>
              <p>Meal program is not created for this subscriber, <b>please contact nutritionist or operation manager!!</b></p>
            </div>
          </div>
        </div>
      </div>
   <?php } else { ?>

   <div class="col-md-12" >
      <div class="box box-primary">
          <div class="box-body" style="padding:20px !important;">
             
              <div id="calendar"></div>
             
          </div>
      </div>
    </div> 
  <?php } ?>
        
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

<script type="text/javascript">

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
     
        /*var date = new Date()

        var d    = date.getDate(),
            m    = date.getMonth(),
            y    = date.getFullYear()   
       */
        $('#calendar').fullCalendar({

         
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

          <?php for($i=1;$i<=$data['days'];$i++) {
             if(isset($data['calender_data'][$i]) && !empty($data['calender_data'][$i])){
               $count=count($data['calender_data'][$i]);
            
             if($count>0){ 
              for($j=0 ;$j<$count;$j++){ 
               

                ?>
          
            {
              title          : '<?php echo $data['calender_data'][$i][$j]['title'];?>',
              start          : '<?php echo date('Y',strtotime($data['calender_data'][$i][$j]['start']));?>,<?php echo date('m',strtotime($data['calender_data'][$i][$j]['start']));?>,<?php echo date('d',strtotime($data['calender_data'][$i][$j]['start']));?>',

              backgroundColor: '<?php echo $data['calender_data'][$i][$j]['backgroundColor'];?>', 
              tooltip        : '<?php echo $data['calender_data'][$i][$j]['ref_program_id'];?>',
               <?php if(!is_null($data['calender_data'][$i][$j]['set_date'])){?>
              description        : '<?php echo $data['calender_data'][$i][$j]['tooltip']." ( compensated from ".date('d-m-Y',strtotime($data['calender_data'][$i][$j]['set_date']));?> )',
              <?php }else {?>
              description        : '<?php echo $data['calender_data'][$i][$j]['tooltip'];?> ',
              <?php }?>
              borderColor    : '<?php echo $data['calender_data'][$i][$j]['borderColor'];?>' 
            },
            
          <?php
              }
             }
            }
           }
          ?>
          

          ],
            

          eventRender: function(eventObj, $el) {
           
           var str = eventObj.tooltip;
           var data = str.split("#");
            /*if(data[0]!="" && data[1]=="y"){ 


            alert("ref_program_id "+data[0]);
            alert("skip_meal_flag "+data[1]);

            var userDate = eventObj.start;
            var date_string1 = moment(userDate, "DD.MM.YYYY").format("YYYY-MM-DD");

            //alert($el.find('.fc-day fc-widget-content fc-'+data[3]+' fc-future').attr("data-date")); 

            alert($(".fc-future").attr("data-date"));
            // alert("Date "+$(".fc-day fc-widget-content fc-"+data[3]+" fc-future").attr("data-date"));
            // alert("name "+data[3]);

            }*/
            $el.popover({
              title: eventObj.title,
              content: eventObj.description,
              description:"test",
              trigger: 'hover',
              placement: 'top',
              container: 'body'
            });
          },
          editable  : false,
          droppable : false,

        })
     
      })

</script>
<style type="text/css">
.fc-time{
   display: none !important;
}
.popover-title
{  background-color: #f3f212;font-weight: 600;
   text-align: center;
}
.fc-day-grid-event {
    text-align: center;
    padding: 6px !important;
    max-width: 79%;
    text-transform: uppercase;
    color: #000;
    margin: 2px auto !important;
}
.popover-title {
    background-color: #66b31e !important;
    border-radius: 4px 4px 0 0  !important;
    color: #FFF !important;
}
.popover{
    border: 1px solid #4caf50;border-radius: 4px !important;
}
.fc-scroller{
    /* height: 516px; */
    overflow: none !important;
}
.fc-scroller.fc-day-grid-container {
    overflow: unset !important;
    height: auto !important;
}

.popover-header {
    padding: .5rem .75rem !important;
    font-size: 1rem !important;
    color: inherit !important;
    font-weight: 900 !important;
    background-color: #8bc34a !important;
    border-bottom: 1px solid #ebebeb !important;
    border-top-left-radius: calc(.3rem - 1px) !important;
    border-top-right-radius: calc(.3rem - 1px) !important;
    margin-top: 0px !important;
    margin-bottom: 0px !important;
}
.popover-content{
      font-weight: bolder !important;
 }
</style>
