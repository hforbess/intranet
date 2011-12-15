
function loadDepartment(id)
{
    $("#dept"+ id).load('/Employees/getEmployeesByDepartment/'+id)	
}
