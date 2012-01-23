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
    <div id="pto_remaining">
    <?php echo $employee->getRemainingVacation()?>
    </div>
    </td>
    <td>
      <div class="bold">
         Sick time remaining
      </div>
    </td>
    <td>
    <div id="sick_time_remaining">
    <?php echo $employee->getRemainingSick()?>
    </div>
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


<?php $my_week = 1 ?>

<?php foreach ( $employee->my_weeks as $week ) :?>
<tr>
    <td colspan="7" bgcolor="#DFFFE7">
    <?php echo "WEEK ". $my_week?>
    </td>
</tr>
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
       Work Code
       </td>

       <td>
       Time per day
       </td>

   </tr>
 <?php for( $x = 0; $x < count( $week->my_days_arr); $x++  ) : ?>

     <div id="<?php echo $week->my_days_arr[$x]->day_of_week?>-<?php echo $my_week ?>">
     <tr class="day">
        <td colspan="6">
        <?php echo $week->my_days_arr[$x]->day_of_week?> <?php echo $week->my_days_arr[$x]->my_date->format("m/d/Y") ?>
        </td>
     </tr>
     <?php if ( is_array ( $week->my_days_arr[$x]->punches) ) : ?>
     <?php foreach ( $week->my_days_arr[$x]->punches as $punch ) :?>
     
     <tr id="punch<?php echo $punch->id ?>">
     
     </tr>
     <script>
       $(function(){
           $("#punch<?php echo $punch->id ?>").load("/TimeClocks/getPunch/"+<?php echo $punch->id ?>+"/week-"+<? echo $my_week ?>+"-"+<?php echo $x ?>);
               
           })
     </script>
     <?php endforeach ?>
     <?php endif ?>
     </div>
      <tr>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
         <td></td>
         <td></td>
         <td>
            <div id="week-<? echo $my_week ?>-<?php echo $x ?>">
            <?php echo  $week->my_days_arr[$x]->daily_hours?>
            </div>
         </td>
      </tr>
      <?php endfor?>
       <tr style="background-color: #CCFFAA;">

        <td>
        </td>
        <td>
        </td>
        <td>
        </td>
        <td>
        Week Over time
        </td>
        <td>
           <div id="week-<?php echo $my_week?>-overtime">
                     <?php echo $week->over_time;  ?>

           </div>
        </td>
        <td>
        Week Total
        </td>
         <td>
         <div id="week-<?php echo $my_week?>-total" >
          <?php echo $week->total_time;  ?>

        </div>

        </td>
        </tr>
     <?php $my_week++?>
    <?php endforeach?>
    <tr>
    <td>
    </td>
    <td>
    </td>
      <td>
    </td>
    <td>
     <div class="bold">
     Over time
     </div>
    </td>
        <td>

        <div id="two-week-overtime">  
        <?php echo $employee->two_week_over_time?>
         </div>
     </td> 
<td>
     <div class="bold">
     Total hours
     </div>
    </td>
        <td>

      <div id="two-week-total">
         <?php echo $employee->two_week_total?>
        
         </div>
     </td>
    <td>    
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
		   $().toastmessage('showWarningToast', "Time Disapproved");
		   }
		 });
   }

   function updateTimes(id,my_time,week)
   {

       var employee_id = <?php echo $employee->id ?>;
	   $.ajax({
		   url: "/TimeClocks/updateTimes/" +id +"?my_time="+my_time+"&employee_id="+employee_id+"&day="+week ,
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


function deletePunch(punch_id)
{
		$( "#dialog-confirm" ).dialog({
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				"Delete this punch?": function() {
				
					$("#row"+punch_id).hide('pulsate','fast');
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
}
function setWorkCode( punch_id )
{

       var work_code = $("#work_code"+punch_id).val();
     
	   $.ajax({
		   url: "/TimeClocks/setWorkCode/" +punch_id+"/"+work_code,
		   type:"post",
		   dataType: 'json',
		   success: function(data){
		   $("#pto_remaining").html( data.pto_remaining );
           $("#pto_remaining" ).effect("highlight", {"color":"green"}, 3000);
		   $("#sick_time_remaining").html( data.sick_time_remaining );
	       $("#sick_time_remaining" ).effect("highlight", {"color":"green"}, 3000);
		   $().toastmessage('showSuccessToast', "Work code successfully set");		   

		   }
		 });
   }    

  </script>
  <div id="dialog-confirm" title="Delete this punch?" style="display:none">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span> Are you sure?</p>
</div>