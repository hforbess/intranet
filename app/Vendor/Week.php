<?php
App::uses('TimeClock','Model');
App::uses('Day','Vendor');
 class Week 
{
    var $total_regular_seconds;
    var $total_regular_time;
    var $over_time;
    var $over_time_seconds;
	var $my_days_arr = array();
	var $employee_id;
	var $regular_week_seconds = 0;
	var $sick_week_seconds = 0;
	var $other_hours_week_seconds = 0;
	var $holiday_week_seconds = 0;
	var $vacation_week_seconds = 0;  
    var $total_all_seconds;
    var $total_all_time = 0;
	var $uses = array('Department','Employee','TimeClock','DebugKit','Day' );
	function __construct($start_date,$end_date, $employee_id)
	{
	    $this->employee_id = $employee_id;
        $this->week_sick_time = 0;

	    $my_days = $this->GetDays($start_date,$end_date);

        for ( $x = 0; $x <  count( $my_days  ); $x++)
        {
        	$this->total_all_seconds = 0;
        	$this->my_days_arr[$x] = new Day( new DateTime($my_days[$x]),$employee_id);
		       for ( $y = 0; $y < count( $this->my_days_arr[$x]->punches ); $y++ )
		       {

		       	switch( $this->my_days_arr[$x]->punches[$y]->work_code )
		       	 {
		       	 	
		       	 	case 'sick':
		       	 	$this->sick_week_seconds += $this->my_days_arr[$x]->punches[$y]->total_time_seconds;
		       	 	$this->total_all_seconds += $this->sick_week_seconds;
		       	 	case  'other hours':
		       	 	$this->other_hours_week_seconds += $this->my_days_arr[$x]->punches[$y]->total_time_seconds;
		       	 	$this->total_all_seconds += $this->other_hours_week_seconds;	
		       	 	break;
		       	 	case 'vacation':
					$this->vacation_week_seconds += $this->my_days_arr[$x]->punches[$y]->total_time_seconds;
		       	 	$this->total_all_seconds += $this->vacation_week_seconds;	
					break;		       	 	
		       	 	case 'july 4':
		       	 	case 'thanksgiving':
		       	 	case 'new year':
		       	 	case 'christmas':
		       	 	case 'labor day':
		       	 	case 'memorial day':
		       	 	
		       	 	$this->holiday_week_seconds += $this->my_days_arr[$x]->punches[$y]->total_time_seconds;
		       	 	$this->total_all_seconds += $this->holiday_week_seconds;
		       	 	break;	      	 			       	 		
		       	 	default;
		       	 	$this->regular_week_seconds += $this->my_days_arr[$x]->punches[$y]->total_time_seconds;
		       	 	$this->total_all_seconds += $this->regular_week_seconds;
		       	 	break;
		       	 }
		       	
		       }
        }

        $arr  = MyEmployee::secondsToTime($this->regular_week_seconds);
        $this->total_regular_time = $arr['h'].":".$arr['m'];
        $this->over_time = 0;
        $this->over_time_seconds = 0;
       
        if ( $this->regular_week_seconds >  144000)
        {
         	$this->total_regular_time_ = 40;
        	$this->over_time_seconds = $this->regular_week_seconds - 144000;
        	$arr = MyEmployee::secondsToTime($this->over_time_seconds);
        	$this->over_time = $arr['h'].":".$arr['m'];
        }

	}
	
    function GetDays($sStartDate, $sEndDate){  
      // Firstly, format the provided dates.  
      // This function works best with YYYY-MM-DD  
      // but other date formats will work thanks  
      // to strtotime().  
      $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));  
      $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));  
      
      // Start the variable off with the start date  
      $aDays[] = $sStartDate;  
      
      // Set a 'temp' variable, sCurrentDate, with  
      // the start date - before beginning the loop  
      $sCurrentDate = $sStartDate;  
      
      // While the current date is less than the end date  
      while($sCurrentDate < $sEndDate){  
        // Add a day to the current date  
        $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));  
      
        // Add this new day to the aDays array  
        $aDays[] = $sCurrentDate;  
      }  
      
      // Once the loop has finished, return the  
      // array of days.  
      return $aDays;  
    }  
}
?>