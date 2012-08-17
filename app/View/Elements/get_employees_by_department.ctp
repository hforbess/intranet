<table width = '800' >
    <tr>
       <td width="20%">
       Name
       </td>
       <td width="20%">
       Unapproved times
       </td>
       <td width="20%">
       Total Hours
       </td>
       <td width="20%">
       Over time
       </td>
     </tr>
<?PHP foreach ( $my_employees as $emp ) : ?>
     <tr>
       <td width="20%">
       
        <?PHP echo $this->Html->link(  $emp->first_name . " ". $emp->last_name  , "/Employees/edit/". $emp->id ) ?> 
        </td>
       <td width="20%">
         <?php  echo $emp->unapproved_times['week_one'] + $emp->unapproved_times['week_two'];?>
        </td>
       <td width="20%">
         <?php $emp->two_week_over_time?>

        </td>
       <td width="20%">
         <?php $emp->two_week_total?>
        </td>
     </tr>
<?PHP endforeach ?>

<script>
$(function(){
    $( "#accordion" ).accordion("resize");		
});

 </script>
