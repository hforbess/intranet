<?php
App::uses('TimeClock','Model');
App::uses('MyEmployee','Vendor');
class Punch
{
	 public $punch_in;
	 public $punch_out;
	 public $punch_in_unix;
	 public $punch_out_unix;
	 public $total_time_seconds;
	 public $total_time;
	 public $id;
	 public $employee_id;
	 public $status;
	 public $work_code;
	 public $approved;
	 var $uses = array('Department','Employee','TimeClock','DebugKit' );
	 public function __construct( $id)
	 {

	  $this->id = $id;	  
	  $clock = new TimeClock();
	  $punch =  $clock->find('first', array('conditions' => array('id' => $id)));
	  $this->employee_id = $punch['TimeClock']['employee_id'];
	  $this->status = $punch['TimeClock']['status'];
	  $this->approved = $punch['TimeClock']['approved'];
	  $this->work_code = $punch['TimeClock']['work_code'];
   	  $this->punch_in = new DateTime($punch['TimeClock']['punch_in']);
      $this->punch_out = new DateTime($punch['TimeClock']['punch_out']);
      $this->punch_in_unix = mktime( $this->punch_in->format("H"),$this->punch_in->format("i"),0,$this->punch_in->format("n"),$this->punch_in->format("j"),$this->punch_in->format("y"));
      $this->punch_out_unix = mktime( $this->punch_out->format("H"),$this->punch_out->format("i"),0,$this->punch_out->format("n"),$this->punch_out->format("j"),$this->punch_out->format("y"));
      $this->total_time_seconds = $this->punch_out_unix - $this->punch_in_unix;
      $arr = MyEmployee::secondsToTime($this->total_time_seconds);
      $this->total_time = $arr['h'].":".$arr['m'];
      

	 }
	
}