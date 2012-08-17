  
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
 