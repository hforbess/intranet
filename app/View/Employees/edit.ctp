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
	<script>
	$(function() {
		$( "#tabs" ).tabs({
			cache: true,
			select: function(event, ui) {

		    },
			ajaxOptions: {
				error: function( xhr, status, index, anchor ) {
					$( anchor.hash ).html(
						"Couldn't load this tab. We'll try to fix this as soon as possible. " +
						"If this wouldn't be a demo." );
				},
				
			}
		});
	});
	</script>
<div id="tabs" style="width:980px;">
	<ul>
	   <li><a href="/Employees/accordion_home">Home</a></li>
		<li><a href="#tabs-1">Time Sheet</a></li>
		<li><a href="/Employees/supplementalIndex/<?php echo $employee->id?>">Supplemental Earnings</a></li>
		<li><a href="/Employees/accordion_forms">H/R and forms</a></li>
		<?php if ( $user != 'user') :?>
		<li><a href="/Employees">Exceptions</a></li>
		<li><a href="/Employees">Admin Reports</a></li>
		<li><a href="ajax/content4-broken.php">Audit log</a></li>

		<?php endif?>
	
	</ul>
<div id="tabs-1">
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
		
		<table cellspacing = '10' width="100%" id="my-table">
		
		
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
		 <?php //Debugger::dump( $punch->punch_in )?>
		     
		     <tr id="punch<?php echo $punch->id ?>">
		     
		     </tr>
		     <script>
		       $(function(){
		           $("#punch<?php echo $punch->id ?>").load("/TimeClocks/getPunch/"+<?php echo $punch->id ?>+"/"+<? echo $x ?>+"/"+<?php echo $my_week ?>);
		               
		           })
		     </script>
		     <?php endforeach ?>
		     <?php endif ?>
		     </div>

		      <tr>
		          <td>
		          <?php if( $user != 'user') :?>
		          <ul class="ui-widget ui-helper-clearfix"><li class="ui-state-default ui-corner-all"><span class="ui-icon ui-icon-plus" id="new<?php echo $week->my_days_arr[$x]->my_date->format("Y-m-d") ?>" ></span></li></ul>
		          <?php endif?>
		          </td>
		          <script>
		             $(function(){
		                
		               $("#new<?php echo $week->my_days_arr[$x]->my_date->format("Y-m-d") ?>").click(function(){
		            	   var where =$(this).parents("tr").eq(0)
							$.ajax({
								  url: "/TimeClocks/addPunch/"+<?php echo $employee->id ?>+"/<?php echo $week->my_days_arr[$x]->my_date->format("Y-m-d") ?>",
								  context: document.body,
								  success: function(data){
								  
								 $("<tr id=\"punch"+data+"\"></tr>").insertBefore(where);
		

								 $("#punch"+data).load("/TimeClocks/getPunch/" + data+"/"+<?php echo $x?>+"/"+<?php echo $my_week?>,function(){ 
									 updateTimes( "punch-in"+data,$("#punch-in"+data).val(), <?php echo $x?>, <?php echo $my_week?>);
									
								 });
								  }
								});
		
		                   });
		                 
		                 } );
		          </script>
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
		          <?php echo $week->total_regular_time   ?>
		
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
		
	</div>
</div>

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

   function updateTimes(id,my_time,day,week)
   {
  
       var employee_id = <?php echo $employee->id ?>;
	   $.ajax({
		   url: "/TimeClocks/updateTimes/" +id +"?my_time="+my_time+"&employee_id="+employee_id+"&day="+day+"&week="+week ,
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
           $("#week-"+week+"-"+day).html(data.daily_hours);
           //console.log( data );
           //console.log( day );
           //console.log( week);
           $("#week-"+week+"-"+day).effect("highlight", {"color":"green"}, 3000);
		   $().toastmessage('showSuccessToast', "Time updated successfully");
		   }
		 });
   }


function deletePunch(punch_id, my_time, day,week)
{
	 $( "#dialog:ui-dialog" ).dialog( "destroy" );
	$( "#dialog-confirm" ).dialog({
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				"Delete this punch?": function() {
				
					$("#punch"+punch_id).hide('pulsate','fast');
					$( this ).dialog( "close" );
					$.ajax({
						  url: "/TimeClocks/deletePunch/"+punch_id,
						  context: document.body,
						  success: function(){
                        //even tho its deleted, use it anyway to trigger updateTimes
                        updateTimes("punch-out"+punch_id,my_time, day, week);
						  }
						});
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