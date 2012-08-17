function myAjax( url )
{
  $.ajax({
		  url: "test.html",
		  context: document.body,
		  success:function(data)
		  {
	        alert('worked');
		  }
		}).done(function() { 
		  
		});
}