<?php echo $this->Html->script('my_functions'); ?>
<style>
.supp tr:nth-child(even) {background-color: #F5F3E5}
.supp tr:nth-child(odd) {background-color: #CCFFAA}
.supp th{font-weight:bold;}

</style>
<table class="supp" id="supplemental-table">
    <th>
    </th>
    
    <th>
      Date
      
    </th>
    <th>
      Type
    
     </th>
     </th>
      <th>
    Amount
     </th>
 

<?php foreach ( $supplemental as $sup ) :?>
<tr id="row<?Php echo $sup['EditSupplemental']['id'];?>" >
<td width="10">
<?php if ( $employee->group_id != 3 ) :?>
<ul class="ui-widget ui-helper-clearfix"><li class="ui-state-error ui-corner-all">
<span id="delete<?php echo $sup['EditSupplemental']['id'];?>" class="ui-icon ui-icon-minus"> </span></li></ul>
<script>
  $(function(){
      $("#delete<?php echo $sup['EditSupplemental']['id'];?>").click(function(){
         
          deleteSupplemental(<?php echo $sup['EditSupplemental']['id'];?>,<?php echo $sup['EditSupplemental']['staff_id'];?>  );
	      });
    });

</script>
<?php endif?>
</td>
    <td>   <?php //debug( $sup); ?>  
       <?php echo $sup['EditSupplemental']['date']; ?>
    
    </td>
    <td>

           <?php echo $sup['EditSupplemental']['type']; ?>
    </td> 
    <td>

        <?php echo $sup['EditSupplemental']['amount']; ?>   

    </td>    
    </tr>
<?php endforeach;?>
<?php if ( $employee->group_id != 3 ) :?>
<tr id="add-row">
   <td>
      <ul class="ui-widget ui-helper-clearfix"><li class="ui-state-default ui-corner-all">
	   <span id="add-sup" class="ui-icon ui-icon-plus"> </span>
	
	   </li>
	 </ul>


  <td>
  Date: <input id="datepicker-supplemental" type="text">
<script>
	$(function() {
		$( "#datepicker-supplemental" ).datepicker({ dateFormat: "yy-mm-dd", });
		$( "#datepicker-supplemental" ).datepicker( "setDate" , "<?php echo $pay_period_end?>" )
	});
	</script>
   <script>
	    $(function(){
          $("#add-sup").click(function(){
				$.ajax({
					  url: "/Employees/addSupplemental/"+$("#staff_id").val()+"/"+ $("#type").val()+"/"+$("#amount").val()+"/"+$("#datepicker-supplemental").val(),
					  context: document.body,
					  dataType:"html",
					  success: function(data){
                      
                      //var obj = jQuery.parseJSON(JSON.stringify(data));
                      $("#add-row").before(data);

					  }
					});              

              });

		    });
	   </script>
 </td>
 <td>
<select id="type">
  <option value="Mileage">Mileage</option>
    <option value="Foreman">Foreman</option>
       <option value="Phone">Phone</option>
       <option value="Commission">Commmission</option>
</select>

 </td>
 <td>
 <input type="hidden" id="staff_id" value="<?php echo $employee_id?>" >
 <input type="text" size="20" id="amount" value= "0.00">
 </td>
 </tr>
 <?php endif?>
 <tr>
 <td></td>
 <td></td>
 <td></td>
 <td>
 <div id="supplemental-total">
   <?php echo  $supplemental_total; ?>
 </div>
 </td>
 </tr>				     
</table>
<script>

		function deleteSupplemental( id,staff_id )
		{

			$("#dialog-confirm").dialog({
					resizable: false,
					height:140,
					modal: true,
					buttons: {
						"Delete this punch?": function() {
						
							$("#row"+id).hide('pulsate','fast');
							$( this ).dialog( "close" );
							$.ajax({
								  url: "/Employees/deleteSupplemental/"+id+"/"+staff_id,
								  context: document.body,
								  success: function(){
		                        //even tho its deleted, use it anyway to trigger updateTimes
		                        //updateTimes("punch-out"+punch_id,my_time, day, week);
								  }
								});
						},
						Cancel: function() {
							$( this ).dialog( "close" );
						}
					}
				});
		}
		</script>
		  <div id="dialog-confirmusup" title="Delete this punch?" style="display:none">
			<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span> Are you sure?</p>
		</div>
