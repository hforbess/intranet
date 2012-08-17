<?php
App::uses('TimeClock','Model');
App::uses('Punch','Vendor');
class Day 
{
	var $my_date;
	var $punches;
	var $daily_hours;
	var $day_of_week;
	var $employee_id;
	var $daily_seconds;
	var $unapproved;
	var $work_code;
	var $uses = array('Department','Employee','TimeClock','DebugKit','Punch' );
	function __construct($my_date,$employee_id)
	{
	    $this->employee_id = $employee_id;
	 
	    $this->my_date = $my_date;

		$this->day_of_week = $my_date->format("l");
       
        $clock = new TimeClock();
		$temp_punches = $clock->find('all',array('conditions' => 
		                  array('employee_id' => $employee_id,
		                  'DATE(punch_in) =' => $my_date->format('Y-m-d'),
		                  'deleted' => 0,
		                 )));
        
         $this->daily_hours = 0;
         $this->daily_seconds;
         $this->unapproved = 0;

		 foreach ($temp_punches as $punch)
		 {   

		 	$temp = new Punch($punch['TimeClock']['id']);
	
		    $this->daily_seconds += $temp->total_time_seconds ;

		     if ( $temp->approved  == 0 )
		     {
		     	$this->unapproved++;
		     }

		     $daily_hours = MyEmployee::secondsToTime( $this->daily_seconds );
 
		     $this->daily_hours = $daily_hours['h'].".".$daily_hours['m'] ;
		     $this->punches[] = $temp;
		    
		 }
		     $daily_hours = MyEmployee::secondsToTime( $this->daily_seconds );
 
		     $this->daily_hours = $daily_hours['h'].".".$daily_hours['m'] ;
		//debug( $this->punches);
	}
}
?>