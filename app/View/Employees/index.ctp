<?PHP $this->Html->script('load_department'); ?>
<?PHP foreach ( $departments as $department ) : ?>
<?PHP $id = $department['Department']['id']; ?>
<h2> <?PHP echo $department['Department']['department_name']; ?> </h2>
<div id="dept<?PHP echo $id ?>" ></div>
<script>
      $(function(){
    	  $("#dept"+ <?PHP echo $id ?>).load('/Employees/getEmployeesByDepartment/'+<?PHP echo $id ?>)	
      
      });
</script>      
<?PHP endforeach ?>





