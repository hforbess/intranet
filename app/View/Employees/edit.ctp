<div class="ui-widget">
<table cellspacing = '10' width="100%">
  <tr>
    <td>
    <h2 class="ui-widget-header">
      <?PHP echo $employee->first_name ?>
     </h2>
     </td>
    <td>
    <h2 class="ui-widget-header">
     <?PHP echo $employee->middle_name ?>
     </td>
     </h2>
    <td>
    <h2 class="ui-widget-header">
     <?PHP echo $employee->last_name ?>
     </h2>
     </td>
  </tr>
 </table>

<table>
   <tr>
    <td>
    <div class="bold">
      Department
    </div>
     </td>
    <td>
      <?PHP echo $employee->department ?>
     </td>
    <td>
    <div class="bold">
      Position
    </div>
     </td>
    <td>
     <?PHP echo $employee->position ?>
     </td>
     <td>
     <div class="bold">
      Roles
     </div>
     </td>
    <td>
     <?PHP echo $employee->user_group ?>
     </td>
  </tr>
 </table>
<table>
<tr>
    <td>
      <div class="bold">
         Vacation remaining
      </div>
    </td>
    <td>
    <?php echo $employee->pto_remaining?>
    </td>
    <td>
      <div class="bold">
         Sick time remaining
      </div>
    </td>
    <td>
    <?php echo $employee->sick_time_remaining?>
    </td>
</tr>
</table>
 <table>
     <tr>
    <td>
    <div class="bold">
      Pay period
     </div>
     </td>
    <td>

     </td>
    <td>

     </td>
  </tr>
</table>

<table cellspacing = '10' width="100%">
   <tr>
       <td>
       Date
       </td>
       <td>
       Clocked in
       </td>
       <td>
       Clocked out
       </td>
       <td>
       Time
       </td>
       <td>
       Approved
       </td>
       <td>
       Time per day
       </td>

   </tr>
   <script>
    var id_arr = new Array();
   </script>
 <?php for( $x = 0; $x < count( $employee->week_one->my_days_arr); $x++  ) : ?>

     <?php foreach ( $employee->week_one->my_days_arr[$x]->punches as $punch ) : ?>
    <script>
     id_arr.push(<?php echo $punch['TimeClock']['id']?> );
    </script>
    <tr>
        <td> 
            <?php echo $employee->week_one->my_days_arr[$x]->day_of_week?> <?php //echo $employee->week_one->my_days_arr[$x]->my_date->format('m-d-Y') ?>
         </td>
         <td>
        <input id="punch-in<?php echo $punch['TimeClock']['id']?>" type="text" value="<?php echo date("m-d-Y h:i A",strtotime($punch['TimeClock']['punch_in'] ))?>" />
        <script>
        $(function(){
             $("#punch-in<?php echo $punch['TimeClock']['id']?>").datetimepicker({
                 ampm:true,
                 onClose:function(dateText,inst)
                 {
                  updateTimes(inst.id, dateText);
                  },
                 dateFormat: 'mm-dd-yy'
                });
            })
        </script>
        </td>
        <td>
        <input id="punch-out<?php echo $punch['TimeClock']['id']?>" type="text" value="<?php echo date("m-d-Y h:i A",strtotime($punch['TimeClock']['punch_out'] ))?>" />
        <script>
        $(function(){
             $("#punch-out<?php echo $punch['TimeClock']['id']?>").datetimepicker({
                  ampm:true,
                  onClose:function(dateText,inst)
                  {
                   updateTimes(inst.id, dateText);
                   },
                  dateFormat: 'mm-dd-yy'
                 });
            })
        </script>
        </td>
         <td>
           <?php $arr  =  $employee->secondsToTime(  strtotime( date ($punch['TimeClock']['punch_out'] ) ) - strtotime ( date ( $punch['TimeClock']['punch_in'] ) ))?>
           <div id="punch_total<?php echo $punch['TimeClock']['id']?>" >
              <?php echo $arr["h"].".". $arr["m"]?>
           </div>
        </td>

        <td>
            <div id="approve_status<?php echo $punch['TimeClock']['id'] ?>" style="display:inline;">   <?php echo $punch['TimeClock']['approved'] == 1 ? "Yes" : "No"?></div> 
           <script>
            $(function(){
               $("#approve_status<?php echo $punch['TimeClock']['id'] ?>").css("color","<?php echo $punch['TimeClock']['approved'] == 1 ? "green" : "red"?>" );
                })
           </script>
            <input type="checkbox" id="approved<?php echo $punch['TimeClock']['id'] ?>" style="display:inline;" <?php echo $punch['TimeClock']['approved'] == 1 ? "checked='checked'" : ""?> />
   
            <script>
            $("#approved<?php echo $punch['TimeClock']['id'] ?>").click (function ()
            		{
            		var thisCheck = $(this);
            		if (thisCheck.is (':checked'))
            		{
            		  approve(<?php echo $punch['TimeClock']['id'] ?>)
            		}
            		else
            		{
            		  disApprove(<?php echo $punch['TimeClock']['id'] ?>)
                	}
            		});
            </script>
        </td>
        <td>
        <?php echo $employee->week_one->my_days_arr[$x]->daily_hours?> 
        </td>
    </tr>
       <?php endforeach ?>
       <?php endfor?>

    <tr>
    <td>
     <div class="bold">
     Total hours
     </div>
    </td>
        <td>
     <?PHP $arr =  $employee->secondsToTime( $employee->week_one->daily_seconds + $employee->week_two->daily_seconds  ) ?>
         <div id="total">
         <?php echo $arr["h"].".". $arr["m"]?>
         </div>
     </td>
    <td>
     <div class="bold">
     Over time
     </div>
    </td>
        <td>
     <?PHP //$arr =  @$employee->secondsToTime( $employee->over_time['week_one'] + $employee->over_time['week_two'] ) ?>
        <div id="overtime">  
        <?php //echo $arr["h"].".". $arr["m"]?>
         </div>
     </td>     
    </tr>
