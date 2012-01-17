<?php
App::uses('AppController', 'Controller');
App::uses('Day', 'Vendor');
App::uses('MyEmployee', 'Vendor');
App::uses('Punch', 'Vendor');
App::uses('Employee', 'Model');
App::uses('EmployeesController', 'Controller');
/**
 * TimeClocks Controller
 *
 */
class TimeClocksController extends AppController {

    public function approve($id)
    {

     $this->TimeClock->id = $id;
     $this->TimeClock->saveField('approved',1);
    
     echo 'ok';
    $this->autoRender = false; 
    }

    public function disApprove($id)
    {
     $this->TimeClock->id = $id;
     $this->TimeClock->saveField('approved',0);

     echo 'ok';
     $this->render('/Layouts/plain'); 
    }
    public function updateTimes($id)
    {

    $my_time = $this->params['url']['my_time'];
    $employee_id = $this->params['url']['employee_id'];
    $pay_periods = EmployeesController::getPayPeriods();
    //debug( $pay_periods );
    $employee = new Employee($employee_id);
    $employee->read();
    //debug($employee);
    $temp  = new MyEmployee($employee->data);
    $temp->setWeeks($pay_periods['week_one_start']->format("Y-m-d"), $pay_periods['week_one_end']->format("Y-m-d"),$pay_periods['week_two_start']->format("Y-m-d"), $pay_periods['week_two_end']->format("Y-m-d"), $temp->id);
  
    $date = DateTime::createFromFormat("m-d-Y h:i a",$my_time);
    $date = $date->format("Y-m-d H:i:00");
    $day = $this->params['url']['day'];

     if (preg_match("/punch-out/",$id,$matches) )
     {
       
       $my_arr  = explode('punch-out', $id);
       $id = $my_arr[1];


       $this->TimeClock->read(null,$id);
       $this->TimeClock->set('punch_out',$date);
       $this->TimeClock->save();

     }
     else 
     {

       $my_arr  = explode('punch-in', $id);
       $id = $my_arr[1];

       $this->TimeClock->read(null,$id);
       $this->TimeClock->set('punch_in',$date);
       $this->TimeClock->save();
     	
     }
     //return the difference
    $this->TimeClock->findById( $id );
    $this->TimeClock->read();     
    $punch_in =  date_create( $this->TimeClock->data['TimeClock']['punch_in']);
    $punch_out = date_create( $this->TimeClock->data['TimeClock']['punch_out'] );
    $punch_time = $punch_out->diff($punch_in);
    $my_day = new Day(clone $punch_in,$this->TimeClock->data['TimeClock']['employee_id']);
    //get the total hours
    $week_one_total = $temp->week_one->total_seconds;
    $week_one_overtime = 0;
    if ( $week_one_total > 144000 )
    {
      $week_one_overtime = $week_one_total - 144000;
      $week_one_total = $week_one_total -  $week_one_overtime;
    }
    $week_two_total = $temp->week_two->total_seconds;
    $week_two_overtime = 0;
    if ( $week_two_total > 144000 )
    {
      $week_two_overtime = $week_two_total - 144000;
      $week_two_total = $week_two_total -  $week_two_overtime;
    }
    $two_week_total = $week_one_total + $week_two_total;
    $two_week_overtime = $week_one_overtime + $week_two_overtime;
    $week_one_total = MyEmployee::secondsToTime( $week_one_total );
    $week_one_overtime = MyEmployee::secondsToTime( $week_one_overtime) ;
    $week_two_total = MyEmployee::secondsToTime( $week_two_total );
    $week_two_overtime = MyEmployee::secondsToTime( $week_two_overtime );
    $two_week_total = MyEmployee::secondsToTime( $two_week_total );
    $two_week_overtime = MyEmployee::secondsToTime( $two_week_overtime );
    
    $return_arr = array('punch_time' => $punch_time->h.".".$punch_time->i, 'id' => $id ,
                        'daily_hours' => $my_day->daily_hours,
                        'week_one_total' => $week_one_total['h'].".".$week_one_total['m'],
                        'week_two_total' => $week_two_total['h'].".".$week_two_total['m'],                        
                        'week_one_overtime' => $week_one_overtime['h'].".".$week_one_overtime['m'], 
                        'week_two_overtime' => $week_two_overtime['h'].".".$week_two_overtime['m'],                        
                        'two_week_total' => $two_week_total['h'].".".$two_week_total['m'], 
                        'two_week_overtime' => $two_week_overtime['h'].".".$two_week_overtime['m'],
                        'day' => $day     

                        );
    echo json_encode($return_arr);
    $this->autoRender = false; 
    //$this->render("/Layouts/plain");
     
    }   
   public function getPunch()
   {
     $arr = $this->params['pass'];   
     $id = $arr[0];
     $week = $arr[1];
   	 $punch = new Punch($id); 
   	 $this->set('punch',$punch);
   	 $this->set('week',$week);
   	 $this->render('/Elements/punch',false);
   }
}
