<table width = '100%' >
    <tr>
       <td width="30%">
       Name
       </td>
       <td width="30%">
       Unapproved times
       </td>
       <td width="30%">
       Total Hours
       </td>
       <td width="30%">
       Over time
       </td>
     </tr>
<?PHP foreach ( $my_employees as $emp ) : ?>
     <tr>
       <td width="30%">
      
        <?PHP echo $this->Html->link(  $emp->first_name . " ". $emp->last_name  , "/Employees/edit/". $emp->id ) ?> 
        </td>
       <td width="30%">
         <?php echo $emp->unapproved_times['week_one'] + $emp->unapproved_times['week_two'];?>
        </td>
       <td width="30%">
         <?php $arr =  $emp->secondsToTime ( $emp->total_hours['week_one'] +  $emp->total_hours['week_two'] )?>
         <?php echo $arr["h"].".". $arr["m"]?>
        </td>
       <td width="30%">
         <?php $arr =  @$emp->secondsToTime ( @$emp->over_time['week_one'] +  @$emp->over_time['week_two'] )?>
         <?php echo $arr["h"].".". $arr["m"]?>
        </td>
     </tr>
<?PHP endforeach ?>


