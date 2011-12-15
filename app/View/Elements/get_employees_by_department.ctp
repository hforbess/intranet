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
     </tr>
<?PHP foreach ( $my_employees as $emp ) : ?>
     <tr>
       <td width="30%">
        <?PHP echo $this->Html->link(  $emp->first_name . " ". $emp->last_name  , "/Employees/view/". $emp->id ) ?> 
        </td>
       <td width="30%">
         <?php echo $emp->unapproved_times;?>
        </td>
       <td width="30%">
         <?php $arr =  $emp->secondsToTime ( $emp->total_hours )?>
         <?php echo $arr["h"].".". $arr["m"]?>
        </td>
     </tr>
<?PHP endforeach ?>


