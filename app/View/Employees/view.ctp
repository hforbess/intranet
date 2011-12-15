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
      <?PHP echo $employee->pay_periods['current_start']->format("m-d-Y") ?>
     </td>
    <td>
    <?PHP echo $employee->pay_periods['current_end']->format("m-d-Y") ?>
     </td>

  </tr>
</table>

<table cellspacing = '10' width="100%">
   <tr>
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
   </tr>
    <?php foreach($employee->times as $punch):?>
    <tr>
        <td>
        <?php echo date("m-d-Y h:i A",strtotime($punch['TimeClock']['punch_in'] ))?> 
        </td>
        <td>
           <?php echo date("m-d-Y h:i A",strtotime($punch['TimeClock']['punch_out']))?>
        </td>
         <td>
           <?php $arr  =  $employee->secondsToTime(  strtotime( date ($punch['TimeClock']['punch_out'] ) ) - strtotime ( date ( $punch['TimeClock']['punch_in'] ) ))?>
           <?php echo $arr["h"].".". $arr["m"]?>
        </td>
        <td>
            <?php echo $punch['TimeClock']['approved'] == 1 ? "Yes" : "No"?>
        </td>
    </tr>
    <?php endforeach;?>
    <tr>
    <td>
     <div class="bold">
     Total hours
     </div>
    </td>
        <td>
     <?PHP $arr =  $employee->secondsToTime( $employee->total_hours ) ?>
     <?php echo $arr["h"].".". $arr["m"]?>
     </td>
    <td>
     <div class="bold">
     Over time
     </div>
    </td>
        <td>
     <?PHP $arr =  $employee->secondsToTime( $employee->over_time ) ?>
     <?php echo $arr["h"].".". $arr["m"]?>
     </td>     
    </tr>
</table>
  </div>