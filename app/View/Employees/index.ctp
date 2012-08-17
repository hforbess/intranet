<script>
if ( $( "#tabs" ).tabs( "option", "selected" ) == 2 ){
$(function() {
		$( "#accordion" ).accordion({ fillSpace: true ,active: 2, clearStyle: true});
		$( "#accordion" ).accordion( "option", "fillSpace", false );
		$( "#accordion" ).accordion( "option", "autoHeight" ,false );
	
		$( "#accordion" ).accordion({
			   change: function(event, ui) {
			$( "#accordion" ).accordion( "resize" );

			   }
			});

	});
}
	</script>
<?PHP $this->Html->script('load_department'); ?>
<div id="accordion" style="width:960px;">
<?PHP foreach ( $departments as $department ) : ?>
<?PHP $id = $department['Department']['id']; ?>

<h3><a href="#"> <?PHP echo $department['Department']['department_name']; ?></a> </h3>
<div style="display:block">
	<div id="dept<?PHP echo $id ?>" ></div>
	<script>
	var type = '';
	if ( $( "#tabs" ).tabs( "option", "selected" ) == 4  )
	{
       type = 'report'; 
	}
	      $(function(){
	    	  $("#dept"+ <?PHP echo $id ?>).load('/Employees/getEmployeesByDepartment/'+<?PHP echo $id ?>+'?type='+type)	
	    	 
	      });


	</script>
</div>      
	<?PHP endforeach ?>
<script>
// $( "#accordion" ).accordion("resize");	
 </script>
</div>



