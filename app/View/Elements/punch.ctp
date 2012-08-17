
			    <td><?php if ( ! $read_only ) :?>
			   <ul class="ui-widget ui-helper-clearfix"><li class="ui-state-default ui-corner-all">
			     <span class="ui-icon ui-icon-minus" id="delete<?php echo $punch->id?>" > </span></li></ul>
			   <script>
			    $(function(){
                    $("#delete<?php echo $punch->id?>").click(function(){
                          deletePunch( <?php echo $punch->id?>,"<?php echo $punch->punch_out->format("m-d-Y h:i A")?>",<?php echo $day?>,<?php echo $week ?> );

                        });
				    })
			   </script>
			   <?php endif?>
			     </td>
			         <td>
			        <input id="punch-in<?php echo $punch->id?>" type="text" value="<?php echo $punch->punch_in->format("m-d-Y h:i A") ?>" />
			        <script>
			        $(function(){
			             $("#punch-in<?php echo $punch->id?>").datetimepicker({
			                 ampm:true,
			                 <?php if ($read_only ) :?>
			                 disabled:true,
			                 <?php endif?>
			                 onClose:function(dateText,inst)
			                 {
			                  updateTimes(inst.id, dateText,<?php echo $day?>,<?php echo $week ?>);
			                  },
			                 dateFormat: 'mm-dd-yy'
			                });
			            })
			        </script>
			        </td>
			        <td>
			        <input id="punch-out<?php echo $punch->id?>" type="text" value="<?php echo $punch->punch_out->format("m-d-Y h:i A") ?>" />
			        <script>
			        $(function(){
			             $("#punch-out<?php echo $punch->id?>").datetimepicker({
			                  ampm:true,
				                 <?php if ($read_only ) :?>
				                 disabled:true,
				                 <?php endif?>			                 
			                  onClose:function(dateText,inst)
			                  {
			                  updateTimes(inst.id, dateText,<?php echo $day?>,<?php echo $week ?>);
			                   },
			                  dateFormat: 'mm-dd-yy'
			                 });
			            })
			        </script>
			        </td>
			         <td>

			<div id="punch_total<?php echo $punch->id?>" >
			<?php echo $punch->total_time?>
			</div>
			</td>
			
			<td>
			<div id="approve_status<?php echo $punch->id ?>" style="display:inline;"> <?php echo $punch->approved == 1 ? "Yes" : "No"?></div>
			<script>
			$(function(){
			$("#approve_status<?php echo $punch->id ?>").css("color","<?php echo $punch->approved == 1 ? "green" : "red"?>" );
			})
			</script>
            <?php if ( ! $read_only ) :?>
			<input type="checkbox" id="approved<?php echo $punch->id ?>" style="display:inline;" <?php echo $punch->approved == 1 ? "checked='checked'" : ""?> />
			
			<script>
			$("#approved<?php echo $punch->id ?>").click (function ()
			{
			var thisCheck = $(this);
			if (thisCheck.is (':checked'))
			{
			approve(<?php echo $punch->id ?>)
			}
			else
			{
			disApprove(<?php echo $punch->id ?>)
			}
			});
			</script>
			<?php endif?>
			</td>
			<td>
                       <select id="work_code<?php echo $punch->id ?>"<?php if( $read_only ){ echo " disabled=\"disabled\""; }?>>
						<option value=""></option>
						<option value="bereavement">Bereavement</option>
						<option value="july 4th">July 4th</option>
						<option value="labor day">Labor Day</option>
						<option value="memorial day">Memorial Day</option>
						<option value="new year">New Years</option>
						<option value="other hours">Other Hours</option>
						<option value="sick">Sick</option>
						<option value="thanksgiving">Thanksgiving</option>
						<option value="vacation">Vacation</option>
						<option value="christmas">Christmas</option>
						</select>
						
						<script>
	
						   $("#work_code<?php echo $punch->id ?>").val("<?php echo $punch->work_code?>");
						   $("#work_code<?php echo $punch->id ?>").change(function(){
                               setWorkCode( <?php echo $punch->id ?> );
                               

							   });
						</script>
			</td>
			<td>

			</td>
