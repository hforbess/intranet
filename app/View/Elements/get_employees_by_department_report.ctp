<table width = '800' >
  <tr>
    <td>EE#</td>
    <td>Name</td>
    <td>REG</td>
    <td>OT</td>
    <td>SICK</td>
    <td>HOL</td>
    <td>VAC</td>
    <td>TOT</td>
    <td>Mileage</td>
    <td>Phone</td>
    <td>Formeman</td>
    <td>Commission</td>
  </tr>
<?PHP foreach ( $my_employees as $emp ) : ?>
     <tr>
     <td>
      <?php echo $emp->employee_number?>
     </td>
       <td>
       
        <?PHP echo $this->Html->link(  $emp->first_name . " ". $emp->last_name  , "/Employees/edit/". $emp->id ) ?> 
        </td>
       <td>
         <?php  echo $emp->two_week_total;?>
        </td>
       <td>
         <?php echo $emp->two_week_over_time?>

        </td>
       <td>
         <?php echo $emp->two_week_total_sick_time ?>

        </td>
       <td>
         <?php echo $emp->two_week_holiday_time  ;?>
        </td>
       <td>
         <?php echo $emp->two_week_vacation_time  ;?>
        </td>
       <td>
         <?php echo $emp->total_all_time ;?>
        </td>
     </tr>
<?PHP endforeach ?>

<script>
$(function(){
    $( "#accordion" ).accordion("resize");		
});

 </script>