</table>
  </div>
  <script>
   function approve(id)
   {
	   $.ajax({
		   url: "/TimeClocks/approve/" +id ,
		   type:"post",
		   success: function(){
		     $("#approve_status"+id).html('Yes');
		     $("#approve_status"+id).css('color','green');
		     $().toastmessage('showSuccessToast', "Time Approved");
		   }
		 });
   }
   function disApprove(id)
   {
	   $.ajax({
		   url: "/TimeClocks/disapprove/" +id ,
		   type:"post",
		   success: function(){
		   $("#approve_status"+id).html('No');
		   $("#approve_status"+id).css('color','red');
		   $().toastmessage('showSuccessToast', "Time Disapproved");
		   }
		 });
   }
   function updateTimes(id,my_time)
   {

	   $.ajax({
		   url: "/TimeClocks/updateTimes/" +id +"?my_time="+my_time ,
		   type:"post",
		   dataType: 'json',
		   success: function(data){
		   
           $("#punch_total" + data.id).text(data.total_time);
           $("#punch_total" + data.id).effect("highlight",{"color":"green"}, 3000);

           var total = 0;
		   for( x = 0; x < id_arr.length; x++)
		   {
            total += parseFloat ( $("#punch_total"+ id_arr[x]).text() );
          
		   }
		   console.debug( id_arr);
		   var overtime = 0;
		   if ( total > 80 )
		   {
           overtime = total - 80;
            total = 80;
		   }
          
           overtime = overtime.toFixed(2);
           total = total.toFixed(2);
           $("#total").html(total);
           $("#total").effect("highlight", {"color":"green"}, 3000);
           $("#overtime").html( overtime );
           $("#overtime").effect("highlight", {"color":"green"}, 3000);
		   $().toastmessage('showSuccessToast', "Time updated successfully");
		   }
		 });
   }
   
  </script>