<tr id="row<?Php echo $data['id'];?>" >
<td width="10">
<ul class="ui-widget ui-helper-clearfix"><li class="ui-state-error ui-corner-all">
<span id="delete<?php echo $data['id'];?>" class="ui-icon ui-icon-minus"> </span></li></ul>

<script>


  $(function(){
      $("#delete<?php echo $data['id'];?>").click(function(){
         
          deleteSupplemental(<?php echo $data['id'] ?>,<?php echo $data['staff_id'];?>  );
	      });
    });

</script>
</td>
    <td>   <?php //debug( $sup); ?>  
   <?php echo $data['date']; ?>
      

    </td>
    <td>
  <?php echo $data['type']; ?>
    

    </td> 
    <td>

       <?php echo $data['amount']; ?>
     
    </td>    
    </tr>