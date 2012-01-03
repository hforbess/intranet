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

<table class="">
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
<?php $my_week = 1 ?>

<?php foreach ( $employee->my_weeks as $week ) :?>
<tr>
    <td colspan="6">
    <?php echo "WEEK ". $my_week?>
    </td>
</tr>

 <?php for( $x = 0; $x < count( $week->my_days_arr); $x++  ) : ?>
     <?php $len = count( $week->my_days_arr[$x]->punches )?>
     <?php for( $y = 0; $y < count( $week->my_days_arr[$x]->punches ); $y++ ) : ?>
    <tr>
        <td>     
            <?php echo $week->my_days_arr[$x]->day_of_week?> <?php //echo $week->my_days_arr[$x]->my_date->format('m-d-Y') ?>
         </td>
         <td>
        <input id="punch-in<?php echo $week->my_days_arr[$x]->punches[$y]['TimeClock']['id']?>week-<?php echo $my_week?>-<?php echo $x?>" type="text" value="<?php echo date("m-d-Y h:i a",strtotime($week->my_days_arr[$x]->punches[$y]['TimeClock']['punch_in'] ))?>" />
        <script>
        $(function(){
             $("#punch-in<?php echo $week->my_days_arr[$x]->punches[$y]['TimeClock']['id']?>week-<?php echo $my_week?>-<?php echo $x?>").datetimepicker({
                 ampm:true,
                 dateFormat: 'mm-dd-yy',
                 onClose:function(dateText,inst)
                 {
                  updateTimes(inst.id, dateText);
                  }
                 
                });
            })
        </script>
        </td>
        <td>
        <input id="punch-out<?php echo $week->my_days_arr[$x]->punches[$y]['TimeClock']['id']?>week-<?php echo $my_week?>-<?php echo $x?>" type="text" value="<?php echo date("m-d-Y h:i a",strtotime( $week->my_days_arr[$x]->punches[$y]['TimeClock']['punch_out'] ))?>" />
        <script>
        $(function(){
             $("#punch-out<?php echo $week->my_days_arr[$x]->punches[$y]['TimeClock']['id']?>week-<?php echo $my_week?>-<?php echo $x?>").datetimepicker({
                  ampm:true,
                  dateFormat: 'mm-dd-yy',
                  onClose:function(dateText,inst)
                  {
                   updateTimes(inst.id, dateText);
                   }
                  
                 });
            })
        </script>
        </td>
         <td>
           <?php $arr = $employee->secondsToTime(  strtotime( date ( $week->my_days_arr[$x]->punches[$y]['TimeClock']['punch_out'] ) ) - strtotime ( date ( $week->my_days_arr[$x]->punches[$y]['TimeClock']['punch_in'] ) ))?>
           <div id="punch_total<?php echo $week->my_days_arr[$x]->punches[$y]['TimeClock']['id']?>" >
              <?php echo $arr["h"].".". $arr["m"]?>
           </div>
        </td>
        <td>
            <div id="approve_status<?php echo $week->my_days_arr[$x]->punches[$y]['TimeClock']['id'] ?>" style="display:inline;">   <?php echo  $week->my_days_arr[$x]->punches[$y]['TimeClock']['approved'] == 1 ? "Yes" : "No"?></div> 
           <script>
            $(function(){
               $("#approve_status<?php echo  $week->my_days_arr[$x]->punches[$y]['TimeClock']['id'] ?>").css("color","<?php echo  $week->my_days_arr[$x]->punches[$y]['TimeClock']['approved'] == 1 ? "green" : "red"?>" );
                })
           </script>
            <input type="checkbox" id="approved<?php echo $week->my_days_arr[$x]->punches[$y]['TimeClock']['id'] ?>" style="display:inline;" <?php echo  $week->my_days_arr[$x]->punches[$y]['TimeClock']['approved'] == 1 ? "checked='checked'" : ""?> />
  
            <script>
            $("#approved<?php echo $week->my_days_arr[$x]->punches[$y]['TimeClock']['id'] ?>").click (function ()
            		{
            		var thisCheck = $(this);
            		if (thisCheck.is (':checked'))
            		{
            		  approve(<?php echo $week->my_days_arr[$x]->punches[$y]['TimeClock']['id'] ?>);
            		}
            		else
            		{
            		  disApprove(<?php echo $week->my_days_arr[$x]->punches[$y]['TimeClock']['id'] ?>);
                	}
            		});
            </script>
         </td>
         <td>
         </td>
       </tr>

       <?php if (  $y  == $len - 1  ): ?>
       <tr style="background-color: #F2E8D5;">
        <td>
        </td>
        <td>
        </td>
        <td>
        </td>
        <td>
        </td>
        <td>
        </td>
         <td>
         <div id="week-<?php echo $my_week?>-<?php echo $x?>" >
        <?php echo $week->my_days_arr[$x]->daily_hours?> 
        </div>
        <input type="hidden" id="day-number<?php echo $x ?>">
        </td>
        </tr>
        <?php endif?>
       <?php endfor ?>
      <?php endfor?>
      <?php if ( $week->total_seconds > 144000 ) : ?>
      <?php  $week_overtime = $week->total_seconds - 144000 ?>
      <?php  $week_total =  144000 ?>
      <?php endif ?>

       <tr style="background-color: #CCFFAA;">
        <td>
        </td>
        <td>
        </td>
        <td>
        Week Over time
        </td>
        <td>
           <div id="week-<?php echo $my_week?>-overtime">
           <?php $arr =  MyEmployee::secondsToTime($week_overtime)?>
           <?php echo $arr['h'].".".$arr['m']?>
           </div>
        </td>
        <td>
        Week Total
        </td>
         <td>
         <div id="week-<?php echo $my_week?>-total" >
           <?php $arr =  MyEmployee::secondsToTime($week_total)?>
           <?php echo $arr['h'].".".$arr['m']?>
        </div>

        </td>
        </tr>
     <?php $my_week++?>
    <?php endforeach?>
    <tr>
    <td>
     <div class="bold">
     Total hours
     </div>
    </td>
        <td>
      <?php if ( $employee->my_weeks[0]->total_seconds > 144000 ) : ?>
      <?php  $week_one_overtime = $employee->my_weeks[0]->total_seconds - 144000 ?>
      <?php  $week_one_total =  144000 ?>
      <?php endif ?>
      <?php if ( $employee->my_weeks[1]->total_seconds > 144000 ) : ?>
      <?php  $week_two_overtime = $employee->my_weeks[1]->total_seconds - 144000 ?>
      <?php  $week_two_total =  144000 ?>
      <?php endif ?>
      <?PHP $arr =  @$employee->secondsToTime( $week_one_total + $week_two_total  ) ?>
         <div id="two-week-total">
         <?php echo $arr["h"].".". $arr["m"]?>
        
         </div>
     </td>
    <td>
     <div class="bold">
     Over time
     </div>
    </td>
        <td>
     <?PHP $arr =  @$employee->secondsToTime( $week_one_overtime + $week_two_overtime ) ?>
        <div id="two-week-overtime">  
        <?php echo $arr["h"].".". $arr["m"]?>
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

   function updateTimes(id,my_time,line_number)
   {

       var employee_id = <?php echo $employee->id ?>;
	   $.ajax({
		   url: "/TimeClocks/updateTimes/" +id +"?my_time="+my_time+"&employee_id="+employee_id ,
		   type:"post",
		   dataType: 'json',
		   success: function(data){
		   
		   $("#punch_total" + data.id).text(data.punch_time);
           $("#punch_total" + data.id).effect("highlight",{"color":"green"}, 3000);
           $("#two-week-total").html(data.two_week_total);
           $("#two-week-total").effect("highlight", {"color":"green"}, 3000);
           $("#two-week-overtime").html( data.two_week_overtime);
           $("#two-week-overtime").effect("highlight", {"color":"green"}, 3000);
           $("#week-1-overtime").html( data.week_one_overtime);
           $("#week-1-overtime").effect("highlight", {"color":"green"}, 3000);
           $("#week-1-total").html( data.week_one_total);
           $("#week-1-total").effect("highlight", {"color":"green"}, 3000);
           $("#week-2-total").html( data.week_two_total);
           $("#week-2-total").effect("highlight", {"color":"green"}, 3000);
           $("#week-2-overtime").html( data.week_two_overtime);
           $("#week-2-overtime").effect("highlight", {"color":"green"}, 3000);
           $("#"+data.day).html(data.daily_hours);
           $("#"+data.day).effect("highlight", {"color":"green"}, 3000);
		   $().toastmessage('showSuccessToast', "Time updated successfully");
		   }
		 });
   }
   
  </script>