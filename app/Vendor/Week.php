<?php
App::uses('TimeClock','Model');
App::uses('Day','Vendor');
 class Week 
{
    var $total_seconds;
    var $total_time;
    var $over_time;
    var $over_time_seconds;
	var $my_days_arr = array();
	var  $employee_id;
	var $uses = array('Department','Employee','TimeClock','DebugKit','Day' );
	function __construct($start_date,$end_date, $employee_id)
	{
	    $this->employee_id = $employee_id;
        $my_days = $this->GetDays($start_date,$end_date);

        for ( $x = 0; $x <  count( $my_days)  ; $x++)
        {
        	$this->my_days_arr[$x] = new Day( new DateTime($my_days[$x]),$employee_id);
            $this->total_seconds += $this->my_days_arr[$x]->daily_seconds;
        }

        $arr  = MyEmployee::secondsToTime($this->total_seconds);
        $this->total_time = $arr['h'].":".$arr['m'];
        $this->over_time = 0;
        if ( $this->total_seconds >  144000)
        {
 
        	$this->total_time = 40;
        	$this->over_time_seconds = $this->total_seconds - 144000;
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